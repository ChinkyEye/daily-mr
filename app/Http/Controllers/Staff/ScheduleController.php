<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\Information;
use Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addschedule(Request $request)
    {
        $conclusions = Schedule::where('created_by', Auth::user()->id)
                                ->get();
        return view('staff.schedule.index',compact('request','conclusions'));
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
    public function store(Request $request,$id)
    {
        // dd($request);
        $mediator_id = Information::where('client_id',$id)->value('mediator_id');
        $contact_id = Information::where('client_id',$id)->value('contact_id');
        $this->validate($request, [
        'description' => 'required',
        ]);

        $informations= Information::create([
        'client_id' => $id,
        'mediator_id' => $mediator_id,
        'contact_id' => $contact_id,
        'project_id' => $request['project_id'],
        'description' => $request['description'],
        'first_meeting' => $request['first_meeting'],
        'next_meeting' => $request['next_meeting'],
        'allocated_time' => $request['allocated_time'],
        'priority' => $request['priority'],
        'created_by' => Auth::user()->id,
        'created_at_np' => date("H:i:s"),
        ]);
        if($informations->save()){
            $pass = array(
              'message' => 'Data added successfully!',
              'alert-type' => 'success'
          );
        }
        else{
             $pass = array(
              'message' => 'Error!',
              'alert-type' => 'danger'
          );
        }
        return back()->with($pass)->withInput();
        // return redirect()->route('staff.schedule.index')->with($pass);
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
}
