<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mediator;
use Auth;
use Response;

class MediatorController extends Controller
{
   
    public function index()
    {
        // dd('hello');
        $mediators = Mediator::get();
        return view('backend.mediator.index', compact('mediators'));
    }

   
    public function create()
    {
        // dd('hh');
        return view('backend.mediator.create');
    }

 
    public function store(Request $request)
    {
        // dd("lol");
         $this->validate($request, [
        'name' => 'required',
        'phone' => 'required',
        ]);

        $mediators= Mediator::create([
        'name' => $request['name'],
        'address' => $request['address'],
        'email' => $request['email'],
        'phone' => $request['phone'],
        'created_by' => Auth::user()->id,
        'created_at_np' => date("H:i:s"),
        ]);
        if($mediators->save()){
            $pass = array(
              'message' => 'Data added successfully!',
              'alert-type' => 'success'
          );
        }
        return redirect()->route('admin.mediator.index')->with($pass);
    }

    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
         $edit = Mediator::find($id);
        // dd($edit->id);
        return view('backend.mediator.edit',compact('edit'));
    }

    
    public function update(Request $request, $id)
    {
        $data_store = Mediator::find($id);
        $data_store->name = $request->name;
        $data_store->phone = $request->phone;
        if($data_store->update()){
            $notification = array(
                'message' => $request->name.' updated successfully!',
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => 'Data could not be updated!',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('admin.mediator.index')->with($notification);
    }

    public function destroy(mediator $mediator)
    {
        if($mediator->delete()){
            $notification = array(
              'message' => $mediator->name.' is deleted successfully!',
              'status' => 'success'
          );
        }else{
            $notification = array(
              'message' => $mediator->name.' could not be deleted!',
              'status' => 'error'
          );
        }
        return back()->with($notification)->withInput();  
        // return Response::json($notification);
    }

    
}
