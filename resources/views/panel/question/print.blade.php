@extends('layouts.layoutMaster')

@section('title', 'Print')


@section('content')
    <div class="card">
        <div class="card-body">
            @foreach ($sections as $s)
                @php
                    $answeredQuestions = $questions
                        ->where('section_id', $s->id)
                        ->filter(function ($question) use ($answers, $s) {
                            return $answers
                                ->where('question_id', $question->id)
                                ->where('section_id', $s->id)
                                ->where('user_id', auth()->user()->id)
                                ->isNotEmpty();
                        });

                        // dd($answeredQuestions);
                @endphp

                @if ($answeredQuestions->isNotEmpty())
                <h5 class="card-title"
                style="color: #0d003d; text-align:left">
                {{ $s->pillar->name}}
                </h5>
                    <div class="section mb-4">
                        <h5 class="card-title"
                            style="color: #00a6d5; background-color: #f1f1f1; padding: 7px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            {{ $s->section_name }}
                        </h5>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                            <thead>
                                <tr>
                                    {{-- <th style="padding: 10px; font-weight: bold;">Question</th> --}}
                                    <th style="color: #00a6d5; padding: 10px; font-weight: bold; text-align: center;">Level
                                    </th>
                                    <th style="color: #5cb85c; padding: 10px; font-weight: bold; text-align: center;">Nascent
                                    </th>
                                    <th style="color: #f0ad4e; padding: 10px; font-weight: bold; text-align: center;">Stable
                                    </th>
                                    <th style="color: #f04ef0; padding: 10px; font-weight: bold; text-align: center;">
                                        Maturing</th>
                                    <th style="color: #0275d8; padding: 10px; font-weight: bold; text-align: center;">
                                        Efficient</th>
                                    <th style="color: #d9534f; padding: 10px; font-weight: bold; text-align: center;">World
                                        Class</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($answeredQuestions as $q)
                                    @php
                                        $userAnswers = $answers
                                            ->where('question_id', $q->id)
                                            ->where('section_id', $s->id)
                                            ->where('user_id', auth()->user()->id);
                                            // dd($answeredQuestions);
                                    @endphp

                                    @if ($userAnswers->isNotEmpty())
                                        <tr>
                                            <td style="padding: 10px; text-align: left;">
                                                <strong>{{ $q->question_text }}</strong>
                                            </td>
                                            @foreach ($userAnswers as $userAnswer)
                                            @if ($q->type == 'radio')
                                            @foreach (json_decode($q->options) as $option)
                                                <td style="text-align: center;"
                                                    name="answers[{{ $s->id }}][{{ $q->id }}]"
                                                    value="{{ $option }}"
                                                    class="@if($userAnswer->answer == $option) selected @endif">
                                                    {{ $option }}
                                                </td>
                                            @endforeach
                                        @endif
                                      @endforeach

                                            @if ($q->type == 'checkbox')
                                                @foreach (json_decode($q->options) as $option)
                                                    <td style="text-align: center;"
                                                        name="answers[{{ $s->id }}][{{ $q->id }}]"
                                                        value="{{ $option }}">
                                                        {{ $option }}
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tr>

                                        @foreach ($userAnswers as $userAnswer)
                                            <tr>
                                                <td colspan="6" style="padding: 10px;">
                                                    @if ($q->type === 'text' || $q->type === 'textarea')
                                                        <p><span style="font-size: 25px; color: #000708;">&#8594;</span>
                                                            <span
                                                                style="color: #555;">{{ $userAnswer->answer ?? 'No Answer' }}</span>
                                                        </p>
                                                    @elseif ($q->type === 'date')
                                                        <p><span style="font-size: 25px; color: #000708;">&#8594;</span>
                                                            <span
                                                                style="color: #555;">{{ $userAnswer->answer ?? 'No Answer' }}</span>
                                                        </p>
                                                    @elseif ($q->type === 'checkbox')
                                                        {{-- @php
                                                            $totalOptions = 5; // Total number of checkbox options
                                                            $selectedValues = json_decode($userAnswer->answer); // User's selected answers (e.g., [1, 4])

                                                            // Ensure selected values are numeric and convert to zero-based index
                                                            $selectedIndexes = array_map(function($value) use ($totalOptions) {
                                                                return is_numeric($value) ? intval($value) - 1 : null; // Convert to zero-based index
                                                            }, $selectedValues);

                                                            // Filter out any null values (non-numeric)
                                                            $selectedIndexes = array_filter($selectedIndexes);
                                                        @endphp

                                                        <div class="progress-bar-container" style="position: relative; width: 100%; height: 30px; background-color: #ddd; border: 1px solid #ccc;">
                                                            @for ($i = 0; $i < $totalOptions; $i++)
                                                                <div class="progress-segment" style="
                                                                    position: absolute;
                                                                    width: calc(100% / {{ $totalOptions }});
                                                                    height: 100%;
                                                                    left: calc({{ $i }} * (100% / {{ $totalOptions }}));
                                                                    background-color: {{ in_array($i, $selectedIndexes) ? '#4caf50' : '#ddd' }};
                                                                    border-right: 1px solid #fff;
                                                                    text-align: center;
                                                                    line-height: 30px;
                                                                    font-size: 12px;
                                                                    color: {{ in_array($i, $selectedIndexes) ? '#fff' : '#000' }};
                                                                ">
                                                                    {{ in_array($i, $selectedIndexes) ? 'Selected ' . ($i + 1) : '' }}
                                                                </div>
                                                            @endfor
                                                        </div> --}}

                                                        <!-- Display Selected Values -->




                                                        <p>
                                                        <div class="progress-bar-container">
                                                            <div class="progress-bar-checkbox">
                                                                @php
                                                                    $options = json_decode($q->options);
                                                                    $selectedOptions = json_decode($userAnswer->answer);
                                                                @endphp

                                                                @foreach ($options as $index => $option)
                                                                    <div class="progress-value-checkbox"
                                                                        style="left: calc(({{ $index }} / {{ count($options) - 1 }}) * 100%);">
                                                                        @if (in_array($option, $selectedOptions))
                                                                            {{ 'Current Level' }}
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        </p>



                                                        {{-- </p> --}}
                                                    @elseif ($q->type === 'radio')
                                                        <div class="progress-bar-container">
                                                            <div class="progress-bar">
                                                                <div class="progress-value"
                                                                    style="left: calc(({{ array_search($userAnswer->answer, json_decode($q->options)) }} / 5) * 100%);">
                                                                    {{ 'Current Level' }}

                                                                </div>
                                                                <div class="progress-ansvalue"
                                                                    style="left: calc(({{ array_search($userAnswer->answers_future, json_decode($q->options)) }} / 5) * 100%);">
                                                                    {{ 'After Three Year' }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <!-- Optional: Display selected option number here -->
                                                                {{-- Option: {{ $userAnswer->answer }} --}}
                                                            @elseif ($q->type === 'rating')
                                                                <p>
                                                                    @php
                                                                        $answer = $userAnswer->answer ?? 0;
                                                                    @endphp
                                                                    @if ($answer > 0)
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <span
                                                                                style="font-size: 30px; color: {{ $i <= $answer ? 'gold' : 'gray' }};">&#9733;</span>
                                                                        @endfor
                                                                    @else
                                                                        No Rating Given
                                                                    @endif
                                                                </p>
                                                            @elseif ($q->type === 'file')
                                                                <p>
                                                                    @if ($userAnswer->answer)
                                                                        <a href="{{ asset('uploads/' . $userAnswer->answer) }}"
                                                                            target="_blank">View File</a>
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
            <div class="comment">
              <p>Assessment Comments: </p>{{ $comment ?? '' }}
          </div>

        </div>

        <div class="text-center" style="padding-bottom: 2%; padding-block-end: 2%">
            <button class="btn btn-dark rounded-0" onclick="printPage()" style="background-color: #00a6d5;">Print</button>
        </div>
    </div>

    <style>
            .card-body {
            padding: 40px;
            line-height: 1.6;
            font-size: 14pt;
            color: #333;
            background-color: #f9f9f9;
            margin-top: 30px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            padding: 10px;
            font-size: 11pt;
            text-align: center;
            vertical-align: top;
        }

        th {
            color: #00a6d5;
            font-weight: bold;
            font-size: 12pt;
        }

        .progress-bar-container {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }

        .progress-value {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            transform: translateX(20%);
            background-color: #b63881;
            border-radius: 12px;
            text-align: center;
            line-height: 20px;
            color: white;
            font-size: 14px;
            white-space: nowrap;
            padding:0px 20px 0px 20px;
            transition: left 0.3s ease;
        }



        .section {
            margin-bottom: 30px;
        }

        .section h5 {
            color: #00a6d5;
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            page-break-after: always;
        }

        .section-table {
            display: table;
            width: 100%;
            height: 100%;
        }

        .section-table td,
        .section-table th {
            vertical-align: top;
        }

        .section-table td {
            padding: 12px;
            width: 18%;
            font-size: 12pt;
        }


        .section-table td:last-child {
            padding-right: 20px;
        }

        .progress-bar-container {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .progress-bar-checkbox {
            width: 100%;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }

        .progress-value-checkbox {
            position: absolute;
            top: 0;
            left: 0;
            height: 21px;
            background-color: #b63881;
            border-radius: 12px;
            text-align: center;
        }
        .progress-ansvalue{
          position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            transform: translateX(40%);
            background-color: #244ed8;
            border-radius: 12px;
            text-align: center;
            line-height: 20px;
            color: white;
            font-size: 14px;
            white-space: nowrap;
            padding:0px 30px 0px 30px;
            transition: left 0.3s ease;
        }
        /* .selected {
    background-color: #d3d3d3;
    border: 2px solid #d3d3d3;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, color 0.3s, border 0.3s, box-shadow 0.3s;

} */
.comment {
    margin-top: 20px;
    padding: 15px 20px;
    background: #f1f1f1; /* Softer gray */
    border-radius: 8px;
    font-size: 16px;
    color: #000000;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1); /* Smooth shadow */
    text-align: center;
    max-width: 80%;
    margin-left: auto;
    margin-right: auto;
}

.comment p {
    margin: 0;
    font-weight: 500;
    line-height: 1.5;
    color: #00a6d5;
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
        <div style="page-break-before: always;padding:20px;margin:0px auto;">
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
                margin: 1mm;

            }
                @page :first {
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

            .card-body {
            padding: 30px;
            line-height: 1.4;
            font-size: 12pt;
            color: #333;
            background-color: #f9f9f9;
            margin-top: 20px;
            text-align: center;  /* Align content to center */
        }
      table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }

                th, td {
                    padding: 6px;
                    font-size: 9pt;
                    text-align: center;
                    vertical-align: top; /* Ensures that cells are aligned at the top */
                }

                th {
                    color: #00a6d5;
                    font-weight: bold;
                }

                .progress-bar-container {
                    position: relative;
                    width: 100%;
                    margin-bottom: 10px;
                }
                     .progress-bar {
                    width: 100%;
                    height: 15px;
                    background-color: #e0e0e0;
                    border-radius: 10px;
                    overflow: hidden;
                    position: relative;
                }

                .progress-value {
                    position: absolute;
                    top: 0;
                    left: 0;
                    height: 15px;
                     transform: translateX(30%);
                    background-color: #b63881;
                    border-radius: 10px;
                    text-align: center;
                    line-height: 15px;
                    color: white;
                    font-size: 12px;
                    white-space: nowrap;
                     padding:0px 20px 0px 20px;
                    transition: left 0.3s ease;
                }
                .section {
                   margin-top: 20px;
                   margin-bottom: 20px;
                    page-break-inside: avoid;
                }

                .section h5 {
                    color: #00a6d5;
                    background-color: #f1f1f1;
                    padding: 7px;
                    border-radius: 5px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    margin-bottom: 10px;

                }
                     .section-table {
                    display: table;
                    width: 100%;
                    height: 100%;
                }

                .section-table td, .section-table th {
                    vertical-align: top;
                }

                /* Ensure the content inside table cells uses available space */
                .section-table td {
                    padding: 8px;
                    width: 16%; /* Adjust cell widths to use space effectively */
                }

                /* Space between the content */
                .section-table td:last-child {
                    padding-right: 15px; /* Add extra space on the right side of the last column */
                }
            .progress-bar-container {
                position: relative;
                width: 100%;
                margin-bottom: 15px;
              }

              .progress-bar-checkbox {
                width: 100%;
                height: 20px;
                background-color: #e0e0e0;
                border-radius: 12px;
                overflow: hidden;
                position: relative;
              }

              .progress-value-checkbox {
                position: absolute;
                  top: 0;
                  left: 0;
                  height: 21px;
                  background-color: #b63881;
                  border-radius: 12px;
                  text-align: center;

                  /* Adjust this value to position the highlighted value vertically */
              }
                  .question {
                   page-break-after: auto; /* Allow breaks after questions if needed */
                 }
                   h5.card-title {
                   padding-top:20px;
                   padding-bottom:20px;
                  page-break-after: avoid; /* Ensure section title doesn't get separated */
                }

}
.comment {
    width: 100%;
    max-width: 800px; /* Adjust based on your layout */
    margin: 20px auto;
    padding: 10px;
    font-size: 14px;
    text-align: justify;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #f9f9f9;
}
     .progress-ansvalue{
         position: absolute;
                    top: 0;
                    left: 0;
                    height: 15px;
                     transform: translateX(10%);
                   background-color: #244ed8;
                    border-radius: 10px;
                    text-align: center;
                    line-height: 15px;
                    color: white;
                    font-size: 12px;
                    white-space: nowrap;
                     padding: 0px 20px 0px 20px;
                    transition: left 0.3s ease;
        }

@media print {
    .comment {
        page-break-inside: avoid;
         padding-top:20px;
        font-size: 12px;
        width: 100%;
        max-width: 100%;

    }
        .comment p{

        font-size: 12px;
        width: 100%;
        max-width: 100%;
        color: #00a6d5;
         font-weight: bold;

    }
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
            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };

            document.body.innerHTML = originalContent;
        }
    </script>

@endsection
