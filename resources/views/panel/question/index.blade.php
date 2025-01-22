@extends('layouts.layoutMaster')

@section('title', 'Quiz')

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
    @vite(['resources/js/inquiry.js'])
@endsection

@section('content')

<div class="card">
  <div class="card-header pb-0">
      <h5 class="card-title mb-0">Inquiry</h5>
  </div>
  <div class="card-datatable table-responsive">
      <table class="datatables-Inquiry table">
          <thead>
              <tr>
                <th></th>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone_no</th>
                <th>Company</th>
                <th>Form Name</th>
                <th>PreFor Date & Time </th>
                <th>Designation</th>
                <th>Type</th>
                <th>Action</th>
              </tr>
          </thead>
      </table>
  </div>
</div>
@endsection
<script>
  var printRoute = "{{ route('print', ':id') }}"; // Pass route with placeholder to JavaScript
</script>
