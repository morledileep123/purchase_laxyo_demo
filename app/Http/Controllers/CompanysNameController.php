<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Company_site_name;

class CompanysNameController extends Controller
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
        return view('company_name.index',compact('sides'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company_name.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validation = Validator::make($request->all(),[
            'company_name' => 'required',
            'full_address' => 'required',
        ]);
        
        $data = new Company_site_name;
        $data->company_name = $request->input('company_name');
        $data->full_address = $request->input('full_address');
        $data->mobile_no = $request->input('mobile_no');
        $data->gstno = $request->input('gstno');

        if($request->hasfile('image')) {
            $file = $request->file('image');
            $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->image = $filename;
        }

        if ($request->hasFile('header_img')){
            $file = $request->file('header_img');
             $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->header_img = $filename;
        }

        if ($request->hasFile('footer_img')){
            $file = $request->file('footer_img');
             $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->footer_img = $filename;
        }

        if ($request->hasFile('watermark_img')){
            $file = $request->file('watermark_img');
             $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->watermark_img = $filename;
        }
        
        $data->first_code_company = $request->input('first_code_company');
        $data->code_location = $request->input('code_location');

        $data->save();
        return redirect('company_name')->with('success','successfully New Side added.');
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
    public function edit($id)
    {
        $data = Company_site_name::where('id',$id)->first();
        return view('company_name.edit',compact('data'));
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
        $data =  Company_site_name::find($id);
        $data->company_name = $request->company_name;
        $data->full_address = $request->full_address;
        $data->mobile_no = $request->mobile_no;
        $data->gstno = $request->gstno;
        $data->first_code_company = $request->first_code_company;
        $data->code_location = $request->code_location;
        
        if($request->hasfile('image')) {
            
            $designation = public_path().'assets/img'.$request->image;
            if(File::exists($designation)){
               File::delete($designation); 
            }
            $file = $request->file('image');
            $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->image = $filename;
        }

        if($request->hasfile('watermark_img')) {

            $designation = public_path().'assets/img'.$request->watermark_img;
            if(File::exists($designation)){
               File::delete($designation); 
            }
            $file = $request->file('watermark_img');
            $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->watermark_img = $filename;
        }

        if($request->hasfile('header_img')) {

            $designation = public_path().'assets/img'.$request->header_img;
            if(File::exists($designation)){
               File::delete($designation); 
            }
            $file = $request->file('header_img');
            $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->header_img = $filename;
        }

        if($request->hasfile('footer_img')) {

            $designation = public_path().'assets/img'.$request->footer_img;
            if(File::exists($designation)){
               File::delete($designation); 
            }
            $file = $request->file('footer_img');
            $filename = 'assets/img/'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/img',$filename);
            $data->footer_img = $filename;
        }

        $data->save();
        return redirect('company_name')->with('success','Update successfully.');

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
        return redirect()->route('company_name.index')->with('success','Side Name deleted successfully');
    }
}
