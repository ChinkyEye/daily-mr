<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Helper\Helper;
use App\Client;
use App\Information;
use App\Mediator;
use App\Contact;
use App\ClientHasInfo;
use App\Project;
use App\Host;
use Auth;
use Response;
use DateTime;

class ClientController extends Controller
{
   
    public function index()
    {
        $clients = Client::get();
        return view('backend.client.index', compact('clients'));
    }

  
    public function create()
    {
        return view('backend.client.create');
    }

   
    public function store(Request $request)
    {
        $this->validate($request, [
        'fullname' => 'required',
        ]);

        $clients= Client::create([
        'fullname' => $request['fullname'],
        'phone' => $request['phone'],
        'email' => $request['email'],
        'address' => $request['address'],
        'created_by' => Auth::user()->id,
        'created_at_np' => date("H:i:s"),
        ]);
        if($clients->save()){
            $pass = array(
              'message' => 'Data added successfully!',
              'alert-type' => 'success'
          );
        }
        return redirect()->route('admin.client.index')->with($pass);
    }

    
    public function show($id)
    {
        $clients = Client::findorFail($id);
        $conclusions = Information::where('client_id',$id)->get();
        $hosts = Host::where('client_id',$id)->first();
        if($hosts ){
            $fdate = $this->helper->date_np_con();
            $tdate = $hosts->latest_renew_date;
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
        }else{
            $days = "";
        }
        // dd($fdate,$tdate);
        return view('backend.client.show',compact(['clients','conclusions','hosts'],'days'));
    }

   
    public function edit($id)
    {
        $clients = Client::find($id);
        return view('backend.client.edit', compact('clients'));
    }

   
    public function update(Request $request, Client $client)
    {
        $main_data = $request->all();
        $main_data['updated_by'] = Auth::user()->id;
        if($client->update($main_data)){
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
        return redirect()->route('admin.client.index')->with($notification)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try{
            return DB::transaction(function() use ($client)
            {
                $client_id = $client->id;
                $data_client_id = ClientHasInfo::where('client_id',$client_id)->value('id');
                $delete_clienthasinfo = ClientHasInfo::find($data_client_id);
                $data_information_id = Information::where('client_id',$client_id)->value('id');
                $delete_information = Information::find($data_information_id);
                if($delete_information){
                    $delete_information->delete();
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
                if($delete_clienthasinfo){
                    $delete_clienthasinfo->delete();
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
                if($client->delete()){
                    $notification = array(
                      'message' => $client->fullname.' is deleted successfully!',
                      'status' => 'success'
                  );
                }else{
                    $notification = array(
                      'message' => $client->fullname.' could not be deleted!',
                      'status' => 'error'
                  );
                }
                return back()->with($notification)->withInput(); 

            });

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();
        // return Response::json($notification);
    }
    
    public function isActive(Request $request,$id)
    {
      $get_is_active = Client::where('id',$id)->value('is_active');
        $isactive = Client::find($id);
        if($get_is_active == 0){
        $isactive->is_active = 1;
        $notification = array(
          'message' => $isactive->fullname.' is Active!',
          'alert-type' => 'success'
        );
        }
        else {
        $isactive->is_active = 0;
        $notification = array(
          'message' => $isactive->fullname.' is inactive!',
          'alert-type' => 'error'
        );
        }
        if(!($isactive->update())){
        $notification = array(
          'message' => $isactive->fullname.' could not be changed!',
          'alert-type' => 'error'
        );
        }
        return back()->with($notification)->withInput();  
    }

    public function addinformation(Request $request,$id)
    {
        $clients = Client::findorFail($id);
        $mediators = Mediator::get();
        $contacts = Contact::get();
        $projects = Project::get();
        return view('backend.client.addinformation',compact(['clients','request','mediators','contacts','projects']));
    }

    public function storeinformation(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'mediator_name' => 'required',
            'mediator_phone' => 'required',
        ]);
        try{
            return DB::transaction(function() use ($request)
            {
                $contact = Contact::create([
                    'name' => $request['c_name'],
                    'phone' => $request['c_phone'],
                    'email' => $request['c_email'],
                    'post' => $request['c_post'],
                    'created_by' => Auth::user()->id,
                    'created_at_np' => date("H:i:s"),
                ]);
                   $mediators = Mediator::create([
                    'name' => $request['mediator_name'],
                    'phone' => $request['mediator_phone'],
                    'created_by' => Auth::user()->id,
                    'created_at_np' => date("H:i:s"),
                ]);
                   $subs= Information::create([
                    'client_id' => $request['client_id'],
                    'contact_id' => $contact->id,
                    'mediator_id' => $mediators->id,
                    'project_id' => $request['project_id'],
                    'first_meeting' => $request['first_meeting'],
                    'next_meeting' => $request['first_meeting'],
                    'spend_time' => $request['spend_time'],
                    'time' => $request['time'],
                    'priority' =>$request['checkbox'],
                    'description' => $request['description'],
                // 'count' => '1',
                    'created_by' => Auth::user()->id,
                    'created_at_np' => date("H:i:s"),
                ]);
                   $clientsinfo= ClientHasInfo::create([
                    'client_id' => $request['client_id'],
                    'contact_id' => $contact->id,
                    'mediator_id' => $mediators->id,
                    'created_by' => Auth::user()->id,
                    'created_at_np' => date("H:i:s"),
                ]);
                   if($subs->save()){
                    $pass = array(
                      'message' => 'Data added successfully!',
                      'alert-type' => 'success'
                  );
                }
                return redirect()->route('admin.client.index')->with($pass);

            });
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();
        // $this->validate($request, [
        //     'mediator_name' => 'required',
        //     'mediator_phone' => 'required',
        // ]);
        // $contact = Contact::create([
        //     'name' => $request['c_name'],
        //     'phone' => $request['c_phone'],
        //     'email' => $request['c_email'],
        //     'post' => $request['c_post'],
        //     'created_by' => Auth::user()->id,
        //     'created_at_np' => date("H:i:s"),
        // ]);
        // $mediators = Mediator::create([
        //     'name' => $request['mediator_name'],
        //     'phone' => $request['mediator_phone'],
        //     'created_by' => Auth::user()->id,
        //     'created_at_np' => date("H:i:s"),
        // ]);
        // $subs= Information::create([
        //     'client_id' => $request['client_id'],
        //     'contact_id' => $contact->id,
        //     'mediator_id' => $mediators->id,
        //     'first_meeting' => $request['first_meeting'],
        //     'next_meeting' => $request['first_meeting'],
        //     'spend_time' => $request['spend_time'],
        //     'time' => $request['time'],
        //     'priority' =>$request['checkbox'],
        //     'description' => $request['description'],
        //     // 'count' => '1',
        //     'created_by' => Auth::user()->id,
        //     'created_at_np' => date("H:i:s"),
        // ]);
        // $clientsinfo= ClientHasInfo::create([
        //     'client_id' => $request['client_id'],
        //     'contact_id' => $contact->id,
        //     'mediator_id' => $mediators->id,
        //     'created_by' => Auth::user()->id,
        //     'created_at_np' => date("H:i:s"),
        // ]);
        // if($subs->save()){
        //     $pass = array(
        //       'message' => 'Data added successfully!',
        //       'alert-type' => 'success'
        //   );
        // }
        // return redirect()->route('admin.client.index')->with($pass);
    }
}
