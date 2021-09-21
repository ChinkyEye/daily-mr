@extends('backend.main.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/backend/css/nepali.datepicker.v2.2.min.css" />
@endpush
@section('content')
<?php $page = substr((Route::currentRouteName()), 6, strpos(str_replace('admin.','',Route::currentRouteName()), ".")); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6 pl-1">

        <label for="student_id" class="control-label">Client Name</label>
        <span> : {{$clients->fullname}}</span> 
        <label></label>
        <b> Phone:</b> {{$clients->phone}} | 
        <b> Email:</b> {{$clients->email}} 

      </div>
      {{-- <div class="col-sm-6 pl-1">
        <h1 class="text-capitalize">Add Information</h1>
      </div> --}}
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('staff.home')}}">Home</a></li>
          <li class="breadcrumb-item active text-capitalize">{{ $page }} Page</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="card card-info">
    <form role="form" method="POST" action="{{route('admin.client.storeinformation')}}" class="validate" id="validate">
      <div class="card-body">
        {{ csrf_field() }}
        <div class="row">
          <input type="hidden" name="client_id" value="{{$clients->id}}">
          <fieldset class="border border-info container-fluid col-md-12 p-2 mb-2">
            <legend  class="w-auto"><small class="mx-2 text-info">Mediator.</small></legend>
            <div class="row">
              {{-- <div class="form-group col">
                <label for="name_data" class="control-label">Full Name<span class="text-danger">*</span></label>
                <select class="form-control" name="mediator_name" id="name_data">
                  <option value="">Select Mediator</option>
                  @foreach ($mediators as $key => $mediator)
                  <option value="{{ $mediator->id }}" >
                    {{$mediator->name}}
                  </option>
                  @endforeach
                </select>
              </div> --}}
              <div class="form-group col">
                <label for="mediator_name" class="control-label ">Full Name:<span class="text-danger">*</span></label>
                <input type="text"  class="form-control max" id="mediator_name" name="mediator_name" placeholder="Enter mediator name">
              </div>
              <div class="form-group col">
                <label for="phone_data" class="control-label ">Phone No:</label>
                <input type="text"  class="form-control max" id="mediator_phone" placeholder="Enter phone no" name="mediator_phone">
              </div>
            </div>
          </fieldset>
          <div class="form-group col-md-6">
            <label for="name">First Meeting<span class="text-danger">*</span></label>
            <input type="text"  class="form-control max" id="first_meeting" placeholder="Enter the phone" name="first_meeting" autocomplete="off" autofocus>
          </div>
          <div class="form-group col-md-6">
            <label for="name">Next Meeting</label>
            <input type="text"  class="form-control max" id="next_meeting" placeholder="Enter the date" name="next_meeting" autocomplete="off" autofocus>
          </div>
          <div class="form-group col-md-4">
             <label for="project_id" class="control-label">Project <span class="text-danger">*</span></label>
            <select class="form-control" name="project_id" id="project_id">
              <option value="">Select Project</option>
              @foreach ($projects as $key => $project)
              <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : ''}}>
                {{$project->name}}
              </option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="name">Spend Time<span class="text-danger">*</span><small>(in minute)</small></label>
            <input type="text"  class="form-control max" id="spend_time" placeholder="Enter time spend" name="spend_time" autocomplete="off" autofocus>
          </div>
          <div class="form-group col-md-4">
            <label for="name">Time<span class="text-danger">*</span></label>
            <input type="time"  class="form-control max" id="time" placeholder="Enter time spend" name="time" autocomplete="off" autofocus>
          </div>
          <fieldset class="border border-info container-fluid col-md-12 p-2 mb-2">
            <legend  class="w-auto"><small class="mx-2 text-info">Contact Person</small></legend>
            <div class="row">
              {{-- <div class="form-group col">
                <label for="name_data" class="control-label">Full Name<span class="text-danger">*</span></label>
                <select class="form-control" name="contact_name" id="contact_data">
                  <option value="">Select Contact Person</option>
                  @foreach ($contacts as $key => $contact)
                  <option value="{{ $contact->id }}" >
                    {{$contact->c_name}}
                  </option>
                  @endforeach
                </select>
              </div> --}}
              <div class="form-group col">
                <label for="phone_data" class="control-label ">Full Name:<span class="text-danger">*</span></label>
                <input type="text"  class="form-control max" id="c_name" placeholder="Enter phone no" name="c_name" s>
              </div>
              <div class="form-group col">
                <label for="phone_data" class="control-label ">Phone No:</label>
                <input type="text"  class="form-control max" id="c_phone" placeholder="Enter phone no" name="c_phone">
              </div>
              <div class="form-group col">
                <label for="phone_data" class="control-label ">Email:</label>
                <input type="text"  class="form-control max" id="c_email" placeholder="Enter phone no" name="c_email" s>
              </div>
              <div class="form-group col">
                <label for="phone_data" class="control-label ">Post:</label>
                <input type="text"  class="form-control max" id="c_post" placeholder="Enter phone no" name="c_post">
              </div>
            </div>
          </fieldset>
          <div class="form-group col-md-12">
            <label for="name">Client Point of view</label>
            <textarea  class="form-control max" id="description" name="description" rows="4" cols="50">
            </textarea>
          </div>
          <div class="form-group col-md-12">
            <label for="priority">Priority:</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priority" id="high" value="1"checked>
              <label class="form-check-label" for="high">
                High
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priority" id="medium" value="2">
              <label class="form-check-label" for="medium">
                Medium
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priority" id="low" value="3">
              <label class="form-check-label" for="low">
                Low
              </label>
            </div>
          </div>
          {{-- <div class="form-group col-md-12">
            <label>Priority</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="checkbox" value="1">
              <label class="form-check-label">High</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="checkbox" value="2">
              <label class="form-check-label">Medium</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="checkbox" value="3">
              <label class="form-check-label">Low</label>
            </div> 
          </div> --}}
      </div>
      </div>
      <div class="card-footer justify-content-between">
        <button type="submit" class="btn btn-info text-capitalize">Save</button>
      </div>
    </form>
  </div>
