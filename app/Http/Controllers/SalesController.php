<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sales\StoreSaleRequest;
use App\Http\Requests\Sales\UpdateSaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Sale::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Sales/Index', [
            'initialSearch' => request('search'),
            'sales' => Sale::filter(request()->only('search'))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn($sale) => [
                    'id' => $sale->id,
                    'updatedAt' => $sale->updated_at,
                    'number' => $sale->number,
                    'status' => $sale->status,
                    'price' => $sale->saleDetail->price,
                    'ppn' => $sale->saleDetail->ppn,
                    'qty' => $sale->saleDetail->qty,
                    'productName' => $sale->product->name,
                    'productNumber' => $sale->product->number
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
        return inertia('Sales/Create', [
            'number' => 'PJN' . now()->format('YmdHis'),
            'productNumber' => Inertia::lazy(
                fn() => 'PDK' . now()->format('YmdHis')
            ),
            'customers' => Inertia::lazy(
                fn() => Customer::filter(['search' => request('customer')])
                    ->get()
                    ->transform(fn($customer) => [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'address' => $customer->address,
                        'npwp' => $customer->npwp
                    ])),
            'products' => Inertia::lazy(
                fn() => Product::filter(['search' => request('product')])
                    ->get()
                    ->transform(fn($product) => [
                        'id' => $product->id,
                        'number' => $product->number,
                        'name' => $product->name,
                        'unit' => $product->unit
                    ])
            )
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->safe()->merge([
                'user_id' => auth()->user()->id,
                'ppn' => 11
            ])->all();

            $sale = Sale::create($validated);

            $sale->saleDetail()->create($validated);

            DB::commit();

            return back()->with('success', __('messages.success.store.sale'));
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', __('messages.error.store.sale'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        return inertia('Sales/Edit', [
            'sale' => [
                'id' => $sale->id,
                'number' => $sale->number,
                'status' => [
                    'value' => $sale->status
                ],
                'price' => $sale->saleDetail->getRawOriginal('price'),
                'qty' => $sale->saleDetail->qty,
                'customer' => $sale->customer,
                'product' => $sale->product
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        dd($request->validated());

        DB::beginTransaction();

        try {
            DB::commit();

            return back()->with('succes', __('messages.success.update.sale'));
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', __('messages.error.update.sale'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
