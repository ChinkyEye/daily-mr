@extends('backend.main.app')
@section('content')
<?php $page = substr((Route::currentRouteName()), 6, strpos(str_replace('admin.','',Route::currentRouteName()), ".")); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6 pl-1">
        <h1 class="text-capitalize">Edit Project {{-- {{ $page }} --}}</h1>
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
    <form role="form" method="POST" action="{{ route('admin.project.update',$edit->id) }}" class="validate" id="validate">
      {{ csrf_field() }}
      <input name="_method" type="hidden" value="PATCH">
      <div class="card-body">
        <div class="row">
          <div class="form-group col-md-12">
            <label for="name">Project Name <span class="text-danger">*</span></label>
            <input type="text"  class="form-control max" id="name" placeholder="Enter name" name="name" autocomplete="off" autofocus value="{{$edit->name}}">
          </div>
          
          <div class="form-group col-md-12">
            <label for="name">Description <span class="text-danger">*</span></label>
            <textarea class="form-control max" id="description" name="description" rows="4" cols="50" >{{$edit->description}}</textarea>
            {{-- <input type="text"  class="form-control max" id="description" placeholder="Enter the description" name="description" autocomplete="off" autofocus value="{{$edit->description}}"> --}}
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