<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Information;
use Auth;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = User::where('user_type','2')->get();
        return view('backend.staff.index',compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'email' => 'required|string|email|max:255',
            // 'password' => 'required|string|min:6|confirmed',
        ]);
         $user= User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'user_type' => "2",
        ]);
        if($user->save()){
            $pass = array(
                'message' => 'Data added successfully!',
                'alert-type' => 'success'
            );
        }
        return redirect()->route('admin.staff.index')->with($pass);
        // return back()->with($pass)->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ldate = date('Y-m-d');
        $users = User::where('id',$id)->first();
        $clients = Information::where('created_by',$id)
                                ->whereDate('created_at',$ldate)
                                ->groupBy('client_id')
                                ->get();
                                // dd($clients);
        return view('backend.staff.show',compact('clients','users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staffs = User::find($id);
        return view('backend.staff.edit', compact('staffs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $staff)
    {
        $main_data = $request->all();
        if($staff->update($main_data)){
            $notification = array(
                'message' => $request->name.' updated successfully!',
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => $request->name.' could not be updated!',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('admin.staff.index')->with($notification)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $staff)
    {
        if($staff->delete()){
            $notification = array(
              'message' => $staff->name.' is deleted successfully!',
              'status' => 'success'
          );
        }else{
            $notification = array(
              'message' => $staff->name.' could not be deleted!',
              'status' => 'error'
          );
        }
        return back()->with($notification)->withInput();
    }

    public function StaffSearch(Request $request){
        
        $ldate = date('Y-m-d');
        $users = User::where('id',$request->staff_id)->first();
        $filter_from_date = $request->from_date;
        $filter_to_date = $request->to_date;
        // dd($filter_from_date,$filter_to_date,$request->staff_id);
        if($filter_from_date)
        {   
            $search_datas = Information::where('created_by',$request->staff_id)
                                ->where('created_at','>=',$filter_from_date)
                                // ->whereDate('created_at',$ldate)
                                ->groupBy('client_id');
                                // ->get();
        }
        if($filter_to_date){
            $search_datas = $search_datas->where('created_at','<=',$filter_to_date)
                                            ->paginate(10);
           
        }
        else{
            $search_datas =  Information::where('created_by',$request->staff_id)
                                ->whereDate('created_at',$ldate)
                                ->groupBy('client_id')
                                ->get();
        }
        // dd($search_datas);
        return view('backend.staff.search',compact(['search_datas','request','users']));

    }
}
