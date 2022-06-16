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
        return inertia('Suppliers/Index.vue', [
            'initialSearch' => request('search'),
            'suppliers' => Supplier::filter(request()->only('search'))
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn($customer) => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'address' => $customer->address,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'npwp' => $customer->npwp
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
        return inertia('Suppliers/Create');
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

        return back()->with('success', __('messages.success.store.supplier'));
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
        return inertia('Suppliers/Edit.vue', compact('supplier'));
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

        return back()->with('success', __('messages.success.update.supplier'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
