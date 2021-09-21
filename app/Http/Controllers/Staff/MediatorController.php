<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mediator;
use Auth;
use Response;

class MediatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mediators = Mediator::where('created_by', Auth::user()->id)->get();
        return view('staff.mediator.index', compact('mediators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.mediator.create');
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
        'phone' => 'required',
        ]);

        $mediators= Mediator::create([
        'name' => $request['name'],
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
        return redirect()->route('staff.mediator.index')->with($pass);
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
        $mediators = Mediator::find($id);
        return view('staff.mediator.edit', compact('mediators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mediator $mediator)
    {
        $main_data = $request->all();
        $main_data['updated_by'] = Auth::user()->id;
        if($mediator->update($main_data)){
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
        return redirect()->route('staff.mediator.index')->with($notification)->withInput();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mediator $mediator)
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
    }

    public function isActive(Request $request,$id){
      $get_is_active = Mediator::where('id',$id)->value('is_active');
        $isactive = Mediator::find($id);
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

    public function getMediatorList(Request $request)
    {
        $name_id = $request->m_name_id;
        $mediator_list = Mediator::where('id',$name_id)
                        ->where('is_active','1')
                        ->get();
        return Response::json($mediator_list);
    }
}
