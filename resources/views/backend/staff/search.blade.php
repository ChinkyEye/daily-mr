@extends('backend.main.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/backend/css/nepali.datepicker.v2.2.min.css" />
@endpush
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6 pl-1">
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="card">
    <div class="">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md p-0">
            <div class="tab-content p-3" id="nav-tabContent">
              <form role="form" class="row mb-3" method="GET" action="{{route('admin.staffwork.search')}}">
                {{ csrf_field() }}
                <div class="col-md">
                  <input type="hidden" name="staff_id" value="{{$users->id}}">
                  <input type="date"  class="form-control max" id="from_date" placeholder="From Date" name="from_date"  autocomplete="off" value="{{$request->from_date}}">
                </div>
                <div class="col-md">
                  <input type="date"  class="form-control max" id="to_date" placeholder="To Date" name="to_date"  autocomplete="off" value="{{$request->to_date}}">
                </div>
                <div class="col-md-2">
                  <div class="btn-group btn-block">
                    <button type="submit" name="search" value="profile" id="search" class="btn btn-primary">Search</button>
                  </div>
                </div>
              </form>
              <div id="printTable">
                <div class="text-center">
                  <h5></h5>
                </div>
                <div class="row">
                  <div class="table-responsive col-md-12">
                    <table class="table table-bordered table-hover table-sm">
                      <thead class="bg-dark">
                        <tr class="text-center v-align-middle">
                          <th width="5%">SN</th>
                          <th class="text-left">Client</th>
                          <th class="text-left">Address</th>
                          <th class="text-left">Very First Meeting</th>
                          <th class="text-left">Created At</th>
                          <th>Status</th>
                        </tr>
                      </thead> 
                      @foreach($search_datas as $key => $data)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->getClient->fullname}}</td>
                        <td>{{$data->getClient->address}}</td>
                        <td>{{$data->first_meeting}}</td>
                        <td>{{$data->getClient->created_at->format('Y-m-d')}}   <span class="badge badge-success">{{$data->created_at->diffForHumans()}}</span></td>
                        <td class="text-center">
                           <a href="{{ route('admin.client.show',$data->id) }}" class="btn btn-xs btn-outline-info" data-placement="top" title="View Detail"><i class="fas fa-eye"></i>
                           </a>
                        </td>
                      </tr>
                      @endforeach
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
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
