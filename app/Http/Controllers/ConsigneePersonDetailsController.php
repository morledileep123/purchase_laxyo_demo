<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\ConsigneePersonDetails;

class ConsigneePersonDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consigne_person = ConsigneePersonDetails::latest()->paginate(10);
        return view('ConsigneePersonDetails',compact('consigne_person'))->with('i', (request()->input('page', 1) - 1) * 10);
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
        $validation = Validator::make($request->all(), [
            'name' => 'unique:prch_consignee_person_details',
        ]);
        if ($validation->fails())
        {
            return "The name has already been taken";
        }
        else
        {
            $data = new ConsigneePersonDetails;
            $data->name = $request->input('name');
            $data->save ();
            return 'Add Consignee Person Details';
        }
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
        ConsigneePersonDetails::where('id', $request->input('id'))->update(['name'=> $request->input('name')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ConsigneePersonDetails::find($id)->delete();
        return redirect()->route('ConsigneePersonDetails.index')->with('success','Consignee Person deleted successfully');
    }
}
