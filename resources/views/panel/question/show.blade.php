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

@section('page-script')
    @vite(['resources/js/question.js'])
@endsection

@section('content')
<div class="container mt-5">


  <form class="add-new-vendor pt-9" method="POST" action="{{ route('answer-list.store') }}">
      @csrf
      @foreach ($sections as $index => $section)
          <div class="card mb-4" id="section-card-{{ $section->id }}" style="display: {{ $index == 0 ? 'block' : 'none' }};">
              <div class="card-body text-center" style="height:50%; margin:7%; padding:5%">
                  <h5 class="card-title" style="padding-top: 1%; color:#00a6d5;">{{ $section->section_name }}</h5>
                  <p class="card-text me-1">{{ $section->section_description }}</p>
                  <div class="card-body text-end" style="padding-top: 8%; padding-bottom:0%;">
                      <a href="javascript:void(0);" class="btn btn-dark rounded-0" onclick="startQuiz({{ $section->id }})">Start Quiz</a>
                  </div>
              </div>
          </div>

          <div class="card mb-4" id="question-card-{{ $section->id }}" style="display: {{ $index == 0 ? 'none' : 'none' }};">
              <div class="card-body" style="height:50%; margin:7%; padding:4%">
                  <h5 class="text-end" style="color:#00a6d5;" id="section-name-dynamic-{{ $section->id }}">{{ $section->section_name }}</h5>
                  <div id="questions-container-{{ $section->id }}" class="question">
                      @foreach($questions->where('section_id', $section->id) as $qIndex => $q)
                      <input type="hidden" name="question_ids[{{ $section->id }}][{{ $qIndex }}]" value="{{ $q->id }}">
                          <div class="question" id="question_{{ $section->id }}_{{ $qIndex }}" style="display: {{ $qIndex == 0 ? 'block' : 'none' }}">
                              <h6 class="font-weight-bold text-dark">{{ $q->question_text }}</h6>
                              <div>
                                  <a href="#guidance_{{ $section->id }}_{{ $qIndex }}" data-bs-toggle="collapse" class="text-primary" style="cursor: pointer;">&#9650; Click to see guidance</a>
                                  <div id="guidance_{{ $section->id }}_{{ $qIndex }}" class="collapse show mt-2">
                                      <p class="text-muted">{{ $q->question_description }}</p>
                                  </div>
                              </div>
                              @if($q->type == 'text')
                                  <input type="text" name="answers[{{ $section->id }}][{{ $qIndex }}]" class="form-control" placeholder="Enter your answer" value="{{ old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? '') }}">
                              @elseif($q->type == 'choice')
                                  <div>
                                      @foreach(json_decode($q->options) as $option)
                                          <label>
                                              <input type="radio" name="answers[{{ $section->id }}][{{ $qIndex }}]" value="{{ $option }}" {{ old('answers.' . $section->id . '.' . $qIndex) == $option || (isset($answers[$section->id][$qIndex]) && $answers[$section->id][$qIndex] == $option) ? 'checked' : '' }}>
                                              {{ $option }}
                                          </label><br>
                                      @endforeach
                                  </div>
                              @elseif($q->type == 'checkbox')
                                  <div>
                                      @foreach(json_decode($q->options) as $option)
                                          <label>
                                              <input type="checkbox" name="answers[{{ $section->id }}][{{ $qIndex }}][]" value="{{ $option }}" {{ in_array($option, old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? [])) ? 'checked' : '' }}>
                                              {{ $option }}
                                          </label><br>
                                      @endforeach
                                  </div>
                              @elseif($q->type == 'date')
                                  <input type="date" name="answers[{{ $section->id }}][{{ $qIndex }}]" class="form-control" value="{{ old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? '') }}">
                              @elseif($q->type == 'file')
                                  <input type="file" name="answers[{{ $section->id }}][{{ $qIndex }}]" class="form-control">
                              @elseif($q->type == 'rating')
                                  <div id="rating_{{ $q->id }}" class="rating" data-question-id="{{ $q->id }}">
                                      <input type="hidden" name="answers[{{ $section->id }}][{{ $qIndex }}]" id="selectedRating_{{ $q->id }}" value="{{ old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? 0) }}">
                                      <span class="star" data-index="1" onclick="setRating({{ $q->id }}, 1)" onmouseover="highlightStars({{ $q->id }}, 1)" onmouseout="resetStars({{ $q->id }}, 1)" style="font-size: 30px; cursor: pointer;">&#9733;</span>
                                      <span class="star" data-index="2" onclick="setRating({{ $q->id }}, 2)" onmouseover="highlightStars({{ $q->id }}, 2)" onmouseout="resetStars({{ $q->id }}, 2)" style="font-size: 30px; cursor: pointer;">&#9733;</span>
                                      <span class="star" data-index="3" onclick="setRating({{ $q->id }}, 3)" onmouseover="highlightStars({{ $q->id }}, 3)" onmouseout="resetStars({{ $q->id }}, 3)" style="font-size: 30px; cursor: pointer;">&#9733;</span>
                                      <span class="star" data-index="4" onclick="setRating({{ $q->id }}, 4)" onmouseover="highlightStars({{ $q->id }}, 4)" onmouseout="resetStars({{ $q->id }}, 4)" style="font-size: 30px; cursor: pointer;">&#9733;</span>
                                      <span class="star" data-index="5" onclick="setRating({{ $q->id }}, 5)" onmouseover="highlightStars({{ $q->id }}, 5)" onmouseout="resetStars({{ $q->id }}, 5)" style="font-size: 30px; cursor: pointer;">&#9733;</span>
                                  </div>
                              @elseif($q->type == 'textarea')
                                  <textarea name="answers[{{ $section->id }}][{{ $qIndex }}]" class="form-control" rows="4" placeholder="Enter your answer">{{ old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? '') }}</textarea>
                              @endif

                        </div>
                    @endforeach
                </div>
                <div class="text-end" style="padding-top:7%; padding-bottom:0%;">
                    <button type="button" class="btn btn-dark rounded-0" id="prev-btn{{ $section->id }}" onclick="showQuestion('{{ $section->id }}', 'prev')">Previous</button>
                    <button type="button" class="btn rounded-0" style="background-color: #00a6d5" id="next-btn{{ $section->id }}" onclick="showQuestion('{{ $section->id }}', 'next')">Next</button>
                    <button type="submit" class="btn btn-dark rounded-0" id="submit-btn{{ $section->id }}">Submit</button>
                </div>
            </div>
        </div>
    @endforeach
    <div id="completion-card" class="card mb-4" style="display: none; width: 100%; margin: 5%; padding: 5%;">
        <div class="card-body text-center">
            <h5 class="card-title" style="color: #00a6d5;">Congratulations!</h5>
            <p class="card-text">You have completed the quiz. Well done!</p>
            <button type="submit" class="btn btn-dark rounded-0" id="submit-btn{{ $section->id }}">Save your response</button>
        </div>
    </div>
    
    {{-- <div id="completion-card" class="card mb-4" style="display: none; width: 100%; margin: 5%; padding: 5%;">
        <div class="card-body text-center">
            <h5 class="card-title" style="color: #00a6d5;">Congratulations!</h5>
            <p class="card-text">You have completed the quiz. Well done!</p>
           <a href="{{ route('home')}}" class="btn btn-dark rounded-0">Restart Quiz</a>
        </div>
    </div> --}}



</form>


</div>

@endsection
