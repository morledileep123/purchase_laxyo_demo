<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SiteName;
use App\User;
use App\Prch_Team;
use App\Prch_Team_Person;

class PurchaseTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Prch_Team::with('post')->get();
        return view('Teams.index',compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites = SiteName::all();
        $prch_superadmin = User::has('prchsuperadmin')->get();
        $prch_accountant = User::has('prchaccountant')->get();
        $prch_admin = User::has('prchadmin')->get();
        $prch_manager = User::has('prchmanager')->get();
        $prch_user = User::has('prchuser')->get();

        return view('Teams.create.create',compact('sites','prch_superadmin','prch_accountant','prch_admin','prch_manager','prch_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $this->validate($request,[
            'team_name' => 'required',
            'side_id' => 'required',
        ]);

        $side_name = SiteName::where('id',$request->side_id)->first();

        $request_data = new Prch_Team;
        $request_data->team_name = $request->team_name;
        $request_data->side_id = $request->side_id;
        $request_data->side_name = $side_name->name;
        $request_data->save();
        $team_id = $request_data->id;

        $count_prch_super_admin = count($request->prch_super_admin);
        $count_prch_admin = count($request->prch_admin);
        $count_prch_accountant = count($request->prch_accountant);
        $count_prch_manager = count($request->prch_manager);
        $count_prch_user = count($request->prch_user);

        $i = 0;
        while($i < $count_prch_super_admin){

            $user_name = User::where('id',$request->prch_super_admin[$i])->first();
            if($request->prch_super_admin[$i] !=''){
              $newdata = array(
                  'team_id' => $team_id,                      
                  'role' => 4,
                  'user_id' => $request->prch_super_admin[$i],
                  'user_name' => $user_name->name, 
              );
              
            Prch_Team_Person::create($newdata);

            }       
            $i++;
        }

        $i = 0;
        while($i < $count_prch_admin){

            $user_name = User::where('id',$request->prch_admin[$i])->first();
            if($request->prch_admin[$i] !=''){
              $newdata = array(
                  'team_id' => $team_id,                      
                  'role' => 20,
                  'user_id' => $request->prch_admin[$i],
                  'user_name' => $user_name->name,
              );
              
            Prch_Team_Person::create($newdata);

            }       
            $i++;
        }

        $i = 0;
        while($i < $count_prch_accountant){

            $user_name = User::where('id',$request->prch_accountant[$i])->first();
            if($request->prch_accountant[$i] !=''){
              $newdata = array(
                  'team_id' => $team_id,                      
                  'role' => 16,
                  'user_id' => $request->prch_accountant[$i],
                  'user_name' => $user_name->name,
              );
              
            Prch_Team_Person::create($newdata);

            }       
            $i++;
        }

        $i = 0;
        while($i < $count_prch_manager){

            $user_name = User::where('id',$request->prch_manager[$i])->first();
            if($request->prch_manager[$i] !=''){
              $newdata = array(
                  'team_id' => $team_id,                      
                  'role' => 22,
                  'user_id' => $request->prch_manager[$i],
                  'user_name' => $user_name->name,
              );
              
            Prch_Team_Person::create($newdata);

            }       
            $i++;
        }

        $i = 0;
        while($i < $count_prch_user){

            $user_name = User::where('id',$request->prch_user[$i])->first();
            if($request->prch_user[$i] !=''){
              $newdata = array(
                  'team_id' => $team_id,                      
                  'role' => 23,
                  'user_id' => $request->prch_user[$i],
                  'user_name' => $user_name->name,
              );
              
            Prch_Team_Person::create($newdata);

            }       
            $i++;
        }

        return redirect()->route('teams.index')->with('success','Team create Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teams = Prch_Team::where('id',$id)->first();
        $superadmin_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',4)->get();
        $accountant_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',16)->get();
        $admin_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',20)->get();
        $manager_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',22)->get();
        $user_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',23)->get();


        return view('Teams.show',compact('teams','superadmin_teams_details','accountant_teams_details','admin_teams_details','manager_teams_details','user_teams_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teams = Prch_Team::where('id',$id)->first();
        $superadmin_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',4)->get();
        $accountant_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',16)->get();
        $admin_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',20)->get();
        $manager_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',22)->get();
        $user_teams_details = Prch_Team_Person::where('team_id',$id)->where('role',23)->get();

        $prch_superadmin = User::has('prchsuperadmin')->get();
        $prch_accountant = User::has('prchaccountant')->get();
        $prch_admin = User::has('prchadmin')->get();
        $prch_manager = User::has('prchmanager')->get();
        $prch_user = User::has('prchuser')->get();

        return view('Teams.edit.edit',compact('teams','superadmin_teams_details','accountant_teams_details','admin_teams_details','manager_teams_details','user_teams_details','prch_superadmin','prch_accountant','prch_admin','prch_manager','prch_user'));
    }

    public function NewSuperAdmin(Request $request)
    {
        $user_name = User::where('id',$request->prch_super_admin)->first();

        $request_data = new Prch_Team_Person;
        $request_data->team_id = $request->team_id;
        $request_data->role = 4;
        $request_data->user_id = $request->user_id;
        $request_data->user_name = $user_name->name;
        $request_data->save();
        return back();
    }

    public function NewAdmin(Request $request)
    {
        $user_name = User::where('id',$request->prch_admin)->first();

        $request_data = new Prch_Team_Person;
        $request_data->team_id = $request->team_id;
        $request_data->role = 20;
        $request_data->user_id = $request->user_id;
        $request_data->user_name = $user_name->name;
        $request_data->save();
        return back();
    }

    public function NewAccountant(Request $request)
    {
        $user_name = User::where('id',$request->prch_accountant)->first();

        $request_data = new Prch_Team_Person;
        $request_data->team_id = $request->team_id;
        $request_data->role = 16;
        $request_data->user_id = $request->user_id;
        $request_data->user_name = $user_name->name;
        $request_data->save();
        return back();
    }

    public function NewManager(Request $request)
    {
        $user_name = User::where('id',$request->prch_manager)->first();

        $request_data = new Prch_Team_Person;
        $request_data->team_id = $request->team_id;
        $request_data->role = 22;
        $request_data->user_id = $request->user_id;
        $request_data->user_name = $user_name->name;
        $request_data->save();
        return back();
    }

    public function NewUser(Request $request)
    {
        $user_name = User::where('id',$request->prch_user)->first();

        $request_data = new Prch_Team_Person;
        $request_data->team_id = $request->team_id;
        $request_data->role = 23;
        $request_data->user_id = $request->user_id;
        $request_data->user_name = $user_name->name;
        $request_data->save();
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

    public function teams_name_update(Request $request)
    {
        return Prch_Team::where('id', $request->input('query'))->update(['team_name'=>$request->input('team_name')]);
    }

    public function remove_team_member_name(Request $request)
    {
        Prch_Team_Person::where('id',$request->id)->delete();
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Prch_Team::destroy($id);
        $msg = "Team Deleted successful! ";
        return redirect('Teams.index')->with('success', $msg);
    }
}
