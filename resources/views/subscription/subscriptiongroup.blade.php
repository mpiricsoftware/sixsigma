@extends('layouts/layoutMaster')
@section('title', 'Sub-Group')
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
    @vite(['resources/js/subgroup-manage.js'])
@endsection

@section('content')
<div class="card">
  <div class="card-header pb-0">
      <h5 class="card-title mb-0">Subscription Group</h5>
  </div>

  <div class="card-datatable table-responsive">
      <table class="datatables-subgroup table">
          <thead>
              <tr>
                  <th></th>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Priority</th>
                  <th>Actions</th>
              </tr>
          </thead>
      </table>
  </div>



  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddsubgroup" aria-labelledby="offcanvasAddsubgroupLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddsubgroupLabel" class="offcanvas-title">Add SubGroup</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

      <div class="offcanvas-body mx-0 flex-grow-0 h-100">
        <form class="add-new-subgroup pt-0" id="addNewsubgroupForm">
            <input type="hidden" name="id" id="id">
            <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="name" placeholder="subgroup name" name="name" aria-label="subgroup name" />
                <label for="name"> Name</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="priority" placeholder="Priority" name="priority" aria-label="subgroup name" />
              <label for="name">Priority</label>
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
