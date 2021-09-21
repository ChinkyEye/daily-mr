@extends('staff.main.app')
@section('content')
<?php $page = substr((Route::currentRouteName()), 6, strpos(str_replace('admin.','',Route::currentRouteName()), ".")); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6 pl-1">
        <h1 class="text-capitalize">Add Client {{-- {{ $page }} --}}</h1>
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
    <form role="form" method="POST" action="{{route('staff.contact.store')}}" class="validate" id="validate">
      <div class="card-body">
        {{ csrf_field() }}
        <div class="row">
          <div class="form-group col-md-6">
            <label for="name">Full Name <span class="text-danger">*</span></label>
            <input type="text"  class="form-control max" id="fullname" placeholder="Enter fullname" name="fullname" autocomplete="off">
          </div>
          <div class="form-group col-md-6">
            <label for="name">Phone No:</label>
            <input type="text"  class="form-control max" id="phone" placeholder="Enter the phone" name="phone" autocomplete="off">
          </div>
          <div class="form-group col-md-6">
            <label for="name">Address</label>
            <input type="text"  class="form-control max" id="address" placeholder="Enter the address" name="address" autocomplete="off">
          </div>
          <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="text"  class="form-control max" id="email" placeholder="Enter email" name="email" autocomplete="off">
          </div>
          <div class="form-group col-md-6">
            <label for="post">Post</label>
            <input type="text"  class="form-control max" id="post" placeholder="Enter post" name="post" autocomplete="off">
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
      fullname: "required",
    },
    messages: {
      fullname: "name field is required",
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