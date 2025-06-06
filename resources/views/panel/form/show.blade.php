@extends('layouts/layoutMaster')

@section('title', 'OMM-Form')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body:not(.modal-open) .select2-container--open {
        z-index: 99;
    }
</style>

<!-- batchOrder Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
@section('page-script')
    @vite(['resources/js/form.js'])
@endsection
@section('content')

    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            {{-- {{dd($sections)}} --}}
            <form class="add-new-vendor pt-9" method="POST"
                @if ($sections->isEmpty()) action="{{ route('section-list.store') }}" @else action="{{ route('section-list.updateNew') }}" @endif>
                @csrf
                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- Text Question -->
                    <div class="row g-6 ms-3 me-3">
                        <div class="col-md-12">
                            @foreach ($form as $form)
                                <input type="hidden" name="id" id="id" value="{{ $form->id }}">
                                <div class="card shadow-sm rounded">
                                    <div class="card-body">
                                        @if ($form)
                                            <h5 class="card-title font-weight-bold">{{ $form->name }}</h5>
                                            <p class="card-text">{{ $form->description }}</p>
                                        @else
                                            <p class="text-warning">No form data available.</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>


                                  @foreach ($sections as $s)
                            <div class="row g-6 ms-3 me-3 mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                          <div class="col-md-12">
                                            <div class="form-floating form-floting-outline">
                                              <select name="pillar_id[]" id="pillar_id" class="select2 form-select name" data-placeholder="Select name" data-allow-clear="true">
                                                <option value="Select Pillar">Select Pillar</option>
                                                @foreach ($pillar as $p)
                                                <option value="{{ $p->id }}" {{ $s->pillar_id == $p->id ? 'selected' : '' }}>
                                                  {{ $p->name }}</option>
                                                @endforeach

                                              </select>

                                            </div>
                                          </div>
                                          <br>
                                            <div class="col-md-12">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="hidden" name="section_id[]" value="{{ $s->id }}">
                                                    <input type="text" name="section_name[]"
                                                        id="section_name_{{ $s->id }}"
                                                        placeholder="Enter Section Name" class="form-control"
                                                        value="{{ old('section_name.' . $loop->index, $s->section_name) }}">
                                                    <label for="section_name_{{ $s->id }}">Section Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="form-floating form-floating-outline">
                                                    <textarea name="section_description[]" id="section_description_{{ $s->id }}" class="form-control"
                                                        placeholder="Enter Section Description" style="height: 2%">{{ old('section_description.' . $loop->index, $s->section_description) }}</textarea>
                                                    <label for="section_description_{{ $s->id }}">Section
                                                        Description</label>
                                                </div>
                                            </div>
                                        </div>

                                        
