<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Purchase_order;
use App\Purchase_order_detail;
use App\Vendor;
use App\item;

class VendorsEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Purchase_order_detail::select('item_id')->where('invoice_product', 'ILIKE', 'HAND GLOVES')->get();
        // // return $data->item_id;

        // if(count($data) != null)
        // {
        //   foreach($data as $row)
        //   {
        //     $data = Purchase_order::where('id',$row->item_id)->get();
        //     $output .= '<li><a id="getItemID" href="?itemId='.$data->id.'" style="pointer-events: none;" value="'.$data->id.'">'.$data->vendor_details .' | '.$data->vendor_details.' | '.$data->vendor_details.' | '.$data->vendor_details.'</a></li>';

        //   }
        // }

        // else
        // {
        //   $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        // }


        return view('VendorsEnquiry.index');
    }

    public function fetch_Vendor(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = item::where('item_name', 'ILIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->orWhere('part_number', 'LIKE', "%{$query}%")->orWhere('item_number', 'LIKE', "%{$query}%")->get();

            $output = '<ul class="dropdown-menu items-dropdown" style="display:block; position:relative">';

            if(count($data) != null)
            {
              foreach($data as $row)
              {
                $output .= '<li><a id="getItemID" href="?itemId='.$row->id.'" style="pointer-events: none;" value="'.$row->id.'">'.$row->item_name .' | '.$row->description.' | '.$row->item_number.' | '.$row->part_number.'</a></li>';

              }
            }

            else
            {
              $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
            }

            $output .= '</ul>';
            echo $output;
        }
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
        return Purchase_order_detail::where('invoice_product',$request->item_no)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        //Project
        //JavaScript
        //Java
        //PHP
        //Laravel
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

    public function fetch_Vendor_Name(Request $request)
    {
        $item_name = $request->get('item_no');
        $products = Purchase_order_detail::where('invoice_product', 'ILIKE', $item_name)->get();
        $data = array();
        if(count($products) != null)
        {
          foreach($products as $product)
          {
            $data[] = Purchase_order::where('id',$product->item_id)->first();
              
            // $data = $data->id;
             // return response()->json(['data' => $data]); 
            // $output .= '<li><a id="getItemID" href="?itemId='.$data->id.'" style="pointer-events: none;" value="'.$data->id.'">'.$data->vendor_details .' | '.$data->vendor_details.' | '.$data->vendor_details.' | '.$data->vendor_details.'</a></li>';

          }
          return response()->json(['data' => $data]);
          // return response()->json(['data' => $data]); 
        }     
    }

    public function show_Vendor_details($id)
    {
        $data = Purchase_order::where('id',$id)->first(); 
        $items = Purchase_order_detail::where('item_id',$id)->get(); 

        return view('VendorsEnquiry.view_purchase_order_receipt',compact('data','items'));
    }
}