</section>
@endsection
@push('javascript')
<script type="text/javascript" src="{{URL::to('/')}}/backend/js/nepali.datepicker.v2.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var currentDate = NepaliFunctions.ConvertDateFormat(NepaliFunctions.GetCurrentBsDate(), "YYYY-MM-DD");
  $('#first_meeting').val(currentDate);
  $('#first_meeting').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    disableAfter: currentDate,
    });
  $('#next_meeting').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 10,
    // disableAfter: currentDate,
    });
  });
</script>
<script src="{{URL::to('/')}}/backend/js/jquery.validate.js"></script>
<script>
$().ready(function() {
  $("#validate").validate({
   rules: {
      mediator_name: "required",
      spend_time: "required",
      time: "required",
      c_name: "required",
      description: "required",
      project_id: "required",
    },
    messages: {
      mediator_name: "name field is required",
      spend_time: "spent time field is required",
      time: "time field is required",
      c_name: "name field is required",
      description: "description is required",
      project_id: "select Project",
    },
    highlight: function(element) {
     $(element).css('background', '#ffdddd');
     $(element).css('border-color', 'red');
    },
    unhighlight: function(element) {
     $(element).css('background', '#ffffff');
     $(element).css('border-color', 'green');
    }
  });
});
</script>
<script type="text/javascript">
  $("body").on("change","#name_data", function(event){
    Pace.start();
    var m_name_id = $('#name_data').val(),
        token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type:"POST",
      dataType:"JSON",
      url:"{{route('staff.getMediatorList')}}",
      data:{
        _token: token,
        m_name_id: m_name_id
      },
      success: function(response){
        console.log(response);
        $.each( response, function( i, val ) {
             $('#phone_data').val(val.phone);
        });
     
      },
      error: function(event){
        alert("Sorry");
      }
    });
        Pace.stop();
  });
</script>
<script type="text/javascript">
  $("body").on("change","#contact_data", function(event){
    Pace.start();
    var c_name_id = $('#contact_data').val(),
        token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type:"POST",
      dataType:"JSON",
      url:"{{route('staff.getContactList')}}",
      data:{
        _token: token,
        c_name_id: c_name_id
      },
      success: function(response){
        console.log(response);
        $.each( response, function( i, val ) {
             $('#c_phone_data').val(val.c_phone);
             $('#c_email_data').val(val.c_email);
             $('#c_post_data').val(val.c_post);
        });
     
      },
      error: function(event){
        alert("Sorry");
      }
    });
        Pace.stop();
  });
</script>
@endpush