@foreach ($s->question as $q)
<div class="card-body">
    <input type="hidden"
        name="question_id[{{ $s->id }}][{{ $q->id }}]"
        value="{{ $q->id }}">
    <input type="hidden"
        name="type[{{ $s->id }}][{{ $q->id }}]"
        value="{{ old('type.' . $s->id . '.' . $q->id, $q->type) }}">
    <input type="hidden"
        name="options[{{ $s->id }}][{{ $q->id }}]"
        value="{{ old('type.' . $s->id . '.' . $q->id, $q->type) }}">

    @if ($q->type === 'text')
        <input type="text" class="form-control mt-2"
            name="question_text[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_text.' . $s->id . '.' . $q->id, $q->question_text) }}">
        <input type="text" class="form-control mt-2"
            name="question_description[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_description.' . $s->id . '.' . $q->id, $q->question_description) }}">
    @elseif($q->type === 'date')
        <input type="text" class="form-control mt-2"
            name="question_text[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_text.' . $s->id . '.' . $q->id, $q->question_text) }}">
        <input type="text" class="form-control mt-2"
            name="question_description[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_description.' . $s->id . '.' . $q->id, $q->question_description) }}">
    @elseif($q->type === 'file')
        <input type="text" class="form-control mt-2"
            name="question_text[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_text.' . $s->id . '.' . $q->id, $q->question_text) }}">
        <input type="text" class="form-control mt-2"
            name="question_description[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_description.' . $s->id . '.' . $q->id, $q->question_description) }}">
    @elseif($q->type == 'rating')
        <input type="text" class="form-control mt-2"
            name="question_text[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_text.' . $s->id . '.' . $q->id, $q->question_text) }}">
        <input type="text" class="form-control mt-2"
            name="question_description[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_description.' . $s->id . '.' . $q->id, $q->question_description) }}">
        <div id="rating_{{ $q->id }}" class="rating"
            data-question-id="{{ $q->id }}">
            <input type="hidden"
                name="answers[{{ $s->id }}][{{ $q->id }}]"
                id="selectedRating_{{ $q->id }}">
            <span class="star" data-index="1"
                onclick="setRating({{ $q->id }}, 1)"
                onmouseover="highlightStars({{ $q->id }}, 1)"
                onmouseout="resetStars({{ $q->id }}, 1)"
                style="font-size: 30px; cursor: pointer;">&#9733;</span>
            <span class="star" data-index="2"
                onclick="setRating({{ $q->id }}, 2)"
                onmouseover="highlightStars({{ $q->id }}, 2)"
                onmouseout="resetStars({{ $q->id }}, 2)"
                style="font-size: 30px; cursor: pointer;">&#9733;</span>
            <span class="star" data-index="3"
                onclick="setRating({{ $q->id }}, 3)"
                onmouseover="highlightStars({{ $q->id }}, 3)"
                onmouseout="resetStars({{ $q->id }}, 3)"
                style="font-size: 30px; cursor: pointer;">&#9733;</span>
            <span class="star" data-index="4"
                onclick="setRating({{ $q->id }}, 4)"
                onmouseover="highlightStars({{ $q->id }}, 4)"
                onmouseout="resetStars({{ $q->id }}, 4)"
                style="font-size: 30px; cursor: pointer;">&#9733;</span>
            <span class="star" data-index="5"
                onclick="setRating({{ $q->id }}, 5)"
                onmouseover="highlightStars({{ $q->id }}, 5)"
                onmouseout="resetStars({{ $q->id }}, 5)"
                style="font-size: 30px; cursor: pointer;">&#9733;</span>
        </div>
    @elseif($q->type === 'radio')
        <input type="text" class="form-control mt-2"
            name="question_text[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_text.' . $s->id . '.' . $q->id, $q->question_text) }}">
        <input type="text" class="form-control mt-2"
            name="question_description[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_description.' . $s->id . '.' . $q->id, $q->question_description) }}"><br>

        <div class="option-container">
            @foreach ($q->options as $index => $option)
                <div class="form-check d-flex align-items-center mb-2">
                    <input type="radio" name="choice[{{ $q->id }}]"
                        value="{{ $option }}"
                        data-option-index="{{ $index }}"
                        {{ isset($q->choice) && $option == $q->choice ? 'checked' : '' }}
                        class="form-check-input">
                    <input type="text" class="form-control mx-2" style="width: 80%;"
                        name="option_text[{{ $s->id }}][{{ $q->id }}][{{ $index }}]"
                        value="{{ $option }}">
                    {{-- <button type="button" class="btn btn-danger btn-sm remove-option">
                        <i class="fas fa-times"></i> Remove
                    </button> --}}
                </div>
            @endforeach
        </div>
        {{-- <button type="button" class="btn btn-primary btn-sm add-option mt-2" 
            data-section-id="{{ $s->id }}" 
            data-question-id="{{ $q->id }}" 
            data-type="radio">
            <i class="fas fa-plus"></i> Add Option
        </button> --}}
        
    @elseif($q->type === 'checkbox')
        <input type="text" class="form-control mt-2"
            name="question_text[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_text.' . $s->id . '.' . $q->id, $q->question_text) }}">
        <input type="text" class="form-control mt-2"
            name="question_description[{{ $s->id }}][{{ $q->id }}]"
            value="{{ old('question_description.' . $s->id . '.' . $q->id, $q->question_description) }}">

        <div class="option-container">
            @foreach ($q->options as $index => $option)
                <div class="form-check d-flex align-items-center mb-2">
                    <input type="checkbox"
                        name="selected_option[{{ $q->id }}][]"
                        value="{{ $option }}"
                        {{ isset($q->selected_options) && in_array($option, $q->selected_options) ? 'checked' : '' }}
                        class="form-check-input">
                    <input type="text" class="form-control mx-2" style="width: 80%;"
                        name="option_text[{{ $s->id }}][{{ $q->id }}][{{ $index }}]"
                        value="{{ $option }}">
                    {{-- <button type="button" class="btn btn-danger btn-sm remove-option">
                        <i class="fas fa-times"></i> Remove
                    </button> --}}
                </div>
            @endforeach
        </div>
        {{-- <button type="button" class="btn btn-primary btn-sm add-option mt-2" 
            data-section-id="{{ $s->id }}" 
            data-question-id="{{ $q->id }}" 
            data-type="checkbox">
            <i class="fas fa-plus"></i> Add Option
        </button> --}}
    @endif
