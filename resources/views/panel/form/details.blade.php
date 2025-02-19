@extends('layouts/layoutMaster')
@section('title', 'Forms-Details')
@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection
@section('page-script')
    @vite(['resources/js/details.js'])
@endsection
@section('content')
<div class="card">
  <div class="card-header pb-0">
      <h5 class="card-title mb-0">Details</h5>
  </div>
  <div class="card-datatable table-responsive">
      <table class="datatables-details table">
          <thead>
              <tr>
                <th></th>
                <th>Id</th>
                <th>UserName</th>
                <th>Email</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
          </thead>
      </table>
  </div>
</div>

<div class="modal fade" id="addcommentModal" tabindex="-1" aria-modal="true" aria-labelledby="addcommentModalLabel" role="dialog">
  <div class="modal-dialog modal-lg modal-simple">
      <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body p-0">
              <div class="text-center mb-6">
                  <h4 class="title mb-2" id="addcommentModalLabel">Add form</h4>
              </div>
              <form id="addformcomment" class="row g-4" method="POST" action="{{route('details-list.store')}}">
                @csrf
                <input type="hidden" name="details_id" id="details_id" value="{{ $id ?? '' }}">


                   <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                      <textarea name="comment" id="comment" class="form-control">{{ old('comment', $details->comment ?? '') }}</textarea>
                      <label for="comment">Comment</label>
                    </div>
                  </div>

                   <div class="col-12 text-end">
                     <button type="submit" class="btn btn-dark rounded-0">Submit</button>
                   </div>

                 </form>
          </div>
      </div>
  </div>
</div>

@endsection
<script>

  var printRoute = "{{ route('dprint', ['id' => ':id','user_id' => ':user_id']) }}";
  var chart = "{{ route('avg', ['id' => ':id', 'user_id' => ':user_id', 'details_id' => ':details_id']) }}";
</script>
