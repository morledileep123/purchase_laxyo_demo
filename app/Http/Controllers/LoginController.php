<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;
use Config;
use Illuminate\Support\Facades\Crypt;
use Session;

class LoginController extends Controller
{
	public function loginasuser(Request $request){
    
		$data = User::where('email',$request->username)->first();	
		if($request->username !='' && $request->password !=''){
	     
			if($data->log_status == true && $data->other_pass == $request->password){
		
	      if (Auth::attempt(['email' => $request->username, 'password' =>$request->password])) {

		       $user = Auth::user();
		      return redirect()->route('home');
		    }else {
		       return response()->json(['error' => 'Unauthorised'], 401);
		    }
		  }
		  else{
		  	return redirect('http://laxyo.org/login');
		  }
		}
		else{
			return response()->json(['error' => 'Unauthorised'], 401);
		}
		

  }

    public function logout(Request $request){
    	Auth::logout();
    	Session::flush();
  		return redirect('/');
    }
}