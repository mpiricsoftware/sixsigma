@extends('layouts.layoutMaster')

@section('title', 'OMM-Quiz')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
    @vite(['resources/js/question.js'])
@endsection

@section('content')
    {{-- <div class="container"> --}}
        <form class="add-new-vendor" method="POST" action="{{ route('answer-list.store') }}" id="id" name="id">
            @csrf
            <input type="hidden" name="submission_id" value="{{ $submissionId }}">
            @foreach ($sections as $index => $section)
                <div class="card mb-4" id="section-card-{{ $section->id }}"
                    style="display: {{ $index == 0 ? 'block' : 'none' }};">
                    <div class="card-body text-center" style="height:50%;">
                        <h5 class="card-title" style="padding-top: 1%; color:#00a6d5;">{{ $section->section_name }}</h5>
                        <p class="card-text me-1">{{ $section->section_description }}</p>
                        <div class="card-body text-end" style="padding-top: 8%; padding-bottom:0%;">
                            <a href="javascript:void(0);" class="btn btn-dark rounded"
                                onclick="startQuiz({{ $section->id }})">Assessment</a>
                        </div>
                    </div>
                </div>

                <div class="card mb-4" id="question-card-{{ $section->id }}"
                    style="display: {{ $index == 0 ? 'none' : 'none' }};">

                    <div class="card-body" style="height:50%;">

                        <!-- Pillar Name here -->
                        <h5 class="text-end" style="color:#00a6d5;" id="section-name-dynamic-{{ $section->id }}">
                            <span style="color: #69706e;">{{ $section->pillar->name }}</span> /
                            {{ $section->section_name }}
                        </h5>

                        <div id="questions-container-{{ $section->id }}" class="question">
                            @foreach ($questions->where('section_id', $section->id) as $qIndex => $q)
                                <input type="hidden" name="question_ids[{{ $section->id }}][{{ $qIndex }}]"
                                    value="{{ $q->id }}">
                                    <div class="question"
                                    id="question_{{ $section->id }}_{{ $qIndex }}"
                                    data-section-id="{{ $section->id }}"
                                    data-question-id="{{ $q->id }}"
                                    style="display: {{ $qIndex == 0 ? 'block' : 'none' }};">

                                    <h6 class="font-weight-bold text-dark">{{ $q->question_text }}</h6>

                                    <div>
                                        <a href="#guidance_{{ $section->id }}_{{ $qIndex }}"
                                            data-bs-toggle="collapse" class="text-primary" style="cursor: pointer;">&#9650;
                                            Click to see guidance</a>
                                        <div id="guidance_{{ $section->id }}_{{ $qIndex }}"
                                            class="collapse show mt-2">
                                            <p class="text-muted">{{ $q->question_description }}</p>
                                        </div>
                                    </div>
                                    @if ($q->type == 'text')
                                        <input type="text" name="answers[{{ $section->id }}][{{ $qIndex }}]"
                                            class="form-control" placeholder="Enter your answer"
                                            value="{{ old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? '') }}">
                                    @elseif ($q->type == 'radio')
                                        @php
                                            $predefinedLabels = [
                                                'Nascent',
                                                'Stable',
                                                'Maturing',
                                                'Efficient',
                                                'World Class',
                                            ];
                                            $backgroundColors = ['55cae5', 'fabee0', '9df7c0', 'f0c87a', 'd8cfee'];
                                            $options = json_decode($q->options, true) ?? [];
                                        @endphp

                                        <!-- Today Section -->
                                        <div class="today-section">
                                          <label class="font-weight-bold" style="padding-right:1%"><strong>Today</strong></label>
                                          <label class="font-weight-bold text-end" style="position: absolute;right: 30px;">
                                            <strong>Next Three Year</strong>
                                        </label>
                                          <div class="options-container mt-2">
                                              @foreach ($predefinedLabels as $index => $label)
                                                  <div class="d-flex align-items-center mb-3 rounded shadow-sm"
                                                      style="border: 1px solid #ced4da; padding: 10px;">

                                                      <div class="p-3 flex-grow-1 d-flex align-items-center"
                                                            style="min-height: 30px;
                                                                     background-color: #f8f9fa;
                                                                     border-radius: 0 5px 5px 0;">
                                                          @if (isset($options[$index]))
                                                              <label class="d-flex align-items-center w-100 ">
                                                                  <div class="radio-box"
                                                                      style="border: 2px solid #3498db;
                                                                             padding: 10px;
                                                                             background-color: #f8f9fa;
                                                                             border-radius: 10px;
                                                                             width: 40px;
                                                                             height: 40px;
                                                                             display: flex;
                                                                             justify-content: center;
                                                                             align-items: center;
                                                                             margin-right: 10px;">
                                                                      <input type="radio"
                                                                          name="answers[{{ $section->id }}][{{ $qIndex }}]"
                                                                          value="{{ $options[$index] }}" data-question-id="{{ $q->id }}"
                                                                          {{ old('answers.' . $section->id . '.' . $qIndex) == $options[$index] ? 'checked' : '' }} style="transform: scale(1.3);" >
                                                                  </div>
                                                                  <div class="p-3 rounded text-left"
                                                                      style="background-color: #{{ $backgroundColors[$index] }};
                                                                             color: #525252;
                                                                             font-weight: bold;
                                                                             min-width: 150px;
                                                                             text-align: center;">
                                                                      {{ $label }}
                                                                  </div>
                                                                  <span style="word-wrap: break-word; padding-left: 10px;">{{ $options[$index] }}</span>
                                                              </label>
                                                              <label class="d-flex w-10">
                                                                  <div class="radio-box"
                                                                      style="border: 2px solid #3498db;
                                                                             padding: 10px;
                                                                             background-color: #f8f9fa;
                                                                             border-radius: 10px;
                                                                             width: 40px;
                                                                             height: 40px;
                                                                             display: flex;
                                                                             justify-content: center;
                                                                             align-items: center;">
                                                                      <input type="radio"
                                                                          name="answers_future[{{ $section->id }}][{{ $qIndex }}]"
                                                                          value="{{ $options[$index] }}"
                                                                          {{ old('answers_future.' . $section->id . '.' . $qIndex) == $options[$index] ? 'checked' : '' }} style="transform: scale(1.3);">
                                                                  </div>
                                                              </label>
                                                          @else
                                                              <span class="text-muted">N/A</span>
                                                          @endif
                                                      </div>
                                                  </div>
                                              @endforeach
                                          </div>
                                      </div>


                                    @elseif ($q->type == 'checkbox')
                                        <div>
                                            @foreach (json_decode($q->options) as $option)
                                                <label>
                                                    <input type="checkbox"
                                                        name="answers[{{ $section->id }}][{{ $qIndex }}][]"
                                                        value="{{ $option }}"
                                                        {{ in_array($option, old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? [])) ? 'checked' : '' }}>
                                                    {{ $option }}
                                                </label><br>
                                            @endforeach
                                        </div>
                                    @elseif ($q->type == 'date')
                                        <input type="date" name="answers[{{ $section->id }}][{{ $qIndex }}]"
                                            class="form-control"
                                            value="{{ old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? '') }}">
                                    @elseif ($q->type == 'file')
                                        <input type="file" name="answers[{{ $section->id }}][{{ $qIndex }}]"
                                            class="form-control">
                                    @elseif ($q->type == 'textarea')
                                        <textarea name="answers[{{ $section->id }}][{{ $qIndex }}]" class="form-control" rows="4"
                                            placeholder="Enter your answer">{{ old('answers.' . $section->id . '.' . $qIndex, $answers[$section->id][$qIndex] ?? '') }}</textarea>
                                    @endif
                                </div>
                            @endforeach
                        </div>


                    <div id="progress-container-{{ $form->id }}"
                        style="width: 100%; background-color: #e0e0e0; border-radius: 5px; height: 20px; margin-bottom: 10px;
                               box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">

                        <div id="progress-bar-{{ $form->id }}"
                            style="height: 100%; width:0; background-color: #71858b; border-radius: 5px;
                                   transition: width 0.4s ease-in-out; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>
                    <p id="question-progress-{{ $form->id }}"> {{ $questions->count() }}</p>




                        <div class="text-end" style="">
                            <button type="button" class="btn btn-dark rounded" id="prev-btn{{ $section->id }}"
                                onclick="showQuestion('{{ $section->id }}', 'prev')">Back</button>
                            <button type="button" class="btn rounded" style="background-color: #00a6d5;color: white;"
                                id="next-btn{{ $section->id }}"
                                onclick="showQuestion('{{ $section->id }}', 'next')">Next</button>
                            {{-- <button type="submit" class="btn btn-dark rounded-0" id="submit-btn{{ $section->id }}">Submit</button> --}}
                        </div>
                    </div>
                </div>
            @endforeach

            <div id="completion-card" class="card mb-4" style="display:none;width: 100%;">
                <div class="card-body text-center">
                    <h5 class="card-title" style="color: #00a6d5;">Congratulations!</h5>
                    <p class="card-text">You have completed the quiz. Well done!</p>
                    <button type="button" class="btn btn-white rounded-0"
                    id="prev-btn{{ $section->id }}"
                    onclick="showQuestion('{{ $section->id }}')">Back</button>


                    <button type="submit" class="btn btn-dark rounded" id="submit-btn{{ $section->id }}" >Save your
                        response</button>
                </div>
                <div style="width:100%;">
                  <table class="table"
                      style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); width: 100%; border-spacing: 0px; border-collapse: collapse;">
                      <tbody>
                          @foreach ($pillars as $pillar)
                              @php
                                  $pillarQuestions = $questions->whereIn('section_id', $sections->where('pillar_id', $pillar->id)->pluck('id'));
                                  $questionCount = $pillarQuestions->count();
                              @endphp

                              <!-- Pillar Name Row -->
                              <tr>
                                  <td rowspan="1" class="text-center"
                                      style="color: rgb(77, 73, 73); font-size: 18px; padding: 8px; width: 10%; border: none;">
                                      <strong>{{ $pillar->name }}</strong>
                                  </td>

                                  <!-- Questions in Remaining Columns -->
                                  @foreach ($pillarQuestions as $question)
                                      <td id="question-{{ $question->id }}" class="text-center question-cell"
                                          style="background-color: rgb(255, 107, 107); color: white; font-weight: bold; padding: 8px; transition: background-color 0.3s ease-in-out;">
                                          {{ $question->question_text }}
                                      </td>
                                  @endforeach
                              </tr>

                              <!-- Optional Spacer Row: Reduce height or remove -->
                              <tr style="height: 5px; border: none;">
                                  <td colspan="{{ $questionCount + 1 }}" style="background-color: #ffffff; border: none;"></td>
                              </tr>

                          @endforeach
                      </tbody>
                  </table>
              </div>
        </form>



    {{-- </div> --}}
@endsection



