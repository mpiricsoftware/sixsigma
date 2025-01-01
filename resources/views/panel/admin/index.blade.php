@extends('layouts/layoutMaster')

@section('title', 'Admin')
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
    @vite(['resources/js/admin-manage.js'])
@endsection

@section('content')
    <!-- Admin List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0">Admin</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-admin table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Sub Group</th>
                        <th>Sub Plan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Admin</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="add-new-user pt-0" id="addNewUserForm">
                    <input type="hidden" name="id" id="user_id">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="Full Name" name="name" aria-label="Full Name" />
                        <label for="add-user-fullname">Full Name</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" id="add-user-email" class="form-control" placeholder="test@example.com" aria-label="test@example.com" name="email" />
                        <label for="add-user-email">Email</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <select class="form-select subgroup" id="subgroup_id" name="subgroup_id">
                          <option></option>
                          @foreach ($subgroup as $subgroup)
                              <option value="{{ $subgroup->id }}">{{ $subgroup->name}}</option>
                          @endforeach
                        </select>
                        <label for="subsgroup_id">Subscription Group</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                      <select class="form-select subplan_id" id="subplan_id" name="subplan_id">
                      </select>
                      <label for="subplan_id">Subscription Plan</label>
                    </div>

                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        var userViewUrl = "{{ route('admin-list.show', ':id') }}";

    </script>
@endsection
