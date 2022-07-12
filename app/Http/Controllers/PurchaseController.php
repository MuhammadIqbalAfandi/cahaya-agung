<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Ppn;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockProduct;
use App\Models\Supplier;
use App\Services\HelperService;
use App\Services\PurchaseService;
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
        return inertia("Purchases/Index", [
            "initialSearch" => request("search"),
            "purchases" => Purchase::filter(request()->only("search"))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($purchase) => [
                        "id" => $purchase->id,
                        "updatedAt" => $purchase->updated_at,
                        "email" => $purchase->supplier->email,
                        "name" => $purchase->supplier->name,
                        "phone" => $purchase->supplier->phone,
                        "price" => HelperService::setRupiahFormat(
                            PurchaseService::totalPrice($purchase)
                        ),
                        "status" => $purchase->status,
                    ]
                ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia("Purchases/Create", [
            "number" => "PBN" . now()->format("YmdHis"),
            "ppn" => Ppn::first()->ppn,
            "productNumber" => "PDK" . now()->format("YmdHis"),
            "suppliers" => Inertia::lazy(
                fn() => Supplier::filter([
                    "search" => request("supplier"),
                ])->get()
            ),
            "products" => Inertia::lazy(
                fn() => Product::filter(["search" => request("product")])->get()
            ),
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
            $ppn = Ppn::first()->ppn;

            $validated = $request
                ->safe()
                ->merge([
                    "user_id" => auth()->user()->id,
                    "ppn" => $request->ppn ? $ppn : 0,
                ])
                ->all();

            $purchase = Purchase::create($validated);

            foreach ($request->products as $product) {
                $validated = [
                    "product_number" => $product["number"],
                    "price" => $product["price"],
                    "qty" => $product["qty"],
                ];

                $purchase->purchaseDetail()->create($validated);
            }

            DB::commit();

            return back()->with(
                "success",
                __("messages.success.store.purchase")
            );
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with("error", __("messages.error.store.purchase"));
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
        return inertia("Purchases/Edit", [
            "id" => $purchase->id,
            "number" => $purchase->number,
            "ppn" => Ppn::first()->ppn,
            "status" => $purchase->status,
            "productNumber" => "PDK" . now()->format("YmdHis"),
            "ppnChecked" => $purchase->ppn ? true : false,
            "supplier" => $purchase->supplier,
            "products" => Inertia::lazy(
                fn() => Product::filter(["search" => request("product")])->get()
            ),
            "purchaseDetail" => $purchase->purchaseDetail->transform(
                fn($purchase) => [
                    "id" => $purchase->id,
                    "number" => $purchase->product_number,
                    "name" => $purchase->product->name,
                    "price" => $purchase->price,
                    "qty" => $purchase->qty,
                    "unit" => $purchase->product->unit,
                ]
            ),
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
            $ppn = Ppn::first()->ppn;

            $validated = $request
                ->safe()
                ->merge([
                    "ppn" => $request->ppn ? $ppn : 0,
                ])
                ->all();

            $purchase->update($validated);

            foreach ($request->products as $product) {
                $validated = [
                    "product_number" => $product["number"],
                    "price" => $product["price"],
                    "qty" => $product["qty"],
                ];

                if (!empty($product["label"])) {
                    if ($product["label"] == "add") {
                        $purchase->purchaseDetail()->create($validated);
                    }

                    if ($product["label"] == "edit") {
                        $purchase->purchaseDetail
                            ->find($product["id"])
                            ->update($validated);
                    }

                    if ($product["label"] == "delete") {
                        $purchase->purchaseDetail
                            ->find($product["id"])
                            ->delete();
                    }
                }

                if ($request->status == "success") {
                    $validated = [
                        "purchase_number" => $purchase->number,
                        "price" => $product["price"],
                        "qty" => $product["qty"],
                        "product_number" => $product["number"],
                    ];

                    StockProduct::create($validated);
                }
            }

            DB::commit();

            return back()->with(
                "success",
                __("messages.success.update.purchase")
            );
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with("error", __("messages.error.update.purchase"));
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
