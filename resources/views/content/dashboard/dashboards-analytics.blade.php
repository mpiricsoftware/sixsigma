
@extends('layouts/layoutMaster')

@section('title', 'Dashboard-Business Excellence')
@section('content')

  <div class="card">
      <div class="d-flex flex-column align-items-center">
          <img src="{{ asset('assets/img/logo/1.png') }}" class="img-fluid mb-2">
          <br>
      </div>
    </div>

    <br><br>
    <div class="card">
      <div class="d-flex flex-column align-items-center">
          <img src="{{ asset('assets/img/logo/2.png')}}" alt="Image 2" class="img-fluid mb-2">
      </div>
    </div>
    <br>
    <br>
    <div class="card">
      <div class="d-flex flex-column align-items-center">
          <img src="{{ asset('assets/img/logo/3.png')}}" alt="Image 3" class="img-fluid mb-2">
      </div>
  </div>
<br>
<br>


@endsection
