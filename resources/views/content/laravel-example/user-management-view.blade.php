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
    'resources/assets/js/app-user-view-account.js',
    'resources/assets/js/app-user-view-security.js'
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
                <h5>{{$user->company}}</h5>
                {{-- <span class="badge bg-label-danger rounded-pill">Subscriber</span> --}}
              </div>
            </div>
          </div>
          {{-- <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
            <div class="d-flex align-items-center me-5 gap-4"> --}}
              {{-- <div class="avatar">
                {{-- <div class="avatar-initial bg-label-primary rounded-3">
                  <i class='ri-check-line ri-24px'></i>
                </div> --}}
              {{-- </div> --}}
              {{-- <div>
                <h5 class="mb-0">1.23k</h5>
                <span>Task Done</span>
              </div> --}}
            {{-- </div> --}}
            {{-- <div class="d-flex align-items-center gap-4"> --}}
              {{-- <div class="avatar">
                <div class="avatar-initial bg-label-primary rounded-3">
                  <i class='ri-briefcase-line ri-24px'></i>
                </div>
              </div> --}}
              {{-- <div>
                <h5 class="mb-0">568</h5>
                <span>Project Done</span>
              </div> --}}
            {{-- </div>
          </div> --}}
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
                <span>{{ $user->roles->first()?->name ?? 'N/A' }}</span>
              </li>
              {{-- <li class="mb-2">
                <span class="fw-medium text-heading me-2">Tax id:</span>
                <span>Tax-8965</span>
              </li> --}}
              <li class="mb-2">
                <span class="fw-medium text-heading me-2">Contact:</span>
                <span>{{ $user->mobileno }}</span>
              </li>
              <li class="mb-2">
                <span class="fw-medium text-heading me-2">Address:</span>
                <span>{{$user->address}}</span>
              </li>
              <li class="mb-2">
                <span class="fw-medium text-heading me-2">Country:</span>
                <span>{{ $countryName }}</span>
              </li>
            </ul>
            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-dark rounded-0 me-4" data-bs-target="#editUser" data-bs-toggle="modal">Edit</a>
              <a href="javascript:;" class="btn btn-white rounded-0 suspend-user">Suspend</a>
            </div>
          </div>
        </div>
      </div>
      <!-- /User Card -->
      <!-- Plan Card -->
      {{-- <div class="card mb-6 border border-2 border-primary">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <span class="badge bg-label-primary rounded-pill">Standard</span>
            <div class="d-flex justify-content-center">
              <sup class="h5 pricing-currency mt-5 mb-0 me-1 text-primary">$</sup>
              <h1 class="mb-0 text-primary">99</h1>
              <sub class="h6 pricing-duration mt-auto mb-3 fw-normal">month</sub>
            </div>
          </div>
          <ul class="list-unstyled g-2 my-6">
            <li class="mb-2 d-flex align-items-center"><i class="ri-circle-fill text-body ri-10px me-2"></i><span>10 Users</span></li>
            <li class="mb-2 d-flex align-items-center"><i class="ri-circle-fill text-body ri-10px me-2"></i><span>Up to 10 GB storage</span></li>
            <li class="mb-2 d-flex align-items-center"><i class="ri-circle-fill text-body ri-10px me-2"></i><span>Basic Support</span></li>
          </ul>
          <div class="d-flex justify-content-between align-items-center mb-1 fw-medium text-heading">
            <span>Days</span>
            <span>26 of 30 Days</span>
          </div>
          <div class="progress mb-1 rounded">
            <div class="progress-bar rounded" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <small>4 days remaining</small>
          <div class="d-grid w-100 mt-6">
            <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">Upgrade Plan</button>
          </div>
        </div>
      </div> --}}
      <!-- /Plan Card -->
    </div>
    <!--/ User Sidebar -->


    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
      <!-- User Tabs -->
      <div class="nav-align-top">
        <ul class="nav nav-pills flex-column flex-md-row mb-6 row-gap-2">
          <li class="nav-item"><a class="nav-link"  href="{{ route('app-user-view-account', ['id' => $user->id]) }}"><i class="ri-group-line me-2"></i>Account</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('app-user-view-security', ['id' => $user->id]) }}"><i class="ri-lock-2-line me-2"></i>Security</a></li>
          {{-- <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/billing')}}"><i class="ri-bookmark-line me-2"></i>Billing & Plans</a></li>
          <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/notifications')}}"><i class="ri-notification-4-line me-2"></i>Notifications</a></li>
          <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/connections')}}"><i class="ri-link-m me-2"></i>Connections</a></li> --}}
        </ul>
      </div>
      <!--/ User Tabs -->

      <!-- Change Password -->
      <div class="card mb-6">
        <h5 class="card-header">Change Password</h5>
        <div class="card-body">
          <form id="formChangePassword" method="POST" action="{{route('user-list.store' , $user->id)}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="user_id" value="{{ $user->id }}">

            <!-- Password Requirements Alert -->
            <div class="alert alert-warning alert-dismissible" role="alert">
                <h5 class="alert-heading mb-1">Ensure that these requirements are met</h5>
                <span>Minimum 8 characters long, uppercase & symbol</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Success Message Container (Initially Hidden) -->
            <div class="alert alert-success alert-hide" role="alert" style="display: none">
              <div id="message-container"></div>
          </div>


            <!-- Password fields -->
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

                <div class="text-end" style="padding-top:3%">
                    <button type="submit" class="btn btn-dark rounded-0" id="submitBtn">Change Password</button>
                </div>
            </div>
        </form>

        </div>
      </div>
      <!--/ Change Password -->

      <!-- Two-steps verification -->
      {{-- <div class="card mb-6">
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
      </div> --}}
      <!--/ Two-steps verification -->
    </div>
      <!-- Recent Devices -->
      <div class="card mb-6">
        <h5 class="card-header">Recent Devices</h5>
        <div class="table-responsive table-border-bottom-0">
          <table class="table">
            <thead>
              <tr>
                <th class="text-truncate">Browser</th>
                <th class="text-truncate">Device</th>
                <th class="text-truncate">Location</th>
                <th class="text-truncate">Recent Activities</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-truncate"><img src="{{asset('assets/img/icons/brands/chrome.png')}}" alt="Chrome" class="me-4" width="22" height="22"><span class="text-heading">Chrome on Windows</span></td>
                <td class="text-truncate">HP Spectre 360</td>
                <td class="text-truncate">Switzerland</td>
                <td class="text-truncate">10, July 2021 20:07</td>
              </tr>
              <tr>
                <td class="text-truncate"><img src="{{asset('assets/img/icons/brands/chrome.png')}}" alt="Chrome" class="me-4" width="22" height="22"><span class="text-heading">Chrome on iPhone</span></td>
                <td class="text-truncate">iPhone 12x</td>
                <td class="text-truncate">Australia</td>
                <td class="text-truncate">13, July 2021 10:10</td>
              </tr>
              <tr>
                <td class="text-truncate"><img src="{{asset('assets/img/icons/brands/chrome.png')}}" alt="Chrome" class="me-4" width="22" height="22"><span class="text-heading">Chrome on Android</span></td>
                <td class="text-truncate">Oneplus 9 Pro</td>
                <td class="text-truncate">Dubai</td>
                <td class="text-truncate">14, July 2021 15:15</td>
              </tr>
              <tr>
                <td class="text-truncate"><img src="{{asset('assets/img/icons/brands/chrome.png')}}" alt="Chrome" class="me-4" width="22" height="22"><span class="text-heading">Chrome on MacOS</span></td>
                <td class="text-truncate">Apple iMac</td>
                <td class="text-truncate">India</td>
                <td class="text-truncate">16, July 2021 16:17</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!--/ Recent Devices -->


    <!--/ User Content -->
  </div>
</div>
  <!-- Modal -->
  @include('_partials/_modals/modal-edit-user')
  @include('_partials/_modals/modal-enable-otp')
  @include('_partials/_modals/modal-upgrade-plan')
  <!-- /Modal -->
@endsection

