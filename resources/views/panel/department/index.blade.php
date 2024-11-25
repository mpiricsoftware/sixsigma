@extends('layouts/layoutMaster')

@section('title', 'Departments')
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
    @vite(['resources/js/department-manage.js'])
@endsection

@section('content')
    <!-- Site List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0">Departments</h5>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-department table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Site Name</th>
                        <th>Company Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Offcanvas to add new department -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddDepartment" aria-labelledby="offcanvasAddDepartmentLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddDepartmentLabel" class="offcanvas-title">Add Department</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="add-new-site pt-0" id="addNewDepartmentForm">
                    <input type="hidden" name="id" id="department_id">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="name" placeholder="Site Name" name="name" aria-label="Site Name" />
                        <label for="name">Department Name</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <select name="site_id" id="site_id" class="select2 form-select" data-placeholder="Select site" data-allow-clear="true">
                            <option></option>
                            @foreach ($sites as $site)
                                <option value="{{$site->id}}">{{ $site->name }}</option>
                            @endforeach
                        </select>
                        <label for="site_id">Site</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <select name="comp_id" id="comp_id" class="select2 form-select" data-placeholder="Select company" data-allow-clear="true">
                            <option></option>
                            @foreach ($companies as $company)
                                <option value="{{$company->id}}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                        <label for="comp_id">Company</label>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('.offcanvas')
            });
        });
    </script>
@endsection
