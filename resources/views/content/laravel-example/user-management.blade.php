@extends('layouts/layoutMaster')

@section('title', 'User Management')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body:not(.modal-open) .select2-container--open{
        z-index:99
    }
</style>
<!-- Vendor Styles -->
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

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/laravel-user-management.js'])
@endsection

@section('content')
    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="me-1">
                  <p class="text-heading mb-1">Users</p>
                  <div class="d-flex align-items-center">
                    <h4 class="mb-1 me-2">{{$totalUser}}</h4>
                    <p class="text-success mb-1">({{ number_format($percentage, 2) }}%)</p>
                  </div>

                  <small class="mb-0">Total Users</small>
                </div>
                <div class="avatar">
                  <div class="avatar-initial bg-label-primary rounded-3">
                    <div class="ri-user-line ri-26px"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="me-1">
                  <p class="text-heading mb-1">Verified Users</p>
                  <div class="d-flex align-items-center">
                    <h4 class="mb-1 me-1">{{$verified}}</h4>
                    <p class="text-success mb-1">({{number_format($verified_p, 2)}}%)</p>
                  </div>
                  <small class="mb-0">Recent analytics</small>
                </div>
                <div class="avatar">
                  <div class="avatar-initial bg-label-success rounded-3">
                    <div class="ri-user-follow-line ri-26px"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="me-1">
                  <p class="text-heading mb-1">Duplicate Users</p>
                  <div class="d-flex align-items-center">
                    <h4 class="mb-1 me-1">{{$userDuplicates}}</h4>
                    <p class="text-danger mb-1">({{number_format($p_duplicates, 2)}}%)</p>
                  </div>
                  <small class="mb-0">Recent analytics</small>
                </div>
                <div class="avatar">
                  <div class="avatar-initial bg-label-danger rounded-3">
                    <div class="ri-group-line ri-26px"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="me-1">
                  <p class="text-heading mb-1">Verification Pending</p>
                  <div class="d-flex align-items-center">
                    <h4 class="mb-1 me-1">{{$notVerified}}</h4>
                    <p class="text-success mb-1">({{number_format($p_notVerified, 2)}}%)</p>
                  </div>
                  <small class="mb-0">Recent analytics</small>
                </div>
                <div class="avatar">
                  <div class="avatar-initial bg-label-warning rounded-3">
                    <div class="ri-user-unfollow-line ri-26px"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0">Search Filter</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead>
                    <tr>
                        <th></th>
                        {{-- <th>Id</th> --}}
                        <th>User</th>
                        <th>Last Name</th>
                        <th>Company</th>
                        <th>State</th>
                        <th>City</th>
                        <th>PhoneNo</th>
                        <th>Status</th>
                        {{-- <th>Email</th> --}}
                        <th>Verified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- modal to add / edit user -->
    <div class="modal fade" id="modalAddUser" tabindex="-1" aria-modal="true" aria-labelledby="modalAddUserLabel">
        <div class="modal-dialog modal-lg modal-simple modal-add-new-user">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div class="text-center mb-6">
                        <h4 class="user-title mb-2" id="modalAddUserLabel">Add user</h4>
                        <p class="user-subtitle">Add new user for express production</p>
                    </div>
                    <form id="addNewUserForm" class="row add-new-user g-5">
                        <input type="hidden" name="id" id="user_id">
                        <div class="col-12 col-md-4">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your UserName">
                            <label for="username">Username</label>
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="add-user-fullname" placeholder="First Name" name="name" aria-label="First Name" />
                                <label for="add-user-firstname">First Name</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-floating form-floating-outline">
                               <input type="text" class="form-control" id="add-user-lastname" placeholder="Last Name" name="lastname" aria-label="Last Name">
                               <label for="lastname">Last Name</label>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="add-user-email" class="form-control" placeholder="test@example.com" aria-label="test@example.com" name="email" />
                                <label for="add-user-email">Email</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="company" id="add-user-company" class="form-control" placeholder="Enter Company" data-allow-clear="true">
                                <label for="add-user-company">Company</label>
                            </div>
                        </div>

                        <div class="col-12">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Your Address">
                            <label for="address">Address</label>
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-floating form-floating-outline">
                            <select name="country" id="country" class="select2 form-select country" data-placeholder="Select country" data-allow-clear="true">
                              <option></option>
                              @foreach ($country as $c)
                                  <option value="{{$c->id}}">{{ $c->name }}</option>
                              @endforeach
                          </select>
                          <label for="country">Country</label>
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-floating form-floating-outline">
                            <select name="state" id="state" class="select2 form-select state" data-placeholder="Select State" data-allow-clear="true">
                              <option></option>
                            </select>
                            <label for="state">State</label>
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="form-floating form-floating-outline">
                            <select name="city" id="city" class="select2 form-select city" data-placeholder="Select City" data-allow-clear="true">
                              <option value=""></option>
                            </select>
                            <label for="city">City</label>
                          </div>
                        </div>
                        {{-- <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select name="role" id="add-user-department" class="select2 form-select" data-placeholder="Select Role" data-allow-clear="true">
                                    <option value="role">User</option>
                                    <option value="role">Admin</option>

                                </select>
                                <label for="add-user-company">Roles</label>
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input type="number" id="office_no" class="form-control" name="office_no" placeholder="Enter Your OfficeNo">
                            <label for="office_no">Office No</label>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-floating form-floating-outline">
                           <select name="status" id="status" class="select2 form-select userStatus" data-placeholder="Select Status" data-allow-clear="true">
                            <option value=""></option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                           </select>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" name="mobileno" id="mobileno" placeholder="Enter Your PhoneNo" data-allow-clear="true">
                            <label for="PhoneNo">PhoneNo</label>
                          </div>
                        </div>

                        {{-- <div class="col-md-6">
                          <div class="form-floating form-floting-outline">
                            <select name="role" id="role" class="select2 form-select role" data-placeholder="Select Role" data-allow-clear="true">
                              <option></option>
                              @foreach ($roles as $r)
                                <option value="{{$r->id}}">{{$r->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> --}}
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                           <select name="usertype" id="usertype" class="select2 form-select usertype" data-placeholder="Select Role" data-allow-clear="true">
                              <option>Select Role</option>
                              @foreach ($roles as $r)
                              <option value="{{ $r->name }}" {{ old('usertype') == $r->name ? 'selected' : '' }}>
                                {{ $r->name }}
                            </option>
                              @endforeach
                           </select>
                          </div>
                        </div>

                        <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="button" class="btn btn-outline-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark rounded-0">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var userViewUrl = "{{ route('user-list.show', ':id') }}";

        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('.modal')
            });
        });
    </script>

@endsection
