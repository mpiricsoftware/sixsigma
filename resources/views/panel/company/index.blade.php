@extends('layouts/layoutMaster')

@section('title', 'Company')
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
    @vite(['resources/js/company-manage.js'])
@endsection

@section('content')
    <!-- Site List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0">Company</h5>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-company table">
                <thead>
                    <tr>
                      <th></th>
                      <th>NO.</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Country</th>
                      <th>State</th>
                      <th>City</th>
                      <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- add company modal -->
    <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-modal="true">
        <div class="modal-dialog modal-lg modal-simple">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div class="text-center mb-6">
                        <h4 class="title mb-2" id="modalAddUserLabel">Add Company</h4>
                        <p class="subtitle">Add new company for express production</p>
                    </div>
                    <form id="addCompanyForm" class="row add-new-company g-5">
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="add-user-fullname" placeholder="Full Name" name="company_name" aria-label="Full Name" />
                                <label for="add-user-fullname">Full Name</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="add-user-email" class="form-control" placeholder="test@example.com" aria-label="test@example.com" name="email" />
                                <label for="add-user-email">Email</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone No." maxlength="12">
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="gst" name="gst" class="form-control" placeholder="Enter GST No" maxlength="15">
                                <label for="gst">GST</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="cin_no" name="cin_no" class="form-control" placeholder="Enter CIN No" maxlength="21">
                                <label for="cin_no">CIN No</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="billing_address"  name="billing_address" class="form-control" placeholder="Enter Billing Address">
                                <label for="billing_address">Billing Address</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="billing_country" name="billing_country" class="form-select billing_country">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <label for="billing_country">Country</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="billing_state" name="billing_state" class="form-select billing_state">
                                  {{-- <option value="">Select State</option> --}}
                                </select>
                                <label for="billing_state">State</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="billing_city" name="billing_city" class="form-select billing_city">
                                    {{-- <option value="">Select City</option> --}}
                                </select>
                                <label for="billing_city">City</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="billing_zipcode" name="billing_zipcode" class="form-control" placeholder="Enter Billing Zipcode">
                                <label for="billing_zipcode">Billing Zipcode</label>
                            </div>
                        </div>
                        <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Company Modal -->
    <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-modal="true">
        <div class="modal-dialog modal-lg modal-simple">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div class="text-center mb-6">
                        <h4 class="title mb-2" id="exampleModalLabel4">Edit Company</h4>
                        <p class="subtitle">Edit company for express production</p>
                    </div>
                    <form id="editCompanyForm" class="row edit-company g-5">
                        <input type="hidden" id="companyID" name="id" value="">
                        <input type="hidden" id="user_id" name="user_id" value="">
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="company_name" name="company_name" class="form-control company_name" placeholder="Enter Name">
                                <label for="company_name">Name</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="email" name="email" class="form-control email" placeholder="Enter Email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="phone" name="phone" class="form-control phone" placeholder="Enter Phone No." maxlength="12">
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="gst" name="gst" class="form-control gst" placeholder="Enter GST No" maxlength="15">
                                <label for="gst">GST</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="cin_no" name="cin_no" class="form-control cin_no" placeholder="Enter CIN No" maxlength="21">
                                <label for="cin_no">CIN No</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="billing_address"  name="billing_address" class="form-control billing_address" placeholder="Enter Billing Address">
                                <label for="billing_address">Billing Address</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="billing_country" name="billing_country" class="form-select billing_country">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <label for="billing_country">Country</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="billing_state" name="billing_state" class="form-select billing_state">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                <label for="billing_state">State</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="billing_city" name="billing_city" class="form-select billing_city">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <label for="billing_city">City</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="billing_zipcode" name="billing_zipcode" class="form-control billing_zipcode" placeholder="Enter Billing Zipcode">
                                <label for="billing_zipcode">Billing Zipcode</label>
                            </div>
                        </div>
                        <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit Company Modal -->

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('.modal')
            });
        });
    </script>
@endsection
