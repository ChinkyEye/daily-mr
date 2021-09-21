@extends('backend.main.app')
@section('content')
<?php $page = substr((Route::currentRouteName()), 6, strpos(str_replace('admin.','',Route::currentRouteName()), ".")); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6 pl-1">
        <h1 class="text-capitalize">Add Project{{-- {{ $page }} --}}</h1>
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
    <form role="form" method="POST" action="{{route('admin.project.store')}}" class="validate" id="validate">
      <div class="card-body">
        {{ csrf_field() }}
        <div class="row">
          <div class="form-group col-md-12">
            <label for="name">Project Name <span class="text-danger">*</span></label>
            <input type="text"  class="form-control max" id="name" placeholder="Enter project name" name="name" autocomplete="off" autofocus>
          </div>
          
          <div class="form-group col-md-12">
            <label for="name">Description <span class="text-danger">*</span></label>
            <textarea class="form-control max" id="description" name="description" rows="4" cols="50" ></textarea>
            {{-- <input type="text"  class="form-control max" id="description" placeholder="Enter the description" name="description" autocomplete="off" autofocus> --}}
          </div>
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
<script src="{{URL::to('/')}}/backend/js/jquery.validate.js"></script>
<script>
$().ready(function() {
  $("#validate").validate({
    rules: {
      name: "required",
      description: "required"
    },
    messages: {
      name: " name field is required **",
      description: " description field is required **"
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