<?php

namespace App\Http\Controllers;

use App\Company_site_name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class CompanySideNameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sides = Company_site_name::latest()->paginate(10);
        return view('company_side_name',compact('sides'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company_side_data_insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'company_name' => 'required',
            'full_address' => 'required',
        ]);

        $data = new Company_site_name;
        $data->company_name = $request->input('company_name');
        $data->full_address = $request->input('full_address');
        $data->mobile_no = $request->input('mobile_no');
        $data->gstno = $request->input('gstno');
        $data->first_code_company = $request->input('first_code_company');
        $data->code_location = $request->input('code_location');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->image = $filename; 
        }

        if($request->hasFile('watermark_img')){
            $file = $request->file('watermark_img');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->watermark_img = $filename; 
        }

        if($request->hasFile('header_img')){
            $file = $request->file('header_img');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->header_img = $filename; 
        }

        if($request->hasFile('footer_img')){
            $file = $request->file('footer_img');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->footer_img = $filename; 
        }

        $data->save();
        return "Added successfully";        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data = Company_site_name::find($id);
        $data->company_name = $request->input('company_name');
        $data->full_address = $request->input('full_address');
        $data->mobile_no = $request->input('mobile_no');
        $data->gstno = $request->input('gstno');
        $data->first_code_company = $request->input('first_code_company');
        $data->code_location = $request->input('code_location');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->image = $filename; 
        }

        if($request->hasFile('watermark_img')){
            $file = $request->file('watermark_img');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->watermark_img = $filename; 
        }

        if($request->hasFile('header_img')){
            $file = $request->file('header_img');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->header_img = $filename; 
        }

        if($request->hasFile('footer_img')){
            $file = $request->file('footer_img');
            $filename = 'assets/img/'.time().'.'.$file->getClientOriginalName();
            $file->move(public_path('assets/img'), $filename);
            $data->footer_img = $filename; 
        }
        
        $data->save();
        return back();

        // Company_site_name::where('id', $request->input('id'))->update(['company_name'=> $request->input('company_name'), 'full_address' => $request->input('full_address')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company_site_name::find($id)->delete();
        return redirect()->route('company_side_name.index')->with('success','Side Name deleted successfully');
    }
}
