<?php

namespace App\Http\Controllers;

use App\Models\Ppn;
use App\Models\Sale;
use Inertia\Inertia;
use App\Models\Customer;
use App\Models\StockProduct;
use App\Services\HelperService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Http\Requests\Sales\StoreSaleRequest;
use App\Http\Requests\Sales\UpdateSaleRequest;

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
        return inertia("Sales/Index", [
            "initialSearch" => request("search"),
            "sales" => Sale::filter(request()->only("search"))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($sale) => [
                        "id" => $sale->id,
                        "updatedAt" => $sale->updated_at,
                        "name" => $sale->customer->name,
                        "phone" => $sale->customer->phone,
                        "email" => $sale->customer->email,
                        "price" => HelperService::setRupiahFormat(
                            $sale->saleDetail->sum("price")
                        ),
                        "status" => $sale->status,
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
        return inertia("Sales/Create", [
            "number" => "PJN" . now()->format("YmdHis"),
            "ppn" => Ppn::first()->ppn,
            "customers" => Inertia::lazy(
                fn() => Customer::filter([
                    "search" => request("customer"),
                ])->get()
            ),
            "stockProducts" => Inertia::lazy(
                fn() => StockProduct::filter([
                    "search" => request("stockProduct"),
                ])
                    ->get()
                    ->transform(
                        fn($stockProduct) => [
                            "number" => $stockProduct->product_number,
                            "name" => $stockProduct->product->name,
                            "price" => $stockProduct->price,
                            "ppn" => $stockProduct->ppn,
                            "qty" => $stockProduct->qty,
                            "unit" => $stockProduct->product->unit,
                            "profit" => $stockProduct->product->profit,
                        ]
                    )
            ),
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
            $ppn = Ppn::first()->ppn;

            $validated = $request
                ->safe()
                ->merge([
                    "user_id" => auth()->user()->id,
                    "ppn" => $request->ppn ? $ppn : 0,
                ])
                ->all();

            $sale = Sale::create($validated);

            foreach ($request->products as $product) {
                $validated = [
                    "product_number" => $product["number"],
                    "price" => $product["price"],
                    "qty" => $product["qty"],
                ];

                $sale->saleDetail()->create($validated);

                if ($request->status == "success") {
                    StockProduct::where(
                        "product_number",
                        $product["number"]
                    )->decrement("qty", $product["qty"]);
                }
            }

            DB::commit();

            return to_route("sales.show", $sale)->with(
                "success",
                __("messages.success.store.sale")
            );
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with("error", __("messages.error.store.sale"));
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
        return inertia("Sales/Show", [
            "id" => $sale->id,
            "number" => $sale->number,
            "ppn" => Ppn::first()->ppn,
            "status" => $sale->status,
            "ppnChecked" => $sale->ppn ? true : false,
            "customer" => $sale->customer,
            "saleDetail" => $sale->saleDetail->transform(
                fn($sale) => [
                    "id" => $sale->id,
                    "number" => $sale->product_number,
                    "name" => $sale->product->name,
                    "price" => $sale->getRawOriginal("price"),
                    "qty" => $sale->qty,
                    "unit" => $sale->product->unit,
                ]
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
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
        //
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
