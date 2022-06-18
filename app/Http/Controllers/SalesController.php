<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
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
                    'price' => $sale->saleDetails->price,
                    'ppn' => $sale->saleDetails->ppn,
                    'qty' => $sale->saleDetails->qty,
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
            'customers' => Inertia::lazy(
                fn() => Customer::filter(request()->only('customer'))
                    ->get()
                    ->transform(fn($customer) => [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'npwp' => $customer->npwp
                    ])),
            'products' => Inertia::lazy(
                fn() => Product::filter(request()->only('product'))
                    ->get()
                    ->transform(fn($product) => [
                        'id' => $product->id,
                        'number' => $product->number,
                        'name' => $product->name
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
    public function store(Request $request)
    {
        dd($request);
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
