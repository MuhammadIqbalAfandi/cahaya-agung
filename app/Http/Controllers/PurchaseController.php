<?php

namespace App\Http\Controllers;

use App\Models\Ppn;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\StockProduct;
use App\Models\PurchaseDetail;
use App\Services\HelperService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;

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
                        "name" => $purchase->supplier->name,
                        "phone" => $purchase->supplier->phone,
                        "email" => $purchase->supplier->email,
                        "price" => HelperService::setRupiahFormat(
                            $purchase->purchaseDetail->sum("price")
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
            "productPurchase" => Inertia::lazy(
                fn() => PurchaseDetail::historyProductPurchase(
                    request()->only("productNumber", "supplierId")
                )
                    ->orderBy("price", "desc")
                    ->get()
                    ->transform(
                        fn($purchaseDetail) => [
                            "number" => $purchaseDetail->product_number,
                            "price" => $purchaseDetail->price,
                            "qty" => $purchaseDetail->qty,
                            "ppn" => $purchaseDetail->purchase->ppn,
                        ]
                    )
                    ->first()
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
            $validated = $request
                ->safe()
                ->merge([
                    "user_id" => auth()->user()->id,
                    "ppn" => $request->ppn ? true : false,
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
        return inertia("Purchases/Show", [
            "id" => $purchase->id,
            "number" => $purchase->number,
            "ppn" => Ppn::first()->ppn,
            "status" => $purchase->status,
            "ppnChecked" => $purchase->ppn ? true : false,
            "supplier" => $purchase->supplier,
            "purchaseDetail" => $purchase->purchaseDetail->transform(
                fn($purchase) => [
                    "id" => $purchase->id,
                    "number" => $purchase->product_number,
                    "name" => $purchase->product->name,
                    "price" => $purchase->getRawOriginal("price"),
                    "qty" => $purchase->qty,
                    "unit" => $purchase->product->unit,
                ]
            ),
        ]);
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
                    "price" => $purchase->getRawOriginal("price"),
                    "qty" => $purchase->qty,
                    "unit" => $purchase->product->unit,
                ]
            ),
            "productPurchase" => Inertia::lazy(
                fn() => PurchaseDetail::historyProductPurchase(
                    request()->only("productNumber", "supplierId")
                )
                    ->orderBy("price", "desc")
                    ->get()
                    ->transform(
                        fn($purchaseDetail) => [
                            "number" => $purchaseDetail->product_number,
                            "price" => $purchaseDetail->price,
                            "qty" => $purchaseDetail->qty,
                            "ppn" => $purchaseDetail->purchase->ppn,
                        ]
                    )
                    ->first()
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
            $validated = $request
                ->safe()
                ->merge([
                    "ppn" => $request->ppn ? true : false,
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
                    $stockProduct = StockProduct::where(
                        "product_number",
                        $product["number"]
                    );

                    if ($stockProduct->exists()) {
                        $validated = [
                            "price" =>
                                $stockProduct->first()->price >
                                $product["price"]
                                    ? $stockProduct->first()->price
                                    : $product["price"],
                            "ppn" => $request->ppn ? true : false,
                        ];

                        $stockProduct->increment(
                            "qty",
                            $product["qty"],
                            $validated
                        );
                    } else {
                        $validated = [
                            "price" => $product["price"],
                            "ppn" => $request->ppn ? true : false,
                            "qty" => $product["qty"],
                            "product_number" => $product["number"],
                        ];

                        StockProduct::create($validated);
                    }
                }
            }

            DB::commit();

            if ($request->status == "success") {
                return to_route("purchases.show", $purchase)->with(
                    "success",
                    __("messages.success.update.purchase")
                );
            } else {
                return back()->with(
                    "success",
                    __("messages.success.update.purchase")
                );
            }
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

    public function invoice(Purchase $purchase)
    {
        $pdf = Pdf::loadView("PDF.Purchases.Invoice", compact("purchase"));
        return $pdf->stream();
    }

    public function deliveryOrder(Purchase $purchase)
    {
        $pdf = Pdf::loadView("PDF.Purchases.Do", compact("purchase"));
        $pdf->setPaper("a3", "landscape");
        return $pdf->stream();
    }
}
