@extends('layouts.layoutMaster')

@section('title', 'Quiz')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
@section('content')
<div class="container mt-5">
  <div id="imageContainer">
    @if ($form->file)
        <img src="{{ asset('storage/' . $form->file) }}" alt="Assessment Image" id="assessmentImage">
    @else
        <p>No image found for this form.</p>
    @endif
</div>
<div class="text-center mb-5" style="padding: 20px;">
  <a href="{{ url('/home',['slug' => $form->slug]) }}" class="btn btn-dark rounded-0" id="go-to-questions">
      Go to Questions
  </a>
</div>
<style>
  #imageContainer {
      display: flex;
      justify-content: center;
      align-items: center;
/* Full viewport height */
  }
  #assessmentImage {
      max-width: 100%;
      height: auto; /* Maintain aspect ratio */
  }
</style>
<script>
    document.getElementById('goToAssessmentBtn').addEventListener('click', function () {
        setTimeout(() => {
            window.location.href = "{{ url('/home', ['slug' => $form->slug]) }}";
        }, 1000); // 1 second delay
    });
</script>
</div>
@endsection
