@extends('backend.main.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/backend/css/nepali.datepicker.v2.2.min.css" />
@endpush
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      {{-- @if($clients->getClientInfo != Null) --}}
      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <span><h4>{{$clients->fullname}}<h4></span>
              @if($clients->getClientInfo != Null)
               @if($conclusions->first()->getProject)
               <span class="text-info">
                <small>
                  ({{$conclusions->first()->getProject->name}})</small>
                </span>
                @endif
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
            </ul>
          </div>
        </div>
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">About Mediator</h3>
          </div>
          @if($clients->getClientInfo != Null)
          <div class="card-body">
            <strong><i class="fas fa-user-tie mr-1"></i>Name</strong>
            <p class="text-muted">{{$clients->getClientInfo->getMediator->name}}</p>
            <hr>
            <strong><i class="fas fa-phone-volume mr-1"></i>Number</strong>
            <p class="text-muted">{{$clients->getClientInfo->getMediator->phone}}</p>
            <hr>
          </div>
          @endif
        </div>
      </div>

      <div class="col-md-9">
        <div class="card">

          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Detail</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Contact Person</a></li> 
              <li class="nav-item"><a class="nav-link" href="#host" data-toggle="tab">Host</a></li>
            {{--   <li class="nav-item"><a class="nav-link" href="#newschedule" data-toggle="tab">New Schedule</a></li> --}}
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">

              <div class="active tab-pane" id="activity">
                <div class="my-3">
                  @if($clients->getClientInfo != Null)
                  <li class="list-group-item">
                    <b>Conclusion:</b> <a class="float-right col-md-6">{{$clients->getInformation->first()->description}}</a>
                  </li>
                  @endif
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
                  @if($clients->getClientInfo != Null)
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
                  @endif
                </div>
              </div>

              <div class="tab-pane" id="host">
                <div class="">
                  @if($hosts != Null)
                  <div class="time-label">
                    <span class="text-info">
                      Host Detail
                    </span>
                  </div>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b> Hosted Date</b> <a class="float-right"><span class="badge badge-success">{{$hosts->hosted_on}}</span></a>
                    </li>
                    <li class="list-group-item">
                      <b> Agreement Date</b> <a class="float-right"><span class="badge badge-success">{{$hosts->agreement_on}}</span></a>
                    </li>
                    <li class="list-group-item">
                      <b> Latest Renew Date</b> <a class="float-right"><span class="badge badge-success">{{$hosts->latest_renew_date}}</span> <span class="badge badge-danger">{{$days}} Day</span>
                      </a>
                      {{--  <a data-target="#modal-default" data-toggle="modal" class="btn btn-xs btn-outline-success" id="latestdate" href="#modal-default" data-id="{{$hosts->id}}" title="Renew Date"><i class='fa fa-edit'></i></a> --}}
                    </li>
                    <li class="list-group-item">
                      <b> Link</b> <a href="{{$hosts->link}}" class="float-right" target="_blank">{{$hosts->link}} <i class="fas fa-arrow-right"></i></a>
                    </li>
                  </ul>
                  @endif
                </div>
              </div>
              <div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog"  role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-info">
                      <h4 class="modal-title text-capitalize">Renew Date</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form role="form" method="POST" action="{{route('admin.updatedate')}}"  id="signup">
                      {{ method_field('PUT') }}
                      {{ csrf_field() }}
                      <div class="modal-body" >
                        <div class="form-group">
                          <label for="latest_renew_dat">Renew Date</label>
                          <input type="text"  class="form-control" id="latest_renew_date" name="latest_renew_date" required="true"  autocomplete="off"  >
                          <input type="hidden" name="data_id" id="link">
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-info text-capitalize">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
      {{-- @else --}}
      {{-- <div class="text-center col-md-12">
        <h2 class="text-center text-success my-5">PLEASE ADD CLIENTS INFORMATION</h2>
      </div> --}}
      {{-- @endif --}}

    </div>
  </div>
</section>
@endsection
@push('javascript')
<script src="{{URL::to('/')}}/backend/js/jquery.validate.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/backend/js/nepali.datepicker.v2.2.min.js"></script>
<script>
$().ready(function() {
  $("#validate").validate({
    rules: {
      fullname: "required",
      description: "required",
      allocated_time: "required",
    },
    messages: {
      fullname: "name field is required",
      description: "description field is required",
      allocated_time: "time field is required",
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
$(document).ready(function(){
  var currentDate = NepaliFunctions.ConvertDateFormat(NepaliFunctions.GetCurrentBsDate(), "YYYY-MM-DD");
  $('#first_meeting').val(currentDate);
  $('#next_meeting').val(currentDate);
  $('#latest_renew_date').val(currentDate);

  $('#first_meeting').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    disableAfter: currentDate,
    });

  $('#next_meeting').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 10,
    });

   $('#latest_renew_date').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 10,
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
<script>
  $("body").on("click","#latestdate", function(event){
    var data = $(this).attr("data-id");
    $('#link').val(data);
  });
</script>
@endpush
