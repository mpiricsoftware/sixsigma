@extends('layouts/layoutMaster')

@section('title', 'Inputs')
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
    @vite('resources\js\input.js')
@endsection
@section('content')

<div class="card">
  <div class="card-header pb-0">
      <h5 class="card-title mb-0">Input</h5>
  </div>

  <div class="card-datatable table-responsive">
      <table class="datatables-input table">
          <thead>
              <tr>
                <th></th>
                <th>ID.</th>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
              </tr>
          </thead>
      </table>
  </div>
</div>

  <div class="container mt-5">
    <div class="modal fade" id="addinputModal" tabindex="-1" aria-modal="true" aria-labelledby="addinputModalLabel" role="dialog">
      <div class="modal-dialog modal-lg modal-simple">
          <div class="modal-content">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body p-0">
                  <div class="text-center mb-6">
                      <h4 class="title mb-2" id="addinputModalLabel">Add form</h4>
                  </div>
                  <form id="addinputForm" class="row add-new-input g-3">
                    @csrf
                      <div class="col-md-4">
                          <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="name" name="name" placeholder="Enter Input Name">
                              <label for="name">Name</label>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="type" name="type" placeholder="Enter Input Type">
                              <label for="type">Type</label>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Input icon">
                              <label for="icon">Icon</label>
                          </div>
                      </div>
                      &nbsp;
                      <div class="col-md-12">
                          <div class="form-floating form-floating-outline">

                              <textarea name="html_code" id="html_code" cols="1" rows="1" class="form-control" placeholder="Enter Input HTML Code"></textarea>
                             <label for="html_code">HTML Code</label>
                          </div>
                      </div>
                      <div class="col-12 text-end">
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                      {{-- <div class="col-md-12">
                        <div class="form-floting form-floating-outline">
                          <button type="button" class="btn btn-primary btn-circle" id="addSection">
                            +
                        </button>
                        <label for="button">Add new Fileds</label>
                      </div>
                    </div> --}}
                  </form>
                  {{-- <div id="dynamicFields"></div>
              </div> --}}
          </div>
      </div>
    </div>
@endsection
{{-- <script>
  $(document).ready(function() {
    let fieldCount = 0;

    // Add new section when "+" button is clicked
    $('#addSection').on('click', function() {
        fieldCount++;

        // Create a new section with 1 row and 3 columns (input fields)
        const newSection = `
            <div class="section-box form-control" id="section_${fieldCount}">
                <div class="row">
                    <!-- Column 1: Choice -->
                    <div class="col-md-4">
                      <div class="form-floting form-floating-outline">
                        <input type="button" id="choice_${fieldCount}" value="Choice" class="form-control">
                        </div>
                    </div>

                    <!-- Column 2: Text -->
                    <div class="col-md-4">
                      <div class="form-floting form-floating-outline">
                        <input type="button" id="text_${fieldCount}" class="form-control" value="Text">
                    </div>
                    </div>
                    <!-- Column 3: Rating -->
                    <div class="col-md-4">
                      <div class="form-floting form-floating-outline">
                        <input type="button" id="rating_${fieldCount}" class="form-control" value="Rating">
                    </div>
                </div>
                </div>
<br>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="date_${fieldCount}" class="form-control" value="Date">
                      </div>
                    </div>

                     <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="file_${fieldCount}" class="form-control" value="Upload File">
                      </div>
                    </div>

                     <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="section_${fieldCount}" class="form-control" value="Section">
                      </div>
                    </div>

                  </div>

            </div>
        `;

        // Append the new section to the dynamic fields container
        $('#dynamicFields').append(newSection);
    });
});

// Function to remove a section
function removeSection(sectionId) {
    $(`#section_${sectionId}`).remove();
}

  </script> --}}

