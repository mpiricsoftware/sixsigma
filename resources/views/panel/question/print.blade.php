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
      @endphp

      @if ($answeredQuestions->isNotEmpty())
        <div class="section mb-4">
          <h5 class="card-title" style="color: #00a6d5; background-color: #f1f1f1; padding: 7px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            {{ $s->section_name }}
          </h5>
          <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
              <tr>
                {{-- <th style="padding: 10px; font-weight: bold;">Question</th> --}}
                <th style="color: #00a6d5; padding: 10px; font-weight: bold; text-align: center;">Level</th>
                <th style="color: #5cb85c; padding: 10px; font-weight: bold; text-align: center;">Nascent</th>
                <th style="color: #f0ad4e; padding: 10px; font-weight: bold; text-align: center;">Stable</th>
                <th style="color: #f04ef0; padding: 10px; font-weight: bold; text-align: center;">Maturing</th>
                <th style="color: #0275d8; padding: 10px; font-weight: bold; text-align: center;">Efficient</th>
                <th style="color: #d9534f; padding: 10px; font-weight: bold; text-align: center;">World Class</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($answeredQuestions as $q)
                @php
                  $userAnswers = $answers->where('question_id', $q->id)
                                         ->where('section_id', $s->id)
                                         ->where('user_id', auth()->user()->id);
                @endphp

                @if ($userAnswers->isNotEmpty())
                  <tr>
                 <td style="padding: 10px; text-align: left;"><strong>{{ $q->question_text }}</strong></td>

                    @if ($q->type == 'radio')
                      @foreach(json_decode($q->options) as $option)
                        <td style="text-align: center;" name="answers[{{ $s->id }}][{{ $q->id }}]" value="{{ $option }}">
                          {{ $option }}
                        </td>
                      @endforeach
                    @endif
                  </tr>

                  @foreach ($userAnswers as $userAnswer)
                    <tr>
                      <td colspan="6" style="padding: 10px;">
                        @if ($q->type === 'text' || $q->type === 'textarea')
                          <p><span style="font-size: 25px; color: #000708;">&#8594;</span> <span style="color: #555;">{{ $userAnswer->answer ?? 'No Answer' }}</span></p>

                        @elseif ($q->type === 'date')
                          <p><span style="font-size: 25px; color: #000708;">&#8594;</span> <span style="color: #555;">{{ $userAnswer->answer ?? 'No Answer' }}</span></p>

                        @elseif ($q->type === 'checkbox')
                          <p>
                            @foreach (json_decode($userAnswer->answer) as $checkboxAnswer)
                              <span style="font-size: 25px; color: #000708;">&#8594;</span> <span style="color: #555;">{{ $checkboxAnswer }}</span><br>
                              <hr style="border: 1px solid #bbb; margin: 20px 0;">
                            @endforeach
                          </p>
                          @elseif ($q->type === 'radio')
    <div class="progress-bar-container">
        <div class="progress-bar">
            <div class="progress-value" style="left: calc(({{ array_search($userAnswer->answer, json_decode($q->options)) }} / 5) * 100%);">
                {{ 'Our Overall Maturity Level' }}
            </div>
        </div>
        <div>
            <!-- Optional: Display selected option number here -->
            {{-- Option: {{ $userAnswer->answer }} --}}
        </div>
    </div>



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
                      </td>
                    </tr>
                  @endforeach
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

    @endforeach
  </div>

  <div class="text-center" style="padding-bottom: 2%; padding-block-end: 2%">
    <button class="btn btn-dark rounded-0" onclick="printPage()" style="background-color: #00a6d5;">Print</button>
  </div>
</div>



<style>
.progress-bar-container {
    width: 100%;
    position: relative;
}

.progress-bar {
    position: relative;
    width: 100%;
    height: 20px;
    background-color: #e0e0e0; /* Background for the progress bar */
    border-radius: 10px;
    overflow: hidden;
}

.progress-value {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    background-color: #bd76c7; /* Highlight color */
    border-radius: 10px; /* Rounded edges for consistency */
    text-align: center;
    line-height: 20px; /* Center text vertically */
    color: white; /* Text color */
    font-size: 12px; /* Font size for the number */
    white-space: nowrap; /* Prevent text from wrapping */
    transform: translateX(-70%); /* Center the progress value horizontally */
}




  </style>
<script>
function printPage() {
    var originalContent = document.body.innerHTML;
    var printContent = document.querySelector('.card-body').innerHTML;
    var headerImage = `
        <div style="page-break-after: always; width: 100%; height: 100%; margin-bottom: 20px;">
            <img src="/assets/img/print/six-sigma-report.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
        </div>
    `;
    var titleAndContent = `
        <div style="page-break-before: always;">
            <div class="card-body">${printContent}</div>
        </div>
    `;

    var printWindow = window.open('', '', 'height=1000,width=1200');
    printWindow.document.write('<html><head><title>Six-Sigma</title>');
    printWindow.document.write(`
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #fff;
            }

            @page {
                size: A4;
                margin: 0;
            }

            /* Image page styles */
            .image-page {
                width: 100%;
                height: 100%;
                page-break-after: always;
            }

            /* Card body content styles */
            .card-body {
                padding: 20px;
                line-height: 1.4;
                font-size: 12pt;
                color: #333;
                background-color: #f9f9f9;
                margin-top: 20px;

            }

        </style>
    `);
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div class="image-page">');
    printWindow.document.write(headerImage);
    printWindow.document.write('</div>');
    printWindow.document.write(titleAndContent);
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





