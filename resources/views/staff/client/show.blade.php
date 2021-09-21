@extends('staff.main.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/backend/css/nepali.datepicker.v2.2.min.css" />
@endpush
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      @if($clients->getClientInfo != Null)
      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <span><h4>{{$clients->fullname}}<h4></span>
                @if($conclusions->first()->getProject)
                <span class="text-info">
                  <small>
                    ({{$conclusions->first()->getProject->name}})</small>
                </span>
                @endif
               
            </div>
            <h3 class="profile-username text-center"></h3>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Address</b> <a class="float-right">{{$clients->address}}</a>
              </li>
              <li class="list-group-item">
                <b>Contact No</b> <a class="float-right">{{$clients->phone}}</a>
              </li>
              <li class="list-group-item">
                <b>Email</b> <a class="float-right">{{$clients->email}}</a>
              </li>
              <li class="list-group-item">
                <b>Priority</b>
                {{-- <a href="" class="btn btn-xs"></a> --}}
                @php
                if($clients->getLatest->priority == '1'){
                  $display="High";
                }
                elseif($clients->getLatest->priority == '2'){
                  $display="Medium";
                }
                else{
                  $display="Low";
                }
                @endphp
                <a href="" style="float: right;"><i class="fas fa-square {{$clients->getLatest->priority == '1'? 'text-danger': ($clients->getLatest->priority == '2'? 'text-warning' : 'text-success') }}">{{$display}}</i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">About Mediator</h3>
          </div>
          <div class="card-body">
            <strong><i class="fas fa-user-tie mr-1"></i>Name</strong>
            <p class="text-muted">{{$clients->getClientInfo->getMediator->name}}</p>
            <hr>
            <strong><i class="fas fa-phone-volume mr-1"></i>Number</strong>
            <p class="text-muted">{{$clients->getClientInfo->getMediator->phone}}</p>
            <hr>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="card">

          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Detail</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Contact Person</a></li>
              <li class="nav-item"><a class="nav-link" href="#newschedule" data-toggle="tab">New Schedule</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="my-3">
                  <li class="list-group-item">
                    <b>Conclusion:</b> <a class="float-right col-md-6">{{$clients->getInformation->first()->description}}</a>
                  </li>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover my-0 table-sm">
                    <thead class="bg-dark">
                      <tr class="text-center">
                        <th width="5%">SN</th>
                        <th>Conclusion</th>
                        <th>Schedule Date</th>
                        <th>Next Meeting Date</th>
                      </tr>
                    </thead> 
                    @foreach($conclusions as $key=>$data)             
                    <tr class="text-center">
                      <td>{{$key+1}}</td>
                      <td>{{$data->description}}</td>
                      <td>{{$data->first_meeting}}</td>
                      <td>{{$data->next_meeting}}</td>
                    </tr>
                    @endforeach
                  </table>
                </div>
              </div>

              <div class="tab-pane" id="timeline">
                <div class="">
                  <div class="time-label">
                    <span class="text-info">
                      Contact Person Detail
                    </span>
                  </div>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b> Full Name</b> <a class="float-right">{{$clients->getClientInfo->getContact->name}}</a>
                    </li>
                    <li class="list-group-item">
                      <b> Contact No</b> <a class="float-right">{{$clients->getClientInfo->getContact->phone}}</a>
                    </li>
                    <li class="list-group-item">
                      <b> Email</b> <a class="float-right">{{$clients->getClientInfo->getContact->email}}</a>
                    </li>
                    <li class="list-group-item">
                      <b> Post</b> <a class="float-right">{{$clients->getClientInfo->getContact->post}}</a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="tab-pane" id="newschedule">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('staff.storeschedule',$clients->id)}}" class="validate" id="validate">
                  {{ csrf_field() }}
                  {{-- <input type="text" name="project_id" value="@foreach($clients->getInformation as $key =>$data) {{$data->project_id}} @endforeach"> --}}
                  <input type="hidden" name="project_id" value="{{$conclusions->first()->project_id}}">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Conclusion</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="description" rows="2" cols="20" name="description"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Schedule Date</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="first_meeting" name="first_meeting" placeholder="date">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Schedule Time</label>
                    <div class="col-sm-4">
                      <input type="time" class="form-control" id="allocated_time" name="allocated_time" placeholder="Time">
                    </div>
                    <label for="inputEmail" class="col-sm-2 col-form-label">Spend Time</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="spend_time" name="spend_time" placeholder="Spend time in min">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Next Meeting Date</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="next_meeting" name="next_meeting" placeholder="Next Meeting Date">
                    </div>
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
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>

            </div>
          </div>

        </div>
      </div>
      @else
      <div class="text-center col-md-12">
         {{-- <h2 style="text-align: center;color: green;vertical-align: middle;line-height: 200px ">PLEASE ADD CLIENTS INFORMATION</h2> --}}
        <h2 class="text-center text-success my-5">PLEASE ADD CLIENTS INFORMATION</h2>
      </div>
      @endif

    </div>
  </div>
</section>
@endsection
@push('javascript')
<script type="text/javascript" src="{{URL::to('/')}}/backend/js/nepali.datepicker.v2.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var currentDate = NepaliFunctions.ConvertDateFormat(NepaliFunctions.GetCurrentBsDate(), "YYYY-MM-DD");
  $('#first_meeting').val(currentDate);
  // $('#next_meeting').val(currentDate);
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
      fullname: "required",
      description: "required",
      allocated_time: "required",
      spend_time: "required",
    },
    messages: {
      fullname: "name field is required",
      description: "description field is required",
      allocated_time: "time field is required",
      spend_time: "time is required",
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
@endpush