</div>
@endforeach

                                        <div class="card-body">
                                            <button type="button" class="btn btn-dark rounded-0"
                                                id="addSection_{{ $s->id }}" style="background-color:#00a6d5">+
                                                Add
                                                Option</button>
                                            <div id="dynamicFields_{{ $s->id }}">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($sections->isEmpty())
                            <div class="row g-6 ms-3 me-3 mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                          <div class="col-md-12">
                                            <div class="form-floating form-floting-outline">
                                              <select name="pillar_id" id="pillar_id" class="select2 form-select name" data-placeholder="Select name" data-allow-clear="true">
                                                <option value="Select Pillar">Select Pillar</option>
                                                @foreach ($pillar as $p)
                                                  <option value="{{$p->id}}">{{$p->name}}</option>
                                                @endforeach

                                              </select>

                                            </div>
                                          </div>
                                          <br>
                                            <div class="col-md-12">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="section_name[]" id="section_name"
                                                        placeholder="Enter Section Name" class="form-control">
                                                    <label for="section_name">Section Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="form-floating form-floating-outline">
                                                    <textarea name="section_description[]" id="section_description" class="form-control"
                                                        placeholder="Enter Section Description"></textarea>
                                                    <label for="section_description">Section Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <button type="button" class="btn btn-dark rounded-0" id="addSection"
                                                style="background-color: 00a6d5">+ Add Option</button>
                                            <div id="dynamicFields">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <br>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-dark rounded-0">Submit</button>
                        </div>

                    </div>
            </form>
        </div>
    </div>

