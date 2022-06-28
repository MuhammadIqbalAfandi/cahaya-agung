<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Ppn;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockProduct;
use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Purchase::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Purchases/Index.vue', [
            'initialSearch' => request('search'),
            'purchases' => Purchase::filter(request()->only('search'))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn($purchase) => [
                    'id' => $purchase->id,
                    'updatedAt' => $purchase->updated_at,
                    'number' => $purchase->number,
                    'status' => $purchase->status,
                    'price' => $purchase->purchaseDetail->price,
                    'ppn' => $purchase->purchaseDetail->ppn,
                    'qty' => $purchase->purchaseDetail->qty,
                    'productName' => $purchase->product->name,
                    'productNumber' => $purchase->product->number
                ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Purchases/Create', [
            'number' => 'PBN' . now()->format('YmdHis'),
            'ppn' => Ppn::first()->ppn,
            'productNumber' => Inertia::lazy(
                fn() => 'PDK' . now()->format('YmdHis')
            ),
            'suppliers' => Inertia::lazy(
                fn() => Supplier::filter(['search' => request('supplier')])
                    ->get()
            ),
            'products' => Inertia::lazy(
                fn() => Product::filter(['search' => request('product')])
                    ->get()
            )
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->safe()->merge([
                'user_id' => auth()->user()->id,
                'ppn' => Ppn::first()->getRawOriginal('ppn')
            ])->all();

            $purchase = Purchase::create($validated);

            $purchase->purchaseDetail()->create($validated);

            DB::commit();

            return back()->with('success', __('messages.success.store.purchase'));
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', __('messages.error.store.purchase'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        return inertia('Purchases/Edit', [
            'purchase' => [
                'id' => $purchase->id,
                'number' => $purchase->number,
                'status' => $purchase->status,
                'price' => $purchase->purchaseDetail->getRawOriginal('price'),
                'qty' => $purchase->purchaseDetail->qty,
                'ppn' => $purchase->purchaseDetail->ppn,
                'supplier' => $purchase->supplier,
                'product' => $purchase->product
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            $purchase->update($request->validated());

            $purchase->purchaseDetail()->update($request->safe()->except('status'));

            if ($request->status === 'success') {
                StockProduct::create([
                    'purchase_number' => $purchase->number,
                    'qty' => $request->qty,
                    'product_number' => $purchase->purchaseDetail->product_number
                ]);
            }

            DB::commit();

            return back()->with('success', __('messages.success.update.purchase'));
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', __('messages.error.update.purchase'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
