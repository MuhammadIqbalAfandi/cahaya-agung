<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Supplier::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia("Suppliers/Index", [
            "initialSearch" => request("search"),
            "suppliers" => Supplier::search(request()->only("search"))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(
                    fn($supplier) => [
                        "id" => $supplier->id,
                        "name" => $supplier->name,
                        "address" => $supplier->address,
                        "email" => $supplier->email,
                        "phone" => $supplier->phone,
                        "npwp" => $supplier->npwp,
                        "isUsed" => $supplier->purchases()->exists(),
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
        return inertia("Suppliers/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        Supplier::create($request->validated());

        return back()->with("success", __("messages.success.store.supplier"));
    }

    /**
     * Display the specified resource.
     *
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return inertia("Suppliers/Edit", compact("supplier"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return back()->with("success", __("messages.success.update.supplier"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return back()->with("success", __("messages.success.destroy.supplier"));
    }
}
