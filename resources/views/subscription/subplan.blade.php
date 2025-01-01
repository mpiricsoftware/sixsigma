@extends('layouts/layoutMaster')
@section('title', 'Sub-Plan')
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

@section('page-script')
    @vite(['resources/js/subplan-manage.js'])
@endsection


@section('content')
<div class="card">
  <div class="card-header pb-0">
      <h5 class="card-title mb-0">Subscription Plan</h5>
  </div>

  <div class="card-datatable table-responsive">
      <table class="datatables-subplan table">
          <thead>
              <tr>
                  <th></th>
                  <th>Id</th>
                  <th>Group Id</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>plan duration</th>
                  <th>User Limit </th>
                  <th>Site Limit</th>
                  <th>Company Limit</th>
                  <th>Features</th>
                  <th>Description</th>
                  <th>Actions</th>
              </tr>
          </thead>
      </table>
  </div>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddsubplan" aria-labelledby="offcanvasAddsubplanLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddsubplanLabel" class="offcanvas-title">Add Plan</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body mx-0 flex-grow-0 h-100">
      <form class="add-new-subplan pt-0" id="addNewsubplanForm">
          <input type="hidden" name="id" id="id">
          <div class="form-floating form-floating-outline mb-5">
            <select class="form-control" id="subgroup_id" name="subgroup_id">
              <option></option>
              @foreach ($subgroup as $subgroup)
                  <option value="{{ $subgroup->id }}">{{ $subgroup->name}}</option>
              @endforeach
          </select>
            <label for="subsgroup_id">Subscription Group</label>
        </div>
          <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="name" placeholder="name" name="name" aria-label="subplan name" />
              <label for="name"> Name</label>
          </div>
          <div class="form-floating form-floating-outline mb-5">
            <input type="text" class="form-control" id="price" placeholder="price" name="price" aria-label="price" />
            <label for="name">Price</label>
        </div>
        <div class="form-floating form-floating-outline mb-5 d-flex">
          <div class="form-check me-3">
              <input type="radio" id="monthly" name="option" value="monthly" class="form-check-input">
              <label for="monthly" class="form-check-label">Monthly</label>
          </div>
          <div class="form-check">
              <input type="radio" id="yearly" name="option" value="yearly" class="form-check-input">
              <label for="yearly" class="form-check-label">Yearly</label>
          </div>
        </div>

        <div class="form-floating form-floating-outline mb-5">
          <input type="text" class="form-control" id="user_limit" placeholder="User Limit" name="user limit" aria-label="user limit"/>
          <label for="description">User Limit</label>
        </div>

        <div class="form-floating form-floating-outline mb-5">
          <input type="text" class="form-control" id="site_limit" placeholder="Site Limit" name="site limit" aria-label="site limit"/>
          <label for="description">Site Limit</label>
        </div>

        <div class="form-floating form-floating-outline mb-5">
          <input type="text" class="form-control" id="company_limit" placeholder="Company Limit" name="company limit" aria-label="company limit"/>
          <label for="description">Company Limit</label>
        </div>

      <div class="form-floating form-floating-outline mb-5">
        <textarea class="form-control" id="features" placeholder="Features" name="features" aria-label="Features" rows="3"></textarea>
        <label for="features">Features</label>
      </div>

      <div class="form-floating form-floating-outline mb-5">
        <textarea class="form-control" id="description" placeholder="Description" name="description" aria-label="Description" rows="3"></textarea>
        <label for="description">Description</label>
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



