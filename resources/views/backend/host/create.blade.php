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
    <form role="form" method="POST" action="{{route('admin.host.store')}}" class="validate" id="validate">
      <div class="card-body">
        {{ csrf_field() }}
        <div class="row">
          <input type="hidden" name="client_id" value="{{$id}}">
          <div class="form-group col-md-4">
            <label for="hosted_on">Hosted Date<span class="text-danger">*</span></label>
            <input type="text"  class="form-control" id="hosted_on" placeholder="Enter Date" name="hosted_on" autocomplete="off">
          </div>
          <div class="form-group col-md-4">
            <label for="agreement_on">Agreement Date<span class="text-danger">*</span></label>
            <input type="text"  class="form-control" id="agreement_on" placeholder="Enter Date" name="agreement_on" autocomplete="off">
          </div>
          <div class="form-group col-md-4">
            <label for="link">Link<span class="text-danger">*</span></label>
            <input type="text"  class="form-control max" id="link_id" placeholder="Enter the Link" name="link" autocomplete="off">
          </div>
          <div class="form-group col-md-12">
            <label for="name">Server</label>
            <textarea class="form-control max" id="server_id" name="server" rows="3" cols="50"></textarea>
          </div>
      </div>
      </div>
      <div class="card-footer justify-content-between">
        <button type="submit" class="btn btn-info text-capitalize">Save</button>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-sm">
      <thead class="bg-dark text-center">
        <tr>
          <th width="5%">SN</th>
          <th>Hosted Date</th>
          <th>Agreement Date</th>
          <th>Last Renew Date</th>
          <th>Link</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($hosts as $key => $data)
        <tr class="text-center">
          <td>{{$key+1}}</td>
          <td><span class="badge badge-success">{{$data->hosted_on}}</span></td>
          <td><span class="badge badge-success">{{$data->agreement_on}}</span></td>
          <td><span class="badge badge-success">{{$data->latest_renew_date}}</span>
             <a data-target="#modal-default" data-toggle="modal" class="btn btn-xs btn-outline-success" id="latestdate" href="#modal-default" data-id="{{$data->id}}" title="Renew Date"><i class='fa fa-edit'></i></a>
          </td>
          <td>{{$data->link}}</td>
          <td>
            {{-- <a href="{{ route('admin.host.show',$data->id)}}" class="btn btn-xs btn-outline-info" data-placement="top" title="View Detail"><i class="fas fa-eye"></i>
            </a> --}}
            <a href="{{ route('admin.host.edit',$data->id)}}" class="btn btn-xs btn-outline-info" data-placement="top" title="View Detail"><i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.host.destroy',$data->id) }}" method="post" class="d-inline-block delete-confirm" data-placement="top" title="Permanent Delete">
              {{method_field('delete')}}
              {{ csrf_field() }}
              <button class="btn btn-xs btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>
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
            <label for="zoom_link">Renew Date</label>
            <input type="text"  class="form-control" id="latest_renew_date" name="latest_renew_date" required="true"  autocomplete="off" @foreach($hosts as $key=>$host)  value="{{$host->latest_renew_date}}" @endforeach >
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
  $('#hosted_on').val(currentDate);
  $('#agreement_on').val(currentDate);
  // $('#latest_renew_date').val(currentDate);
  $('#hosted_on').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 10,
    disableAfter: currentDate,
  });
  $('#latest_renew_date').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 10,
  });
  $('#agreement_on').nepaliDatePicker({
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