@extends('backend.main.app')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="text-capitalize">Welcome {{Auth::user()->name}}</h1>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
       {{-- <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog"  role="document">
           <div class="modal-content">
             <div class="modal-header bg-info">
               <h4 class="modal-title text-capitalize">Please insert Batch to continue</h4>
             </div>
               <div class="modal-body" >
                 <div class="form-group">
                   <label for="return_date">This link will take to profile Page</label>
                   <a href="" class="small-box-footer">Click Here <i class="fas fa-arrow-circle-right"></i></a>
                 </div>
               </div>
               <div class="modal-footer justify-content-between">
               </div>
           </div>
         </div>
       </div> --}}

    <div class="row">
      
      
    </div>
  </div>

</section>

@endsection
@push('javascript')
<script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>



@endpush