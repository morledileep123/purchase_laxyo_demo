<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class transcation_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'hsgdfuygkuhwrueghu';
        return view('Transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "jsndkufhiusrghu";
        return view('Transaction.create');
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

    public function so_create()
    {
        return view('Transaction.so-create');
    }

    public function oc_create()
    {
        return view('Transaction.oc-create');
    }

    public function sc_create()
    {
        return view('Transaction.sc-create');
    }

    public function inc_create()
    {
        return view('Transaction.inc-create');
    }

    public function adhinc_create()
    {
        return view('Transaction.adhinc-create');
    }
}
