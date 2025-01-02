
@extends('layouts.layoutMaster')

@section('title', 'Dashboard-Business Excellence')
@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-lg-8">
          <div class="card mb-8">
              <div class="d-flex flex-column align-items-center">
                <a href="{{url('/home')}}">
                  <img src="{{ asset('assets/img/logo/1.png') }}" class="img-fluid mb-2" alt="Image 1" style="border-radius:10px">
                </a>
                </div>
          </div>

          <div class="card mb-8">
              <div class="d-flex flex-column align-items-center">
                  <img src="{{ asset('assets/img/logo/2.png') }}" class="img-fluid mb-2" alt="Image 2" style="border-radius: 10px">
              </div>
          </div>

          <div class="card mb-8">
              <div class="d-flex flex-column align-items-center">
                  <img src="{{ asset('assets/img/logo/3.png') }}" class="img-fluid mb-2" alt="Image 3" style="border-radius: 10px">
              </div>
          </div>
      </div>
  </div>
</div>



@endsection
