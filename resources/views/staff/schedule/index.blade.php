@extends('staff.main.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/backend/css/nepali.datepicker.v2.2.min.css" />
@endpush
@section('content')
<?php $page = substr((Route::currentRouteName()), 6, strpos(str_replace('admin.','',Route::currentRouteName()), ".")); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6 pl-1">
        <h1 class="text-capitalize">Add New Schedule</h1>
      </div>
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
    <form role="form" method="POST" action="{{route('staff.schedule.store')}}" class="validate" id="validate">
      <div class="card-body">
        {{ csrf_field() }}
        <div class="row">
          <input type="hidden" name="client_id" value="{{$request->client_id}}">
          <div class="form-group col-md-6">
            <label for="name">Conclusion<span class="text-danger">*</span></label>
            <input type="text"  class="form-control max" id="conclusion" placeholder="Enter conslusion" name="conclusion" autocomplete="off" autofocus>
          </div>
          <div class="form-group col-md-6">
            <label for="name">Schedule Date:</label>
            <input type="text"  class="form-control max" id="date" placeholder="Enter the date" name="date" autocomplete="off" autofocus>
          </div>
      </div>
      </div>
      <div class="card-footer justify-content-between">
        <button type="submit" class="btn btn-info text-capitalize">Save</button>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table table-bordered table-hover my-0 table-sm">
        <thead class="bg-dark">
          <tr class="text-center">
            <th width="5%">SN</th>
            <th>Conclusion</th>
            <th>Schedule Date</th>
          </tr>
        </thead> 
        @foreach($conclusions as $key=>$data)             
        <tr class="text-center">
          <td>{{$key+1}}</td>
          <td>{{$data->conclusion}}</td>
          <td>{{$data->date}}</td>
          {{-- <td>
            <a href="{{route('staff.mediator.active',$data->id)}}" title="{{ $data->is_active == '1' ? 'Click to deactivate' : 'Click to activate' }}">
              <i class="fa {{ $data->is_active == '1' ? 'fa-check check-css' : 'fa-times cross-css' }}"></i>
            </a>
          </td>
          <td>
            <a href="{{ route('staff.mediator.edit',$data->id) }}" class="btn btn-xs btn-outline-info" data-placement="top" title="Update"><i class="fas fa-edit"></i></a>
            <form action="{{ route('staff.mediator.destroy',$data->id) }}" method="post" class="d-inline-block" data-placement="top" title="Permanent Delete">
              {{method_field('delete')}}
              {{ csrf_field() }}
              <button class="btn btn-xs btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
            </form>
          </td> --}}
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</section>
@endsection
@push('javascript')
<script type="text/javascript" src="{{URL::to('/')}}/backend/js/nepali.datepicker.v2.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var currentDate = NepaliFunctions.ConvertDateFormat(NepaliFunctions.GetCurrentBsDate(), "YYYY-MM-DD");
  $('#date').val(currentDate);
  $('#date').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    disableAfter: currentDate,
    });
</script>
<script src="{{URL::to('/')}}/backend/js/jquery.validate.js"></script>
<script>
$().ready(function() {
  $("#validate").validate({
    rules: {
      name: "required"
    },
    messages: {
      name: " name field is required **"
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
@endpush