<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ppn\StorePpnRequest as PpnStorePpnRequest;
use App\Models\Ppn;
use Illuminate\Http\Request;

class PpnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ppn = Ppn::first()->getRawOriginal('ppn');

        return inertia('PPN/Index', compact('ppn'));
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
    public function store(PpnStorePpnRequest $request)
    {
        Ppn::truncate();

        Ppn::create($request->validated());

        return back()->with('success', __('messages.success.update.ppn'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Ppn $ppn
     * @return \Illuminate\Http\Response
     */
    public function show($ppn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Ppn $ppn
     * @return \Illuminate\Http\Response
     */
    public function edit($ppn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Ppn $ppn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ppn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ppn $ppn
     * @return \Illuminate\Http\Response
     */
    public function destroy($ppn)
    {
        //
    }
}
