@extends('layouts/layoutMaster')

@section('title', 'User Management - View')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/tagify/tagify.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss'
    ])
@endsection

@section('page-style')
    @vite([
        'resources/assets/vendor/scss/pages/page-user-view.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
        'resources/assets/vendor/libs/cleavejs/cleave.js',
        'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/tagify/tagify.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js'
    ])
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/modal-edit-user.js',
        'resources/assets/js/app-user-view.js',
        'resources/assets/js/app-user-view-account.js'
    ])
@endsection

@section('content')
    <div class="row gy-6 gy-md-0">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded-3 mb-4" src="{{asset('assets/img/avatars/1.png')}}" height="120" width="120" alt="User avatar" />
                            <div class="user-info text-center">
                                <h5>{{$user->name}}</h5>
                                <span class="badge bg-label-danger rounded-pill">Subscriber</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-4 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Username:</span>
                                <span>{{$user->name}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Email:</span>
                                <span>{{$user->email}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Status:</span>
                                <span class="badge bg-label-success rounded-pill">Active</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Role:</span>
                                <span>{{$user->roles[0]->name}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Contact:</span>
                                <span>(123) 456-7890</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Country:</span>
                                <span>England</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-primary me-4" data-bs-target="#editUser" data-bs-toggle="modal">Edit</a>
                            <a href="javascript:;" class="btn btn-outline-danger suspend-user">Suspend</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Tabs -->
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6 row-gap-2">
                    <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/account')}}"><i class="ri-group-line me-2"></i>Account</a></li>
                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="ri-lock-2-line me-2"></i>Security</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/billing')}}"><i class="ri-bookmark-line me-2"></i>Billing & Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/notifications')}}"><i class="ri-notification-4-line me-2"></i>Notifications</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/connections')}}"><i class="ri-link-m me-2"></i>Connections</a></li>
                </ul>
            </div>
            <!--/ User Tabs -->

            <!-- Change Password -->
            <div class="card mb-6">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <form id="formChangePassword" method="POST" onsubmit="return false">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <h5 class="alert-heading mb-1">Ensure that these requirements are met</h5>
                            <span>Minimum 8 characters long, uppercase & symbol</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="row gx-5">
                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="newPassword">New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer text-heading"><i class="ri-eye-off-line"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="confirmPassword">Confirm New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer text-heading"><i class="ri-eye-off-line"></i></span>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary me-2">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Change Password -->

            <!-- Two-steps verification -->
            <div class="card mb-6">
                <div class="card-header">
                    <h5 class="mb-0">Two-steps verification</h5>
                    <span class="card-subtitle">Keep your account secure with authentication step.</span>
                </div>
                <div class="card-body pt-0">
                    <h6 class="mb-1">SMS</h6>
                    <div class="mb-4">
                        <div class="d-flex w-100 action-icons">
                            <input id="defaultInput" class="form-control form-control-sm me-5" type="text" placeholder="+1(968) 819-2547">
                            <a href="javascript:;" class="btn btn-icon btn-outline-secondary me-2" data-bs-target="#enableOTP" data-bs-toggle="modal"><i class="ri-edit-box-line ri-22px"></i></a>
                            <a href="javascript:;" class="btn btn-icon btn-outline-secondary"><i class="ri-user-add-line ri-22px"></i></a>
                        </div>
                    </div>
                    <p class="mb-0">Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.
                        <a href="javascript:void(0);" class="text-primary">Learn more.</a>
                    </p>
                </div>
            </div>
            <!--/ Two-steps verification -->

        </div>
        <!--/ User Content -->
    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-edit-user')
    @include('_partials/_modals/modal-enable-otp')
    @include('_partials/_modals/modal-upgrade-plan')
    <!-- /Modal -->
@endsection
