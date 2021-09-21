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
        {{-- <h1 class="text-capitalize">Add Hosting Detail</h1> --}}
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
          <li class="breadcrumb-item active text-capitalize">{{ $page }} Page</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="card card-info">
    <form role="form" method="POST" action="{{route('admin.host.update',$hosts->id)}}" class="validate" id="validate">
      <div class="card-body">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="row">
          <input type="hidden" name="client_id" value="{{$hosts->client_id}}">
          <div class="form-group col-md-4">
            <label for="hosted_on">Hosted Date<span class="text-danger">*</span></label>
            <input type="text"  class="form-control" id="hosted_on" placeholder="Enter Date" name="hosted_on" autocomplete="off" value="{{$hosts->hosted_on}}">
          </div>
          <div class="form-group col-md-4">
            <label for="agreement_on">Agreement Date<span class="text-danger">*</span></label>
            <input type="text"  class="form-control" id="agreement_on" placeholder="Enter Date" name="agreement_on" autocomplete="off" value="{{$hosts->agreement_on}}">
          </div>
          <div class="form-group col-md-4">
            <label for="link">Link<span class="text-danger">*</span></label>
            <input type="text"  class="form-control max" id="link_id" placeholder="Enter the Link" name="link" autocomplete="off" value="{{$hosts->link}}">
          </div>
          <div class="form-group col-md-12">
            <label for="name">Server</label>
            <textarea class="form-control max" id="server_id" name="server" rows="3" cols="50">{{$hosts->server}}</textarea>
          </div>
      </div>
      </div>
      <div class="card-footer justify-content-between">
        <button type="submit" class="btn btn-info text-capitalize">Update</button>
      </div>
    </form>
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
      link: "required",
    },
    messages: {
      link: "link is required",
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
  // $('#hosted_on').val(currentDate);
  $('#latest_renew_date').val(currentDate);
  $('#hosted_on').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 10,
    disableAfter: currentDate,
  });
  $('#agreement_on').nepaliDatePicker({
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
<script>
  $("body").on("click","#latestdate", function(event){
    var data = $(this).attr("data-id");
    $('#link').val(data);
  });
</script>
@endpush