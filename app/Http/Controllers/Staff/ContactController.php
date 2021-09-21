<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use Response;
use Auth;

class ContactController extends Controller
{
   
    public function index()
    {  
        $contact=Contact::where('created_by',Auth::user()->id)
                          ->get();
        return view('staff.contact.index',compact('contact'));
    }

    public function getContactList(Request $request)
    {
        $name_id = $request->c_name_id;
        $contact_list = Contact::where('id',$name_id)
                        ->where('is_active','1')
                        ->get();
        return Response::json($contact_list);
    }

   
    public function create()
    {
        return view('staff.contact.create');
    }

   
    public function store(Request $request)
    {
         $this->validate($request, [
        'fullname' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'post' => 'post',
        ]);

        $clients= Contact::create([
        'fullname' => $request['fullname'],
        'address' => $request['address'],
        'phone' => $request['phone'],
        'email' => $request['email'],
        'post' => $request['post'],
        'created_by' => Auth::user()->id,
        'created_at_np' => date("H:i:s"),
        ]);
        $pass = array(
          'message' => 'Data added successfully!',
          'alert-type' => 'success'
        );
        return redirect()->route('staff.contact.index')->with($pass);
    }

   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $contacts = Contact::find($id);
        return view('staff.contact.edit', compact('contacts'));
    }

   
    public function update(Request $request, Contact $contact)
    {
        $main_data = $request->all();
        $main_data['updated_by'] = Auth::user()->id;
        if($contact->update($main_data)){
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
        return redirect()->route('staff.contact.index')->with($notification)->withInput();
    }

    
    public function destroy(Contact $contact)
    {
        if($contact->delete()){
            $notification = array(
              'message' => $contact->name.' is deleted successfully!',
              'status' => 'success'
          );
        }else{
            $notification = array(
              'message' => $contact->name.' could not be deleted!',
              'status' => 'error'
          );
        }
        return back()->with($notification)->withInput();
    }
}
