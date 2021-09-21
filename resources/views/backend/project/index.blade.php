@extends('backend.main.app')
@section('content')
<?php $page = substr((Route::currentRouteName()), 6, strpos(str_replace('admin.','',Route::currentRouteName()), ".")); ?>
<section class="content-header"></section>
<section class="content">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('admin.project.create')}}" class="btn btn-sm btn-info text-capitalize rounded-0">Add {{ $page }} </a>
      {{-- <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="{{request()->url()}}" data-source-selector="#card-refresh-content"><i class="fas fa-sync-alt"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
      </div> --}}
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover my-0 table-sm">
        <thead class="bg-dark">
          <tr class="text-center">
            <th>SN</th>
            <th>Project Name</th>
            <th class="text-left">Project</th>
            <th width="10">Sort</th>
            <th width="100">Action</th>
          </tr>
        </thead> 
        @foreach($datas as $key=>$data)             
        <tr class="text-center">
          <td>{{$key+1}}</td>
          <td>{{$data->name}}</td>
          <td>{{$data->description}}</td>
          <td>
            <a href="{{route('admin.project.active',$data->id)}}" title="{{ $data->is_active == '1' ? 'Click to deactivate' : 'Click to activate' }}">
              <i class="fa {{ $data->is_active == '1' ? 'fa-check check-css' : 'fa-times cross-css' }}"></i>
            </a>
          </td>
          <td>
            <a href="{{ route('admin.project.edit',$data->id) }}" class="btn btn-xs btn-outline-info" data-placement="top" title="Update"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.project.destroy',$data->id) }}" method="post" class="d-inline-block" data-placement="top" title="Permanent Delete">
              {{method_field('delete')}}
              {{ csrf_field() }}
              <button class="btn btn-xs btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</section>
@endsection
