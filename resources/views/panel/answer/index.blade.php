@extends('layouts.layoutMaster')

@section('title', 'Answers')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
<div class="card">
  <div class="card-header">
    <h5>Answers</h5>
  </div>

  <div class="card-body" style="padding-top:2%; margin:2%">
      <div class="row">
          <!-- Section Dropdown -->
          <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                  <select name="section" id="section" class="form-select">
                      <option value="">Select a Section</option>
                      @foreach ($section as $s)
                          <option value="{{ $s->id }}">{{ $s->section_name }}</option>
                      @endforeach
                  </select>
                  <label for="section">Select Section</label>
              </div>
          </div>

          <!-- Question Dropdown -->
          <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                  <select name="question" id="question" class="form-select">
                      <option value="">Select Questions</option>
                  </select>
              </div>
          </div>
      </div>
<br>
      <!-- Question Input Area -->
      <div id="question-input-area"></div>
      <br>
      <div class="col-12 text-end" style="padding-bottm: 1%">
        <button type="submit" class="btn btn-secondary rounded-0 non-shadow">Submit</button>
      </div>
  </div>



</div>

<script>
    document.getElementById('section').addEventListener('change', function() {
        var sectionId = this.value;

        // Clear the question dropdown and input area
        var questionSelect = document.getElementById('question');
        var inputArea = document.getElementById('question-input-area');
        questionSelect.innerHTML = '<option value="">Select Questions</option>';
        inputArea.innerHTML = ''; // Clear previous input fields

        if (sectionId) {
            // Make an AJAX request to fetch questions for the selected section
            fetch('/get-questions/' + sectionId)
                .then(response => response.json())
                .then(data => {
                    // Populate the questions dropdown
                    data.questions.forEach(function(question) {
                        var option = document.createElement('option');
                        option.value = question.id;
                        option.textContent = question.question_text;
                        questionSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // Handle question selection
    document.getElementById('question').addEventListener('change', function() {
        var questionId = this.value;
        var inputArea = document.getElementById('question-input-area');
        inputArea.innerHTML = ''; // Clear the input area

        if (questionId) {
            // Find the selected question's details from the previously fetched questions
            fetch(`/get-questions/${document.getElementById('section').value}`)
                .then(response => response.json())
                .then(data => {
                    var question = data.questions.find(q => q.id == questionId);
                    if (question) {
                        // Generate the appropriate input field based on the question type
                        var inputElement;
                        if (question.type == 'text') {
                            inputElement = `<textarea name="answer" class="form-control" placeholder="Your answer"></textarea>`;
                        } else if (question.type == 'rating') {
                            inputElement = `<input type="number" name="rating" class="form-control" min="1" max="5" placeholder="Rate from 1 to 5">`;
                        } else if (question.type == 'multiple-choice' && question.options) {
                            inputElement = '';
                            JSON.parse(question.options).forEach(function(option) {
                                inputElement += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answer" value="${option}">
                                        <label class="form-check-label">${option}</label>
                                    </div>
                                `;
                            });
                        }

                        inputArea.innerHTML = inputElement;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>

@endsection
