<?php

namespace App\Http\Controllers;

use App\Models\StockProduct;
use App\Services\HelperService;
use Illuminate\Http\Request;

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
            "initialSearch" => request("search"),
            "stockProducts" => StockProduct::filter(request()->only("search"))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($stockProduct) => [
                        "id" => $stockProduct->id,
                        "updatedAt" => $stockProduct->updated_at,
                        "name" => $stockProduct->product->name,
                        "price" => HelperService::setRupiahFormat(
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
}
