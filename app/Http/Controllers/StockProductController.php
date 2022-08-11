<?php

namespace App\Http\Controllers;

use App\Models\Ppn;
use App\Models\Product;
use App\Models\StockProduct;
use Illuminate\Http\Request;
use App\Services\FunctionService;
use App\Models\HistoryStockProduct;
use App\Exports\HistoryStockProductExport;

class StockProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(StockProduct::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia("StockProducts/Index", [
            "initialFilters" => request()->only("search", "category"),
            "stockProducts" => StockProduct::filter(
                request()->only("search", "category")
            )
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($stockProduct) => [
                        "id" => $stockProduct->id,
                        "productId" => $stockProduct->product->id,
                        "productNumber" => $stockProduct->product->number,
                        "updatedAt" => $stockProduct->updated_at,
                        "name" => $stockProduct->product->name,
                        "price" => FunctionService::rupiahFormat(
                            $stockProduct->price
                        ),
                        "qty" => $stockProduct->qty,
                        "unit" => $stockProduct->product->unit,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function history(Product $product)
    {
        $ppn = Ppn::first()->ppn;

        return inertia("StockProducts/Show", [
            "initialFilters" => request()->only(
                "start_date",
                "end_date",
                "category"
            ),
            "productId" => $product->id,
            "productNumber" => $product->number,
            "historyStockProducts" => HistoryStockProduct::where(
                "product_number",
                $product->number
            )
                ->filter(request()->only("start_date", "end_date", "category"))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($historyStockProduct) => [
                        "createdAt" => $historyStockProduct->created_at,
                        "name" => $historyStockProduct->product->name,
                        "qty" => $historyStockProduct->qty,
                        "ppn" => $historyStockProduct->ppn ? $ppn : 0,
                        "unit" => $historyStockProduct->product->unit,
                        "price" => FunctionService::rupiahFormat(
                            $historyStockProduct->price *
                                $historyStockProduct->qty
                        ),
                        "category" => $historyStockProduct->purchase_number
                            ? __("words.addition")
                            : __("words.reduction"),
                    ]
                ),
        ]);
    }

    public function historyExcel()
    {
        $ppn = Ppn::first()->ppn;

        return new HistoryStockProductExport([
            "historyStockProducts" => HistoryStockProduct::where(
                "product_number",
                request("product_number")
            )
                ->filter(request()->only("start_date", "end_date", "category"))
                ->latest()
                ->get()
                ->map(
                    fn($historyStockProduct) => [
                        "createdAt" => $historyStockProduct->created_at,
                        "name" => $historyStockProduct->product->name,
                        "qty" => $historyStockProduct->qty,
                        "ppn" => $historyStockProduct->ppn ? $ppn : 0,
                        "unit" => $historyStockProduct->product->unit,
                        "price" =>
                            $historyStockProduct->price *
                            $historyStockProduct->qty,
                        "category" => $historyStockProduct->purchase_number
                            ? __("words.addition")
                            : __("words.reduction"),
                    ]
                ),
        ]);
    }
}
