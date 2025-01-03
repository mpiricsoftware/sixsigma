
@extends('layouts.layoutMaster')

@section('title', 'Message')
@section('content')

<div class="container">
  <!-- Thank You Message -->
  <form method="GET">
      <div class="text-center mt-5">
          <div class="card" style="margin: 5%; padding-top: 5%; padding-bottom: 5%">
              <div class="card-body">
                  <h5 class="card-title" style="color: #00a6d5;">Thank you for submitting your Details!!</h5>
                  <p class="card-text">"Your information has been successfully received, and we are delighted to have you on board. Thank you for your trust and confidence in us!"</p><br>
                  <a href="/" class="btn btn-dark rounded-0">Go to Home</a>


              </div>
          </div>
      </div>
  </form>
</div>
@endsection
