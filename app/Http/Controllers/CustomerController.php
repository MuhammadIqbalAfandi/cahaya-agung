<?php

namespace App\Http\Controllers;

use App\Models\Ppn;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\SaleDetail;
use App\Exports\CustomerHistoryExport;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia("Customers/Index", [
            "initialFilters" => request()->only("search"),
            "customers" => Customer::search(request()->only("search"))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($customer) => [
                        "id" => $customer->id,
                        "name" => $customer->name,
                        "address" => $customer->address,
                        "phone" => $customer->phone,
                        "npwp" => $customer->npwp,
                        "isUsed" => $customer->sales()->exists(),
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
        return inertia("Customers/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        Customer::create($request->validated());

        return back()->with("success", __("messages.success.store.customer"));
    }

    /**
     * Display the specified resource.
     *
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return inertia("Customers/Show", [
            "initialFilters" => request()->only(
                "start_date",
                "end_date",
                "number_product"
            ),
            "customer" => $customer,
            "historyPurchase" => $customer
                ->sales()
                ->filter(
                    request()->only("start_date", "end_date", "product_number")
                )
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($sale) => [
                        "id" => $sale->id,
                        "createdAt" => $sale->created_at,
                        "number" => $sale->number,
                        "status" => $sale->status,
                        "ppn" => $sale->ppn,
                    ]
                ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return inertia("Customers/Edit", compact("customer"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return back()->with("success", __("messages.success.update.customer"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with("success", __("messages.success.destroy.customer"));
    }

    public function historyPurchase(Sale $sale)
    {
        return inertia("Customers/HistoryPurchase", [
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

    public function historyPurchaseExcel()
    {
        $this->authorize("viewAny", Customer::class);

        return new CustomerHistoryExport([
            "sales" => SaleDetail::filter(
                request()->only("start_date", "end_date", "product_number")
            )
                ->latest()
                ->get()
                ->map(
                    fn($saleDetail) => [
                        "createdAt" => $saleDetail->created_at,
                        "name" => $saleDetail->product->name,
                        "number" => $saleDetail->sale->number,
                        "qty" => $saleDetail->qty,
                        "status" => $saleDetail->sale->status,
                        "ppn" => $saleDetail->sale->ppn,
                        "price" => $saleDetail->price * $saleDetail->qty,
                    ]
                ),
        ]);
    }
}
