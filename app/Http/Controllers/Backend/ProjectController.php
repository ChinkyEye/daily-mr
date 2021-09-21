<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use Auth;
use Response;

class ProjectController extends Controller
{
    
    public function index()
    {
        $datas = Project::get();
        return view('backend.project.index',compact('datas'));
    }

    
    public function create()
    {
        return view('backend.project.create');
    }

   
    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
        'description' => 'required',
        ]);

        $project= Project::create([
        'name' => $request['name'],
        'description' => $request['description'],
        'created_by' => Auth::user()->id,
        'created_at_np' => date("H:i:s"),
        ]);
        if($project->save()){
            $pass = array(
              'message' => 'Data added successfully!',
              'alert-type' => 'success'
            );
        }
        return redirect()->route('admin.project.index')->with($pass);
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $edit = Project::find($id);
        return view('backend.project.edit',compact('edit'));
    }

    
    public function update(Request $request, $id)
    {
        $data_store =Project::find($id);
        $data_store->name = $request->name;
        $data_store->description = $request->description;
        // $data_store->update();
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
        return redirect()->route('admin.project.index')->with($notification);
    }

   
    public function destroy(Project $project)
    {
        if($project->delete()){
            $notification = array(
              'message' => $project->name.' is deleted successfully!',
              'status' => 'success'
          );
        }else{
            $notification = array(
              'message' => $project->name.' could not be deleted!',
              'status' => 'error'
          );
        }
        return back()->with($notification)->withInput();  
        // return Response::json($notification);
    }

     public function isActive(Request $request,$id){
      $get_is_active = Project::where('id',$id)->value('is_active');
        $isactive = Project::find($id);
        if($get_is_active == 0){
        $isactive->is_active = 1;
        $notification = array(
          'message' => $isactive->name.' is Active!',
          'alert-type' => 'success'
        );
        }
        else {
        $isactive->is_active = 0;
        $notification = array(
          'message' => $isactive->name.' is inactive!',
          'alert-type' => 'error'
        );
        }
        if(!($isactive->update())){
        $notification = array(
          'message' => $isactive->name.' could not be changed!',
          'alert-type' => 'error'
        );
        }
        return back()->with($notification)->withInput();  
    }
}
