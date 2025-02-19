@extends('layouts/layoutMaster')

@section('title', 'OMM-Forms')
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
    @vite(['resources/js/form.js'])
@endsection
@section('content')  <!-- Form Name Input -->
{{-- <label for="formName">Form Name:</label>
<input type="text" id="formName" placeholder="Enter Form Name">
<br><br>

<!-- Dynamic Fields Section -->
<h3>Form Fields</h3>
<div id="fieldsContainer"></div>
<button id="addFieldButton">Add Field</button>
<br><br>
<button id="saveFormButton">Save Form</button>
<div id="savedForms"></div> --}}
<div class="card">
  <div class="card-header pb-0">
      <h5 class="card-title mb-0">Form</h5>
  </div>

  <div class="card-datatable table-responsive">
      <table class="datatables-form table">
          <thead>
              <tr>
                <th></th>
                <th>ID.</th>
                <th>Name</th>
                <th>Actions</th>
              </tr>
          </thead>
      </table>
  </div>
</div>
  <div class="card-body">

  </div>
</div>

<div class="modal fade" id="addformModal" tabindex="-1" aria-modal="true" aria-labelledby="addformModalLabel" role="dialog">
  <div class="modal-dialog modal-lg modal-simple">
      <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body p-0">
              <div class="text-center mb-6">
                  <h4 class="title mb-2" id="addformModalLabel">Add form</h4>
              </div>
              <form id="addformForm" class="row g-4" method="POST" enctype="multipart/form-data">
                @csrf
                   <!-- Form Name Input -->
                   <div class="col-12 col-md-6">
                     <div class="form-floating form-floating-outline">
                       <input type="text" class="form-control" id="name" placeholder="Form Name" name="name" required />
                       <label for="name">Form Name</label>
                     </div>
                   </div>
                   <div class="col-12 col-md-6">
                    <div class="form-floating form-floating-outline">
                      <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter Slug">
                      <label for="slug">Slug</label>
                    </div>
                   </div>
                   <div class="col-12">
                     <div class="form-floating form-floating-outline">
                       <textarea name="description" id="description" class="form-control" cols="30" rows="10" placeholder="Enter Your Form Description"></textarea>
                       <label for="description">Description</label>
                     </div>
                   </div>
                   <div class="col-12">
                    <div class="form-floating form-floating-outline">
                      <input type="file" class="form-control" id="file" name="file">
                      <label for="file">Image</label>
                    </div>
                  </div>
                   <div class="col-12 text-end">
                     <button type="submit" class="btn btn-dark rounded-0">Submit</button>
                   </div>

                 </form>
          </div>
      </div>
  </div>
</div>

<script>
     var showUrl = @json(route('form-list.show', ':id'));

  </script>

@endsection
