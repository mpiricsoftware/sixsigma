@extends('layouts.layoutMaster')

@section('title', 'Details')
@section('content')


  <form method="POST" action="{{ route('inquiry-list.store') }}">
    @csrf
    <div class="card mb-md-5" style="max-width: 700px; width: 100%; margin: 0 auto; height: 350px;">
      <div class="card-header">
        <h5>Concept Details</h5>
      </div>
      <div class="card-body pt-1">
        <div class="row">
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name">
              <label for="name">First Name</label>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" value="{{ $user->lastname }}" name="lastname" id="lastname">
              <label for="lastname">Last Name</label>
            </div>
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-md-12">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" value="{{ $user->company }}" name="company" id="company">
              <label for="company">Company</label>
            </div>
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-md-3">
            <div class="form-floating form-floating-outline">
              <input type="datetime-local" class="form-control" name="date_time" id="date_time">
              <label for="date_time">Follow-Up Date & Time</label>
            </div>
          </div>

          <div class="col-md-5">
            <div class="form-floating form-floating-outline">
              <input type="email" class="form-control" name="email" id="email"   placeholder="Enter Email" value="{{$user->email}}">
              <label for="email">Contact Person Email</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <input
                type="text"
                class="form-control"
                name="Phone_no"
                id="Phone_"
                required
                pattern="^[0-9]{10}$"
                title="Please enter a valid 10-digit phone number"
                placeholder="Enter phone number">
              <label for="Phone_">Contact Person PhoneNo:</label>
            </div>
          </div>

        </div>
        <br>

        <div class="text-center">
          <button type="submit" class="btn btn-dark rounded-0" id="submit">Submit</button>
        </div>
      </div>
    </div>
  </form>

@endsection