@endsection
<script>
    $(document).ready(function() {
        let fieldCount = 0;
        let isUpdate = false;
        $('[id^="addSection"]').on('click', function() {
            let sectionId = $(this).attr('id');
            let dynamicSectionId = '';
            if (sectionId.includes('_')) {
                dynamicSectionId = sectionId.split('_')[1];
                isUpdate = true;
            }

            if (!isUpdate) {
                // alert('hello');
                fieldCount++;
                const newSection = `
            <div class="section-box form-control mt-3" id="section_${fieldCount}">
                <!-- Dynamic fields container -->

                <div class="row mt-3">
                    <!-- Column 1: Choice -->
                    <div class="col-md-4">
                      <div class="form-floating form-floating-outline">
                        <input type="button" id="choice_${fieldCount}" value="Choice" class="form-control" onclick="addChoiceField(${fieldCount})">
                      </div>
                    </div>
                    <!-- Column 2: Text -->
                    <div class="col-md-4">
                      <div class="form-floating form-floating-outline">
                        <input type="button" id="text_${fieldCount}" class="form-control" value="Text" onclick="addTextField(${fieldCount})">
                      </div>
                    </div>
                    <!-- Column 3: Rating -->
                    <div class="col-md-4">
                      <div class="form-floating form-floating-outline">
                        <input type="button" id="rating_${fieldCount}" class="form-control" value="Rating" onclick="addRatingField(${fieldCount})">
                      </div>
                    </div>
                </div>

                <div class="row mt-3">
                  <!-- Column 4: Date -->
                  <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="date_${fieldCount}" class="form-control" value="Date" onclick="addDateField(${fieldCount})">
                    </div>
                  </div>

                  <!-- Column 5: File Upload -->
                  <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="file_${fieldCount}" class="form-control" value="Upload File" onclick="addFileField(${fieldCount})">
                    </div>
                  </div>

                  <!-- Column 6: Section -->
                  <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="section_${fieldCount}" class="form-control" value="Section" onclick="addsection(${fieldCount})">
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12 text-end">
                      <button type="button" class="btn btn-dark rounded-0" onclick="removeSection(${fieldCount})" style="background-color:#00a6d5">Remove</button>
                    </div>
                  </div>
                </div>
                <div id="dynamicFields_${fieldCount}"></div>
            </div>`;

                // For new section, append based on dynamicSectionId or default container
                if (dynamicSectionId) {
                    $('#dynamicFields_' + dynamicSectionId).append(newSection);
                } else {
                    $('#dynamicFields').append(newSection);
                }
            } else {
                // alert('hi');
                const newSection = `
            <div class="section-box form-control mt-3" id="section_${dynamicSectionId}">
                <!-- Dynamic fields container -->


                <div class="row mt-3">
                    <!-- Column 1: Choice -->
                    <div class="col-md-4">
                      <div class="form-floating form-floating-outline">
                        <input type="button" id="choice_${dynamicSectionId}" value="Choice" class="form-control" onclick="addChoiceField(${dynamicSectionId})">
                      </div>
                    </div>

                    <!-- Column 2: Text -->
                    <div class="col-md-4">
                      <div class="form-floating form-floating-outline">
                        <input type="button" id="text_${dynamicSectionId}" class="form-control" value="Text" onclick="addTextField(${dynamicSectionId})">
                      </div>
                    </div>

                    <!-- Column 3: Rating -->
                    <div class="col-md-4">
                      <div class="form-floating form-floating-outline">
                        <input type="button" id="rating_${dynamicSectionId}" class="form-control" value="Rating" onclick="addRatingField(${dynamicSectionId})">
                      </div>
                    </div>
                </div>

                <div class="row mt-3">
                  <!-- Column 4: Date -->
                  <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="date_${dynamicSectionId}" class="form-control" value="Date" onclick="addDateField(${dynamicSectionId})">
                    </div>
                  </div>

                  <!-- Column 5: File Upload -->
                  <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="file_${dynamicSectionId}" class="form-control" value="Upload File" onclick="addFileField(${dynamicSectionId})">
                    </div>
                  </div>

                  <!-- Column 6: Section -->
                  <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                      <input type="button" id="section_${dynamicSectionId}" class="form-control" value="Section" onclick="addsection(${dynamicSectionId})">
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12 text-end">
                      <button type="button" class="btn btn-dark rounded-0" onclick="removeSection(${dynamicSectionId})" style="background-color:#00a6d5">Remove</button>
                    </div>
                  </div>
                </div>
                <div id="dynamicFields_${dynamicSectionId}"></div>
            </div>`;

                // Append the new section into the existing section's container
                $('#dynamicFields_' + dynamicSectionId).append(newSection);
            }
        });
    });

    const globalOptionIndex = {};
    let questionCounter = {};

    function addChoiceField(sectionId) {
        const container = $(`#dynamicFields_${sectionId}`);

        const questionId = `question_${sectionId}_${new Date().getTime()}`; // Unique question ID

const choiceField = `
<div class="row mt-5 choice-field" id="${questionId}">
    <div class="col-md-12">
        <input type="text" class="form-control" placeholder="Enter your question" name="question_text[${sectionId}][${questionId}]">
    </div>
    <div class="col-md-12 mt-2">
        <input type="text" class="form-control" placeholder="Enter your Description" name="question_description[${sectionId}][${questionId}]">
    </div>
    <div class="col-md-12 mt-2">
        <div class="btn-group" role="group" aria-label="Choice Type">
            <button type="button" class="btn btn-whiterounded-0" onclick="showChoiceOptions(${sectionId}, 'radio', this, '${questionId}')">Radio Button</button>
            <button type="button" class="btn btn-dark rounded-0" onclick="showChoiceOptions(${sectionId}, 'checkbox', this, '${questionId}')">Checkbox</button>
        </div>
        <div class="choice-options mt-4"></div>
        <button type="button" class="btn btn-dark rounded-0 mt-2" onclick="addChoiceOption(${sectionId}, '${questionId}')" style="background-color:#00a6d5">+</button>
        <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill me-1" onclick="removeField(this)">
            <i class="ri-delete-bin-7-line ri-20px"></i>
        </button>
    </div>
    <input type="hidden" name="type[${sectionId}][${questionId}]" class="choice-type-hidden" value="">
</div>
`;
container.append(choiceField);

if (!globalOptionIndex[sectionId]) {
    globalOptionIndex[sectionId] = 0;
}

const existingOptionsCount = $(`#dynamicFields_${sectionId} .choice-option`).length;
globalOptionIndex[sectionId] = existingOptionsCount;

}

    function showChoiceOptions(sectionId, type, button, questionId) {
        const choiceContainer = $(`#${questionId} .choice-options`);
        choiceContainer.empty();

        $(button).siblings().removeClass('btn-primary').addClass('btn-outline-primary');
        $(button).removeClass('btn-outline-primary').addClass('btn-primary');

        const typeField = $(`#${questionId} .choice-type-hidden`);
        typeField.val(type);

        addChoiceOption(sectionId, questionId);
    }
    function addChoiceOption(sectionId, questionId) {
      const container = $(`#${questionId} .choice-options`);
        const choiceType = $(`#${questionId} .choice-type-hidden`).val();

        if (!choiceType) {
            alert("Please select Radio or Checkbox type first.");
            return;
        }

        // Get the highest existing option index
        const newIndex = globalOptionIndex[sectionId]++;

        const choiceOption = `
    <div class="d-flex align-items-center mt-2 choice-option">
        <input type="${choiceType}" name="choice_${sectionId}_${questionId}${choiceType === 'checkbox' ? '[]' : ''}" class="me-2" onclick="updateSelectedValue(${sectionId}, this)">
        <input type="text" class="form-control me-2" placeholder="Option ${newIndex + 1}" onchange="updateOptionValue(${sectionId}, ${newIndex}, this)">
        <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill me-1" onclick="removeOption(this)">
            <i class="ri-delete-bin-7-line ri-20px"></i>
        </button>
    </div>
    `;

        container.append(choiceOption);

        const hiddenOptionsField = `
    <input type="hidden" name="options[choice_${sectionId}_${questionId}][]" class="option-value" data-option-index="${newIndex}" value="">
    `;

        container.append(hiddenOptionsField);
    }



    function updateOptionValue(sectionId, index, element) {
        const optionValue = element.value;
        const hiddenOptionField = $(`#dynamicFields_${sectionId} input.option-value[data-option-index="${index}"]`);
        hiddenOptionField.val(optionValue);
    }


    function updateSelectedValue(sectionId, element) {
        const selectedValue = $(element).siblings("input[type='text']").val();
        $(`#selectedValue_${sectionId}`).val(selectedValue);
    }

    function removeOption(element) {
        $(element).closest('.choice-option').remove();
    }

    function addRatingField(sectionId) {
        const container = $(`#dynamicFields_${sectionId}`);
        const ratingField = `
        <div class="row mt-5">
            <div class="col-md-12">
                <input type="text" class="form-control me-2" placeholder="Enter your question" name="question_text[${sectionId}][]">
            </div>
            <div class="col-md-7 mt-2">
                <input type="text" class="form-control" placeholder="Enter your Description" name="question_description[${sectionId}][]">
            </div>
            <div class="col-md-4 mt-2">
                <div class="rating" id="rating_${sectionId}">
                    <span class="star" name="rating_${sectionId}" data-index="1" onclick="setRating(${sectionId}, 1)">&#9733;</span>
                    <span class="star" name="rating_${sectionId}" data-index="2" onclick="setRating(${sectionId}, 2)">&#9733;</span>
                    <span class="star" name="rating_${sectionId}" data-index="3" onclick="setRating(${sectionId}, 3)">&#9733;</span>
                    <span class="star" name="rating_${sectionId}" data-index="4" onclick="setRating(${sectionId}, 4)">&#9733;</span>
                    <span class="star" name="rating_${sectionId}" data-index="5" onclick="setRating(${sectionId}, 5)">&#9733;</span>
                </div>
            </div>
            <div class="col-md-1 mt-2">
                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill me-1" onclick="removeField(this)">
                    <i class="ri-delete-bin-7-line ri-20px"></i>
                </button>
            </div>
        </div>
    `;

        container.append(ratingField);
        const hiddenTypeField = `<input type="hidden" name="type[${sectionId}][]" value="rating">`;
        container.append(hiddenTypeField);
        const hiddenRatingField =
            `<input type="hidden" name="options[rating_${sectionId}][]" id="selectedRating_${sectionId}" value="0">`;
        container.append(hiddenRatingField);
        const stars = $(`#rating_${sectionId} .star`);
        stars.each(function() {
            $(this).css("font-size", "40px");
            $(this).css("color", "#ccc");
            $(this).css("cursor", "pointer");
        });
        stars.hover(
            function() {
                const index = $(this).data("index");
                stars.each(function(i) {
                    $(this).css("color", i < index ? "gold" : "#ccc");
                });
            },
            function() {
                const rating = $(`#selectedRating_${sectionId}`).val();
                stars.each(function(i) {
                    $(this).css("color", i < rating ? "gold" : "#ccc");
                });
            }
        );
        const initialRating = $(`#selectedRating_${sectionId}`).val();
        stars.each(function(i) {
            $(this).css("color", i < initialRating ? "gold" : "#ccc");
        });
    }

    function setRating(sectionId, rating) {
        const stars = $(`#rating_${sectionId} .star`);
        const currentRating = parseInt($(`#selectedRating_${sectionId}`).val());
        if (currentRating === rating) {
            stars.each(function(i) {
                $(this).css("color", "#ccc");
            });
            $(`#selectedRating_${sectionId}`).val(0);
        } else {
            stars.each(function(i) {
                $(this).css("color", i < rating ? "gold" : "#ccc");
            });
            $(`#selectedRating_${sectionId}`).val(rating);
        }
    }

    function addDateField(sectionId) {
        const container = $(`#dynamicFields_${sectionId}`);
        const dateField = `
        <div class="row mt-5">
            <div class="col-md-12">
                <input type="text" class="form-control me-2" placeholder="Enter your question" name="question_text[${sectionId}][]">
            </div>
              <div class="col-md-7 mt-2">
              <input type="text" class="form-control" placeholder="Enter your Description" name="question_description[${sectionId}][]">
              </div>
            <div class="col-md-4 mt-2">
                <input type="date" class="form-control" name="date_${sectionId}">
                </div>
                <div class="col-md-1 mt-2">
                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill me-1" onclick="removeField(this)"><i class="ri-delete-bin-7-line ri-20px"></i></button>
            </div>
        </div>
    `;
        container.append(dateField);
        const hiddenTypeField = `<input type="hidden" name="type[${sectionId}][]" value="date">`;
        container.append(hiddenTypeField);
    }

    function addFileField(sectionId) {
        const container = $(`#dynamicFields_${sectionId}`);
        const fileField = `
        <div class="row mt-5">
            <div class="col-md-12">
                <input type="text" class="form-control me-2" placeholder="Enter your question" name="question_text[${sectionId}][]">
            </div>
            </div>
            <div class="row">
              <div class="col-md-7 mt-2">
              <input type="text" class="form-control" placeholder="Enter your Description" name="question_description[${sectionId}][]">
              </div>
            <div class="col-md-4 mt-2">
                <input type="file" class="form-control" name="file_${sectionId}">
                </div>
            <div class="col-md-1 mt-2">
                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill me-1" onclick="removeField(this)"><i class="ri-delete-bin-7-line ri-20px"></i></button>
            </div>
            </div>
        </div>
    `;
        container.append(fileField);
        const hiddenTypeField = `<input type="hidden" name="type[${sectionId}][]" value="file">`;
        container.append(hiddenTypeField);
    }

    function addTextField(sectionId) {
        const container = $(`#dynamicFields_${sectionId}`);
        alert(sectionId);
        const textField = `
        <div class="row mt-5">
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Enter your question" name="question_text[${sectionId}][]">
            </div><br>
            <div class="col-md-7 mt-2">
              <input type="text" class="form-control" placeholder="Enter your Description" name="question_description[${sectionId}][]">
              </div>
            <div class="col-md-4 mt-2">
                <input type="text" class="form-control" name="text_${sectionId}" placeholder="Text input">
                </div>
                 <div class="col-md-1 mt-2">
                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill me-1" onclick="removeField(this)"><i class="ri-delete-bin-7-line ri-20px"></i></button>
            </div>
        </div>
    `;
        container.append(textField);
        const hiddenTypeField = `<input type="hidden" name="type[${sectionId}][]" value="text">`;
        container.append(hiddenTypeField);
    }

    function addsection(sectionId) {
        // alert(sectionId);
        let fieldCount = ++window.fieldCount;
        //  alert(fieldCount);
        const newCard = `
    <div class="card form-control mt-3" id="section_${fieldCount}">
      <div class="col-md-12">
            <div class="form-floating form-floating-outline">
                <select name="pillar_id[]" id="pillar_${fieldCount}" class="select2 form-select name" data-placeholder="Select Pillar" data-allow-clear="true">
                    <option value="">Select Pillar</option>
                    @foreach ($pillar as $p)
                        <option value="{{$p->id}}">{{$p->name}}</option>
                    @endforeach
                </select>
                <label for="name_${fieldCount}">Select Pillar</label>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="form-floating form-floating-outline">
                <input type="text" name="section_name[]" placeholder="Enter Section Name" class="form-control">
                <label for="name">Section Name</label>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="form-floating form-floating-outline">
                <textarea name="section_description[]" class="form-control" placeholder="Enter Section Description"></textarea>
                <label for="section_description">Section Description</label>
            </div>
        </div>
        <div id="dynamicFields_${fieldCount}" class="mt-3"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="button" id="choice_${fieldCount}" value="Choice" class="form-control" onclick="addChoiceField(${fieldCount})">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="button" id="text_${fieldCount}" class="form-control" value="Text" onclick="addTextField(${fieldCount})">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="button" id="rating_${fieldCount}" class="form-control" value="Rating" onclick="addRatingField(${fieldCount})">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="button" id="date_${fieldCount}" class="form-control" value="Date" onclick="addDateField(${fieldCount})">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="button" id="file_${fieldCount}" class="form-control" value="Upload File" onclick="addFileField(${fieldCount})">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="button" id="section_${fieldCount}" class="form-control" value="Section" onclick="addsection(${fieldCount})">
                    </div>
                </div>
            </div>
            <div id="dynamicFields_${fieldCount}_inner" class="mt-3"></div>
            <div class="row mt-3">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-primary rounded-0" onclick="removeSection(${fieldCount})" style="background-color:#00a6d5">Remove</button>
                </div>
            </div>
        </div>
    </div>
    `;

    $('#dynamicFields_' + sectionId).append(`<hr style="border: 1px solid #bbb; margin: 20px 0;">`).append(newCard);

    }


    window.fieldCount = 1;
    // Function to remove a field
    function removeField(button) {
        $(button).closest('.row').remove();

    }

    function removeoption(button) {
        const choiceOption = $(button).closest('.choice-option');
        choiceOption.remove();
    }
    // Function to remove a section
    function removeSection(sectionId) {
        $(`#section_${sectionId}`).remove();
    }
</script>
