<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prch_Notifications;
use Carbon\Carbon;

class PrchNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unreads = Prch_Notifications::where('notifiable_to', auth()->user()->id)->where('read_it','0')->latest()->paginate(15);
        $reads = Prch_Notifications::where('notifiable_to', auth()->user()->id)->where('read_it','1')->latest()->paginate(15);
        return view('prch_notification',compact('unreads','reads'));
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
        Prch_Notifications::where('id', $id)->update(['read_it'=>1]);
        return back();
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

    public function deleteMultiple(Request $request)
    {
        $id = $request->id;
        Prch_Notifications::whereIn('id',explode(",",$id))->update(['read_it'=>1]);
        return response()->json(['status'=>true,'message'=>"Notification deleted successfully."]);
         
    }
}
