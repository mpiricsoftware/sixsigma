@extends('layouts.layoutMaster')

@section('title', 'Quiz')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
@section('content')
<div class="container mt-5">
  <form id="form-id" method="POST" action="{{ route('details-list.store') }}">
    @csrf
    <div class="card mx-10 mb-md-5" style="margin: 0 auto;">
        <div class="card-header">
            <h5>Assessment Details</h5>
        </div>
        <input type="hidden" id="id" name="id" value="{{ $form->id }}">
        <div class="card-body pt-1">
            <div class="row">
                <div class="col-md-6 mb-5">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control"  name="name"
                            id="name" placeholder="Enter First Name" value="{{$user->name}}">
                        <label for="name">First Name</label>
                    </div>
                </div>

                <div class="col-md-6 mb-5">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control"  name="lastname"
                            id="lastname" placeholder="Enter Last Name" value="{{$user->lastname}}">
                        <label for="lastname">Last Name</label>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control"  name="company"
                            id="company" placeholder="Enter Company" value="{{$user->company}}">
                        <label for="company">Company</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-5">
                    <div class="form-floating form-floating-outline">
                        <input type="datetime-local" class="form-control" name="date_time" id="date_time" >
                        <label for="date_time">PreFor Date & Time</label>
                    </div>
                </div>

                <div class="col-md-5 mb-5">
                    <div class="form-floating form-floating-outline">
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Enter Email" value="{{$user->email}}">
                        <label for="email">Contact Person Email</label>
                    </div>
                </div>

                <div class="col-md-4 mb-5">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="Phone_no" id="Phone_" required
                            pattern="^[0-9]{10}$" title="Please enter a valid 10-digit phone number"
                            placeholder="Enter phone number" value="{{$user->office_no}}">
                        <label for="Phone_">Contact Person PhoneNo:</label>
                    </div>
                </div>

            </div>
            <div class="row mb-5">
                <div class="col-md-7">
                    <div class="form-floating form-floating-outline">
                        <select name="company_size" id="company_size" class="form-control">
                          <option value="Select Size">Select Size</option>

                          <option value="0-100">0-100</option>
                          <option value="100-500">100-500</option>
                          <option value="500-2000">500-2000</option>
                          <option value="2000+">2000+</option>
                        </select>
                        <label for="company_size">Company Size</label>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" id="form_name" name="form_name"
                             placeholder="Form Name" value="{{$form->name}}">
                        <label for="form_name">Form Name</label>
                    </div>
                </div>



            </div>
            <button type="submit" id="hidden-submit" style="display: none;"></button>
            <div class="text-center mb-5">
              <a href="{{ url('/home',['slug' => $form->slug]) }}" class="btn btn-dark rounded-0" id="go-to-questions">
                  Go to Questions
              </a>
          </div>

        </div>
    </div>
</form>
<script>
 document.getElementById('go-to-questions').addEventListener('click', function(event) {
    event.preventDefault(); // Stop immediate redirect

    let form = document.getElementById('form-id');

    // Manually submit the form
    form.submit();

    // Wait for form submission and then redirect
    setTimeout(() => {
        window.location.href = "{{ url('/home', ['slug' => $form->slug]) }}";
    }, 1000); // Delay to allow form submission
});

  </script>
</div>

@endsection
