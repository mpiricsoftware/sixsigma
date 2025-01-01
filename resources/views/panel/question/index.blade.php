@extends('layouts.layoutMaster')

@section('title', 'Quiz')

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

<div class="card mb-4" id="question-card-{{ $section->id }}" style="display: {{ $index == 0 ? 'none' : 'none' }};">
  <div class="card-body" style="height:70%; margin:7%; padding:4%">
      <div id="questions-container-{{ $section->id }}" class="question">
          @foreach($section->questions as $qIndex => $q)
              <div class="question" id="question_{{ $section->id }}_{{ $qIndex }}" style="display: {{ $qIndex == 0 ? 'block' : 'none' }}">
                  <h6 class="font-weight-bold text-dark">{{ $q->question_text }}</h6>
                  <div>
                      <a href="#guidance_{{ $section->id }}_{{ $qIndex }}" data-bs-toggle="collapse" class="text-primary" style="cursor: pointer;">&#9650; Click to see guidance</a>
                      <div id="guidance_{{ $section->id }}_{{ $qIndex }}" class="collapse mt-2">
                          <p class="text-muted">{{ $q->question_description }}</p>
                      </div>
                  </div>

                  <!-- Render question input based on type -->
                  @switch($q->type)
                      @case('text')
                          <input type="text" name="question_{{ $qIndex }}" class="form-control" placeholder="Your answer here">
                          @break
                      @case('radio')
                          @foreach(json_decode($q->options) as $option)
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="question_{{ $qIndex }}" value="{{ $option }}">
                                  <label class="form-check-label">{{ $option }}</label>
                              </div>
                          @endforeach
                          @break
                      @case('checkbox')
                          @foreach(json_decode($q->options) as $option)
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="question_{{ $qIndex }}[]" value="{{ $option }}">
                                  <label class="form-check-label">{{ $option }}</label>
                              </div>
                          @endforeach
                          @break
                      @case('textarea')
                          <textarea name="question_{{ $qIndex }}" class="form-control" placeholder="Your answer here"></textarea>
                          @break
                      @default
                          <p class="text-danger">Unknown question type</p>
                  @endswitch
              </div>
          @endforeach
      </div>

      <!-- Navigation buttons -->
      <div class="text-end"  style="padding-top: 5%; padding-bottom:0%;">
          <button type="button" class="btn btn-secondary rounded-0" id="prev-btn{{ $section->id }}" onclick="showQuestion('{{ $section->id }}', 'prev')">Previous</button>
          <button type="button" class="btn btn-dark rounded-0" id="next-btn{{ $section->id }}" onclick="showQuestion('{{ $section->id }}', 'next')">Next</button>
      </div>
  </div>
</div>


@endsection

