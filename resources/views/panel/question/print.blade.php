@extends('layouts.layoutMaster')

@section('title', 'Print')


@section('content')
<div class="card">
  <div class="card-body">
      @foreach ($sections as $s)
          @php
              $answeredQuestions = $questions->where('section_id', $s->id)
                                              ->filter(function($question) use ($answers, $s) {
                                                  return $answers->where('question_id', $question->id)
                                                                 ->where('section_id', $s->id)
                                                                 ->where('user_id', auth()->user()->id)
                                                                 ->isNotEmpty();
                                              });
                                              // dd($question)
          @endphp

          @if ($answeredQuestions->isNotEmpty())
              <div class="section">
                    &nbsp;<h5 class="card-title" style="color: #00a6d5; background-color: #f1f1f1; padding: 7px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                     {{ $s->section_name }}
                </h5>

                  {{-- <hr> --}}

                  @foreach ($answeredQuestions as $q)
                      @php

                          $userAnswers = $answers->where('question_id', $q->id)
                                                 ->where('section_id', $s->id)
                                                 ->where('user_id', auth()->user()->id);
                      @endphp

                      @if ($userAnswers->isNotEmpty())
                          <div class="question" style="padding-top: 1%">
                              <label><strong> Question : </strong>{{ $q->question_text }}</label>

                              @foreach ($userAnswers as $userAnswer)
                                  @if ($q->type === 'text' || $q->type === 'textarea')
                                      <p><span style="font-size: 25px; color: #000708;">&#8594;</span> <span style="color: #555;">{{ $userAnswer->answer ?? 'No Answer' }}</span></p>

                                  @elseif ($q->type === 'date')
                                      <p><span style="font-size: 25px; color: #000708;">&#8594;</span> <span style="color: #555;">{{ $userAnswer->answer ?? 'No Answer' }}</span></p>

                                  @elseif ($q->type === 'checkbox')
                                      <p>
                                          @foreach (json_decode($userAnswer->answer) as $checkboxAnswer)
                                          <span style="font-size: 25px; color: #000708;">&#8594;</span> <span style="color: #555;">{{ $checkboxAnswer }}</span><br>
                                          @endforeach
                                      </p>
                                 @elseif ($q->type === 'choice')
                                     <p>
                                        <span style="font-size: 25px; color: #000708;">&#8594;</span> <span style="color: #555;">{{$userAnswer->answer ?? 'No Answer'}}</span>
                                     </p>
                                  @elseif ($q->type === 'rating')
                                      <p>
                                          @php
                                              $answer = $userAnswer->answer ?? 0;
                                          @endphp
                                          @if ($answer > 0)
                                              @for ($i = 1; $i <= 5; $i++)
                                                  <span style="font-size: 30px; color: {{ $i <= $answer ? 'gold' : 'gray' }};">&#9733;</span>
                                              @endfor
                                          @else
                                              No Rating Given
                                          @endif
                                      </p>

                                  @elseif ($q->type === 'file')
                                      <p>
                                          @if ($userAnswer->answer)
                                              <a href="{{ asset('uploads/' . $userAnswer->answer) }}" target="_blank">View File</a>
                                          @else
                                              No File Uploaded
                                          @endif
                                      </p>
                                  @endif
                              @endforeach
                          </div>
                      @endif
                  @endforeach
              </div>

              {{-- <hr> <!-- Section separation --> --}}
          @endif
      @endforeach
  </div>


  <div class="text-center" style="padding-bottom:2%; padding-block-end: 2%">
    <button class="btn btn-dark rounded-0" onclick="printPage()" style="background-color: #00a6d5;">Print</button>

  </div>

</div>



<script>
 function printPage() {
    var originalContent = document.body.innerHTML;
    var printContent = document.querySelector('.card-body').innerHTML;


    var headerImage = `
        <div style="margin-bottom: 20px; page-break-after: always;">
            <img src="/assets/img/print/six-sigma-report.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
        </div>
    `;

    var printWindow = window.open('', '', 'height=800,width=1000');


    printWindow.document.write('<html><head><title>Six-Sigma</title>');
    printWindow.document.write('</head><body>');

    printWindow.document.write(headerImage);
    printWindow.document.write('<div style="page-break-before: always;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>');

    printWindow.document.write('<div class="card-body">' + printContent + '</div>');

    printWindow.document.write('</body></html>');
    printWindow.document.close();

    printWindow.onload = function () {
        printWindow.print();
        printWindow.close();
    };

    document.body.innerHTML = originalContent;
}



</script>

@endsection





