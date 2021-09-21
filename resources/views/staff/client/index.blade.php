@extends('staff.main.app')
@section('content')
<?php $page = substr((Route::currentRouteName()), 6, strpos(str_replace('staff.','',Route::currentRouteName()), ".")); ?>
<section class="content-header"></section>
<section class="content">
  <div class="card">
    <div class="card-header">
      <a href="{{route('staff.client.create')}}" class="btn btn-sm btn-info text-capitalize rounded-0">Add Client </a>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="{{request()->url()}}" data-source-selector="#card-refresh-content"><i class="fas fa-sync-alt"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover my-0 table-sm">
        <thead class="bg-dark">
          <tr class="text-center">
            <th width="5%">SN</th>
            <th>Full Name</th>
            <th>Phone No</th>
            <th>Address</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Created By</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead> 
        @foreach($clients as $key=>$data)             
        <tr class="text-center">
          <td>{{$key+1}}</td>
          <td>{{$data->fullname}}</td>
          <td>{{$data->phone}}</td>
          <td>{{$data->address}}</td>
          <td>{{$data->email}}</td>
          <td>{{$data->created_at->format('Y-m-d')}} <span class="badge badge-success">{{$data->created_at->diffForHumans()}}</span></td>
          <td>{{$data->getUser->name}}</td>
          <td>
            <a href="{{route('staff.client.active',$data->id)}}" title="{{ $data->is_active == '1' ? 'Click to deactivate' : 'Click to activate' }}">
              <i class="fa {{ $data->is_active == '1' ? 'fa-check check-css' : 'fa-times cross-css' }}"></i>
            </a>
          </td>
          <td>
            <a href="{{ route('staff.client.addinformation',$data->id)}}" class="btn btn-xs btn-outline-info" data-placement="top" title="Add Information"><i class="fas fa-plus"></i></a>
            {{-- <a href="{{ route('staff.client.edit',$data->id) }}" class="btn btn-xs btn-outline-info" data-placement="top" title="Update"><i class="fas fa-edit"></i></a>
            <form action="{{ route('staff.client.destroy',$data->id) }}" method="post" class="d-inline-block" data-placement="top" title="Permanent Delete">
              {{method_field('delete')}}
              {{ csrf_field() }}
              <button class="btn btn-xs btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
            </form> --}}
            <a href="{{ route('staff.client.show',$data->id) }}" class="btn btn-xs btn-outline-info" data-placement="top" title="View Detail"><i class="fas fa-eye"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</section>
@endsection
