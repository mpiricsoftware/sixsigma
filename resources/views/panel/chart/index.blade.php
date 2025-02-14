@extends('layouts.layoutMaster')

@section('title', 'Chart')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <!-- Left Side: Pillar Name and Description -->
                <div class="col-md-6 d-flex flex-column justify-content-center">
                    <h3 class="text-primary">{{ $sections->first()->pillar->name }}</h3>
                    <p class="text-muted"><strong>{{ $sections->first()->pillar->description }}</strong></p>
                </div>

                <!-- Right Side: Radar Chart -->
                <div class="col-md-6">
                    <div id="basiccharts"></div>
                </div>
            </div>
        </div>
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

</div>

<script>
    var options = {
        chart: {
            type: 'radar'
        },
        series: [{
            name: @json($chartLabel),
            data: @json($chartData)
        }],
        labels: @json($chartLabels),
        plotOptions: {
            radar: {
                size: 140,
                polygons: {
                    strokeColors: '#e9e9e9',
                    fill: {
                        colors: ['#f8f8f8', '#fff']
                    }
                }
            }
        },
        markers: {
            size: 5,
            colors: ['#FFF'],
            strokeColor: '#FF4560',
            strokeWidth: 2,
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val
                }
            }
        },
        yaxis: {
            show: true,
            tickAmount: 5,
            labels: {
                formatter: function(val) {
                    return val
                }
            }
        },
        xaxis: {
            labels: {
                style: {
                    fontSize: '14px'
                }
            }
        },
    };

    var chart = new ApexCharts(document.querySelector("#basiccharts"), options);
    chart.render();
</script>

<style>
    #basiccharts {
        width: 100%;
        height: 300px;
    }
    .card {
        border-radius: 10px;
        padding: 20px;
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

</style>

@endsection
