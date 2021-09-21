<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Host;
use Auth;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addHost(Request $request,$id)
    {
        $hosts= Host::where('is_active',True)->where('client_id',$id)->get();
        return view('backend.host.create',compact('id','hosts'));
    }

    public function index()
    {
        //
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
        $hosts= Host::create([
            'client_id' => $request['client_id'],
            'hosted_on' => $request['hosted_on'],
            'agreement_on' => $request['agreement_on'],
            'link' => $request['link'],
            'server' => $request['server'],
            'latest_renew_date' => $request['hosted_on'],
            'created_by' => Auth::user()->id,
            'created_at_np' => date("H:i:s"),
        ]);
        if($hosts->save()){
            $pass = array(
              'message' => 'Data added successfully!',
              'alert-type' => 'success'
          );
        }
        return redirect()->back()->with($pass);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backend.host.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hosts = Host::find($id);
        return view('backend.host.edit',compact('hosts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Host $host)
    {
        $main_data = $request->all();
        $main_data['updated_by'] = Auth::user()->id;
        if($host->update($main_data)){
            $notification = array(
                'message' => 'data updated successfully!',
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => 'data could not be updated!',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Host $host)
    {
        if($host->delete()){
            $notification = array(
              'message' => 'data is deleted successfully!',
              'status' => 'success'
          );
        }else{
            $notification = array(
              'message' => 'data could not be deleted!',
              'status' => 'error'
          );
        }
        return back()->with($notification)->withInput();
    }

    public function updateDate(Request $request)
    {
        $hosts = Host::find($request->data_id);
        $hosts->latest_renew_date = $request->latest_renew_date;
        if($hosts->update()){
            $notification = array(
            'message' => 'Data updated successfully!',
            'alert-type' => 'success'
            );
        }else{
            $notification = array(
            'message' => 'Data could not be updated!',
            'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }
}
