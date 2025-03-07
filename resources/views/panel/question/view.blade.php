@extends('layouts.layoutMaster')

@section('title', 'OMM-Thank-You')

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
@section('content')



<div class="container">
  <form method="GET">
    {{-- @foreach ($questionIds as $sectionId => $questions)
    <div class="section">
        <h3>Section {{ $sectionId }}</h3>
        <ul>
            @foreach ($questions as $questionId)
                <li>
                    <strong>Question:</strong> {{ $questionTexts[$questionId] ?? 'Question not found' }}
                    <strong>Answers:</strong> {{ $answer}}
                </li>
            @endforeach
        </ul>
    </div>
@endforeach --}}



      <div class="text-center mt-5">
        <input type="hidden" id="id" name="id" value="{{ $form }}">
          <div class="card" style="margin: 5%; padding-top: 5%; padding-bottom: 5%">
              <div class="card-body">
                  <h5 class="card-title" style="color: #00a6d5;">Thank You for Your Submission!!</h5>
                  <p class="card-text">Your answers have been successfully submitted. We appreciate your time and participation.</p><br>

                  <a href="/" class="btn btn-dark rounded-0">Go to Home</a>

                  <a href="{{ route('avg', ['id' => $form, 'user_id' => $user->id ,'details_id' => $details->id] ) }}" class="btn btn-white rounded-0" id="print-btn">Print</a>


              </div>
          </div>
      </div>

  </form>
</div>

@endsection

