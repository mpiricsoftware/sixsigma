@extends('layouts.layoutMaster')

@section('title', 'Not-Approved')


@section('content')

<div class="container mt-5">
  <div class="card mx-auto" style="max-width: 50%;margin:10%">
    <div class="card-header text-white text-center">
      <h5 class="card-title mb-0" style="color: #14caf3">
         Account Under Process &nbsp;<i class="ri-time-line ri-20px"></i>
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
