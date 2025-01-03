@extends('layouts.layoutMaster')

@section('title', 'Dashboard-Business Excellence')
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
@section('content')

<div class="container mt-5">
  <div class="card mx-auto" style="max-width: 500px; height:80%">
    <div class="card-header text-white text-center">
      <h5 class="card-title mb-0">
        <i class="bi bi-arrow-repeat animate-spin"></i> Account Under Process
      </h5>
    </div>
    <div class="card-body text-center">
      <p class="card-text">
        Your account is currently under review. Please wait while we process your information. Once approved, you'll have full access to the platform.
      </p>
      <p class="text-muted">
        If you have any questions, please contact support.
      </p>
      {{-- <a href="{{ route('home') }}" class="btn btn-secondary">Go to Home</a> --}}
    </div>
  </div>
</div>


@endsection
