@extends('layouts.layoutMaster')

@section('title', 'OMM-Reports')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


@section('content')

    {{-- <h4 style="text-align:center; margin-bottom:20px;"><strong>All Over Average Performance</strong></h4> --}}

    {{-- <div id="pie-chart" style="height: 350px; width: 40%; margin:0 auto;"></div><br> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartLabel = {!! json_encode($chartLabel[0] ?? 'Filled') !!};
            const chartData = {!! json_encode([$chartDatas[0], 100 - $chartDatas[0]]) !!};

            if (chartData.length === 0) {
                console.warn("No data available for the pie chart.");
                return;
            }
            var pieOptions = {
                chart: {
                    type: 'pie',
                    height: 300,
                    background: '#f9f9f9'
                },
                series: chartData, // Data for the pie chart
                labels: [chartLabel + ' Filled', chartLabel + ' Unfilled'],
                colors: ['#1ab7ea', '#d3d3d3'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2) + " %";
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(2) + " %"; // Format labels to show percentage
                    },
                    style: {
                        fontSize: '14px',
                        colors: ['#FFFFFF'] // Customize the font color for data labels
                    }
                },
                fill: {
                    opacity: 1, // Ensure full opacity to represent colors accurately
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            offset: -5 // Adjust the offset for better placement of labels
                        },
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: false,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b;
                                        }, 0) + '%'; // Show total percentage
                                    }
                                }
                            }
                        }
                    }
                }
            };

            var pieChart = new ApexCharts(document.querySelector(""), pieOptions);
            pieChart.render(); // Render the pie chart
        });
    </script> --}}

    <style>
        #content {
            display: none; /* Hide content initially */
        }
    </style>

    <div id="content">
        <h4 style="text-align:center; margin-bottom:20px;"><strong>Average Performance Across Sections</strong></h4>
        <div style="display: flex; justify-content: space-around; align-items: flex-start; margin-top: 20px;">
            <div id="average-chart" style="height: 500px; width: 50%;"></div>
            <div id="radial-chart" style="height: 350px; width: 40%; margin-left: 20px;"></div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chartLabels = {!! json_encode($chartLabels) !!};
                const chartData = {!! json_encode($chartData) !!};
                var barOptions = {
                    chart: {
                        type: 'bar',
                        height: 500,
                        background: '#f9f9f9'
                    },
                    series: [{
                        name: 'Average Score',
                        data: chartData
                    }],
                    xaxis: {
                        categories: chartLabels,
                        title: {
                            text: 'Sections'
                        }
                    },
                    plotOptions: {
                        bar: {
                            distributed: true,
                            columnWidth: '10%',
                            borderRadius: 8
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    yaxis: {
                        title: {
                            text: 'Average Percentage (%)'
                        },
                        min: 0,
                        max: 100
                    },
                    tooltip: {
                        theme: 'dark'
                    },
                    grid: {
                        borderColor: '#e0e0e0'
                    },
                    legend: {
                        show: false
                    }
                };
                var barChart = new ApexCharts(document.querySelector("#average-chart"), barOptions);
                barChart.render();
                var radialOptions = {
                    series: chartData,
                    chart: {
                        height: 390,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            offsetY: 0,
                            startAngle: 0,
                            endAngle: 270,
                            hollow: {
                                margin: 5,
                                size: '30%',
                                background: 'transparent',
                            },
                            dataLabels: {
                                name: {
                                    show: false,
                                },
                                value: {
                                    show: false,
                                }
                            },
                            barLabels: {
                                enabled: true,
                                useSeriesColors: true,
                                offsetX: -8,
                                fontSize: '16px',
                                formatter(seriesName, opts) {
                                    return seriesName + ": " + opts.w.globals.series[opts.seriesIndex] +
                                        "%";
                                },
                            },
                        }
                    },
                    colors: ['#1ab7ea', '#0084ff', '#39539E',
                        '#0077B5'
                    ],
                    labels: chartLabels,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                show: false
                            }
                        }
                    }]
                };

                var radialChart = new ApexCharts(document.querySelector("#radial-chart"), radialOptions);
                radialChart.render();
            });
        </script>
        <h4 style="text-align:center; margin-bottom:20px;"><strong>All Over Sections Average</strong></h4>
        <div id="bar-chart"></div>
        <script>
            const chartLabel = {!! json_encode($chartLabel) !!}; // Labels for categories (x-axis)
            const chartData = {!! json_encode($chartDatas) !!}; // Numeric values for bars

            var options = {
                series: [{
                    name: "Average Score",
                    data: chartData // Should be an array of numbers
                }],
                chart: {
                    type: 'bar',
                    height: 150
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        borderRadiusApplication: 'end',
                        horizontal: true,
                        columnWidth: '30%' // Set the column width for the bar chart
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: chartLabel,
                    min: 0,
                    max: 100,
                    tickAmount: 5, // Should be an array of labels
                }
            };

            var chart = new ApexCharts(document.querySelector("#bar-chart"), options);
            chart.render();
        </script>
        <style>
            #bar-chart {
                text-align: center;
                margin-bottom: 40px;

            }
        </style>


        {{-- <h4 style="text-align:center; margin-bottom=20px; font-family:'Arial', sans-serif;"><strong>Section Performance
                Levels</strong></h4> --}}

        {{-- @foreach ($sectionData as $sectionId => $data)
            <div style="display:flex; align-items:center; margin-bottom:40px;">
                <div id="chart-{{ $sectionId }}" data-section-name="{{ $data['name'] }}"
                    data-section-description="{{ $data['description'] }}" style="height:400px; width:70%;"></div>
                <div style="width:30%; padding-left:20px;">
                    <h5 style="font-family:'Arial', sans-serif; color:#333;"><strong>{{ $data['name'] }}</strong></h5>
                    <h5 style="font-family:'Arial', sans-serif; color:#333;">{{ $data['description'] }}</h5>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const chartLabels = {!! json_encode($data['labels']) !!};
                        const sectionPercentages = {!! json_encode($data['percentages']) !!};

                        var options = {
                            chart: {
                                type: 'bar',
                                height: 400,
                                background: '#f9f9f9',
                                toolbar: {
                                    show: true
                                }
                            },
                            series: [{
                                name: 'Performance Level',
                                data: sectionPercentages
                            }],
                            xaxis: {
                                categories: chartLabels
                            },
                            plotOptions: {
                                bar: {
                                    distributed: true,
                                    columnWidth: '10%',
                                    borderRadius: 8
                                }
                            },
                            dataLabels: {
                                enabled: true
                            },
                            yaxis: {
                                title: {
                                    text: 'Percentage (%)'
                                },
                                min: 0,
                                max: 100
                            },
                            tooltip: {
                                theme: 'dark'
                            },
                            grid: {
                                borderColor: '#e0e0e0'
                            },
                            legend: {
                                show: false
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#chart-{{ $sectionId }}"), options);
                        chart.render();
                    });
                </script>

            </div>
        @endforeach --}}


        <h4 style="text-align:center; margin-bottom:20px;"><strong>Average Performance Scores by Section</strong></h4>
        <div id="basiccharts"></div>
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
                            fontSize: '14px' // Increase x-axis labels font size
                        }
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector("#basiccharts"), options);
            chart.render();
        </script>
        <style>
            #basiccharts {
                width: 50%;
                margin: 0 auto;
            }
        </style>

        <h4 style="text-align:center; margin-bottom:20px;"><strong>Average Performance Scores by Pillar</strong></h4>
        <div id="PillarChart"></div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var radarData = @json($radarSeriesData);
                var radarLabels = @json($radarLabels);

                // Ensure the data covers all four sections
                var completeRadarData = [0, 0, 0, 0]; // Initialize an array with four parts
                for (var i = 0; i < radarData.length; i++) {
                    if (i < completeRadarData.length) {
                        completeRadarData[i] = radarData[i];
                    }
                }

                var options = {
                    chart: {
                        type: 'radar',
                        height: 500,
                        width: 500
                    },
                    series: [{
                        name: 'Average Score',
                        data: completeRadarData
                    }],
                    labels: radarLabels,
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
                        size: 6,
                        colors: ['#FFF'],
                        strokeColor: '#FF4560',
                        strokeWidth: 2,
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val; // Ensures formatted values
                            }
                        }
                    },
                    yaxis: {
                        show: true,
                        min: 0,
                        max: 100,
                        tickAmount: 5,
                        labels: {
                            formatter: function(val) {
                                return val;
                            }
                        }
                    },
                    xaxis: {
                        labels: {
                            style: {
                                fontSize: '14px',

                            }
                        }
                    },
                };

                var chart = new ApexCharts(document.querySelector("#PillarChart"), options);
                chart.render();
            });
        </script>


        <style>
            #PillarChart {
                width: 40%;
                margin: 0 auto;
            }
        </style>

        <h4 style="text-align:center; margin-bottom:20px;"><strong>Average Performance Scores by Question</strong></h4>
        <div id="questioncharts">
            @php
                use Illuminate\Support\Str;
            @endphp
            @foreach ($pillarDatas as $pillar)
                <div id="chart_{{ Str::slug($pillar['pillar_name']) }}" class="chart-container"></div>
                <h5>{{ $pillar['pillar_name'] }}</h5>
            @endforeach
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var pillarDatas = @json($pillarDatas);
                var pillarName = "{{ $pillar['pillar_name'] }}";
                pillarDatas.forEach(function(pillar, index) {
                    var radarData = pillar.questions.map(function(question) {
                        return question
                            .average_score; // Extract average score for each question in the pillar
                    });

                    var radarLabels = pillar.questions.map(function(question) {
                        return question.question_text; // Extract question text for labels
                    });

                    // Ensure the data covers all sections
                    var completeRadarData = new Array(radarLabels.length).fill(0); // Initialize with 0 values
                    for (var i = 0; i < radarData.length; i++) {
                        completeRadarData[i] = radarData[i]; // Fill the radarData
                    }

                    // Create the options for the radar chart
                    var options = {
                        chart: {
                            type: 'radar',
                            height: 500,
                            width: 800
                        },
                        series: [{
                            name: 'Average Score',
                            data: completeRadarData
                        }],
                        labels: radarLabels,
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
                            size: 6,
                            colors: ['#FFF'],
                            strokeColor: '#FF4560',
                            strokeWidth: 2,
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val; // Ensures formatted values
                                }
                            }
                        },
                        yaxis: {
                            show: true,
                            min: 0,
                            max: 100,
                            tickAmount: 5,
                            labels: {
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        },
                        xaxis: {
                            labels: {
                                rotate: -30, // Rotate at an angle
                                style: {
                                    fontSize: '14px',
                                    whiteSpace: 'normal', // Maintain readability
                                }
                            }
                        },

                    };

                    // Render the chart for each pillar in a separate div
                    var chart = new ApexCharts(document.querySelector("#chart_" + pillar.pillar_name.replace(
                        /\s+/g, '_').toLowerCase()), options);
                    chart.render();
                });
            });
        </script>
        <style>
            #questioncharts {
                width: 40%;
                margin: 0 auto;
            }

            h5 {
                margin: 0;
                padding-bottom: 0px;
                margin-bottom: 5px;
            }

            .chart-container {
                margin-top: 0px;
                margin-bottom: 15px;
                max-width: 600%;

            }
            .apexcharts-xaxis-label {
                white-space: normal;
                word-wrap: break-word;
                text-align: center;
            }

        </style>


        <div id="StackedCharts"></div>
        <script>
            var options = {
                chart: {
                    type: 'bar',
                    stacked: true,
                    height: 350
                },
                plotOptions: {
                    bar: {
                        columnWidth: '30%',
                    }
                },
                series: [
                    @foreach ($StackedData as $data)
                        {
                            name: 'Section {{ $loop->iteration }}',
                            data: @json($data)
                        },
                    @endforeach
                ],
                xaxis: {
                    categories: @json($StackedLabels),
                    title: {
                        text: 'Pillars'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Average Score'
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'center'
                }
            };

            var chart = new ApexCharts(document.querySelector(""), options);
            chart.render();
        </script>
        <style>
            #StackedCharts {
                width: 40%;
                margin: 0 auto;
            }
        </style>
        <div class="card">
            <div class="card-body">
                @foreach ($print_section as $s)
                    @php
                        $answeredQuestions = $questions
                            ->where('section_id', $s->id)
                            ->filter(function ($print_question) use ($print_answers, $s) {
                                return $print_answers
                                    ->where('question_id', $print_question->id)
                                    ->where('section_id', $s->id)
                                    // ->where('user_id', auth()->user()->id)
                                    ->isNotEmpty();
                            });
                    @endphp
                    <h5 class="card-title" style="color: #0d003d; text-align:left">
                        Block - {{ $s->pillar->name }}
                    </h5>
                    @foreach ($answeredQuestions as $q)
                        <div class="section mb-4">
                            <h5 class="card-title"
                                style="color: #00a6d5; background-color: #f1f1f1; padding: 7px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                {{ $s->section_name }} - {{ $q->question_text }}
                            </h5>
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <thead>
                                    <tr>
                                        <th style="color: #5cb85c; padding: 10px; font-weight: bold; text-align: center; width: 18%;">
                                            Nascent</th>
                                        <th style="width: 2%;"></th>
                                        <th style="color: #f0ad4e; padding: 10px; font-weight: bold; text-align: center; width: 18%;">Stable
                                        </th>
                                        <th style="width: 2%;"></th>
                                        <th style="color: #f04ef0; padding: 10px; font-weight: bold; text-align: center; width: 18%;">
                                            Maturing</th>
                                        <th style="width: 2%;"></th>
                                        <th style="color: #0275d8; padding: 10px; font-weight: bold; text-align: center; width: 18%;">
                                            Efficient</th>
                                        <th style="width: 2%;"></th>
                                        <th style="color: #d9534f; padding: 10px; font-weight: bold; text-align: center; width: 18%;">World
                                            Class</th>
                                        <th style="width: 2%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @php
                                            $userAnswers = $print_answers
                                                ->where('question_id', $q->id)
                                                ->where('section_id', $s->id)
                                                // ->where('user_id', auth()->user()->id);
                                        @endphp

                                        @foreach ($userAnswers as $userAnswer)
                                            @if ($q->type == 'radio')
                                                @foreach (json_decode($q->options) as $option)
                                                    <td style="text-align: center;width:15px;justify-content: space-around;text-align:justify;"
                                                        name="answers[{{ $s->id }}][{{ $q->id }}]"
                                                        value="{{ $option }}"
                                                        class="@if ($userAnswer->answer == $option) selected @endif">
                                                        {{ $option }}
                                                    </td>
                                                    <td style="width: 2%;"></td>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tr>

                                    @foreach ($userAnswers as $userAnswer)
                                        <tr>
                                            <td colspan="10" style="padding: 10px;">
                                                @if ($q->type === 'text' || $q->type === 'textarea')
                                                    <p><span style="font-size: 25px; color: #000708;">&#8594;</span>
                                                        <span
                                                            style="color: #555;">{{ $userAnswer->answer ?? 'No Answer' }}</span>
                                                    </p>
                                                @elseif ($q->type === 'radio')
                                                    <div class="progress-bar-container">
                                                        <div class="progress-bar">
                                                            <div class="progress-value"
                                                                style="left: calc(({{ array_search($userAnswer->answer, json_decode($q->options)) }} / 5) * 100%); width: 20%;">
                                                                {{ 'Current Level' }}
                                                            </div>
                                                            <div class="progress-ansvalue"
                                                                style="left: calc(({{ array_search($userAnswer->answers_future, json_decode($q->options)) }} / 5) * 100%); width: 20%;">
                                                                {{ 'After Three Years' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="width: 2%;"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endforeach




                <div class="comment">
                    <h3>Assessment Comments: </h3>
                    <p>{{ $comment ?? '' }}</p>
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

                    .selected {
                        background-color: #d3d3d3;
                        border: 2px solid #d3d3d3;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                        transition: background-color 0.3s, color 0.3s, border 0.3s, box-shadow 0.3s;
                    }

                    .comment {
                        display: none;
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

                    .table-container th {
                        color: #030303;
                        font-size: 12pt;
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
                        transform: translateX(-5%);
                        background-color: #b63881;
                        border-radius: 12px;
                        text-align: center;
                        line-height: 20px;
                        color: white;
                        font-size: 14px;
                        white-space: nowrap;
                        padding: 0px 20px 0px 20px;
                        transition: left 0.3s ease;
                    }

                    .assessment-table-container {
                        margin-bottom: 20px;
                        /* Spacing between tables */
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

                    .progress-ansvalue {
                        position: absolute;
                        top: 0;
                        left: 0;
                        height: 20px;
                        transform: translateX(0%);
                        background-color: #244ed8;
                        border-radius: 12px;
                        text-align: center;
                        line-height: 20px;
                        color: white;
                        font-size: 14px;
                        white-space: nowrap;
                        padding: 0px 20px 0px 20px;
                        transition: left 0.3s ease;
                    }
                </style>

            </div>
            <div class="table-data" style="width: 100%; height: 100%; margin: 0 auto; padding: 20px; box-sizing: border-box;">
                <h4 style="color: #00a6d5; text-align: left;">Scope of Assessment</h4>
                <p style="font-size: 16px; font-family: sans-serif; text-align: left; color: black;">
                    This OMM Assessment was conducted by {{ $name }}. The Assessment Record number, and the dates are
                    listed as follows.
                </p>

                <div class="table-container" style="margin-bottom: 20px; height: 33%;">
                    <table style="width: 100%; height: 100%; border: 3px solid #504e4e; border-collapse: collapse;">
                        <thead>
                            @php
                                $date = \Carbon\Carbon::now()->format('d/m/Y');
                            @endphp
                            <tr style="background-color:#00a6d5; color:white;">
                                <th colspan="2" style="padding: 10px; text-align:left;">ASSESSMENT DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="padding: 10px; text-align:left; border: 1px solid #000;">Date of Assessment</th>
                                <td style="padding: 10px; text-align:left; border: 1px solid #000; color:#000;">
                                    {{ $date }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 10px; text-align:left; border: 1px solid #000;">Company Name</th>
                                <td style="padding: 10px; text-align:left; border: 1px solid #000; color:#000;">
                                    {{ $company_details }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 10px; text-align:left; border: 1px solid #000;">Location</th>
                                <td style="padding: 10px; text-align:left; border: 1px solid #000; color:#000;">
                                    {{ $located }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 10px; text-align:left; border: 1px solid #000;">Industry Group</th>
                                <td style="padding: 10px; text-align:left; border: 1px solid #000; color:#000;">
                                    {{ $Primary }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-container" style="margin-bottom: 20px; height: 30%;">
                    <table style="width: 100%; height: 100%; border-collapse: collapse; border: 3px solid #504e4e;">
                        <thead>
                            <tr style="background-color:#00a6d5; color:white;">
                                <th style="padding: 10px; text-align:left;">KPI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($business_goals)
                                @foreach (json_decode($business_goals) as $kpi)
                                    <tr>
                                        <td style="padding: 10px; text-align:left; border: 1px solid #000; color:#000;">
                                            {{ $kpi }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="table-container" style="margin-bottom: 20px;height: 30%;">
                    <table style="width: 100%; height: 100%; border-collapse: collapse; border: 3px solid #504e4e;">
                        <thead>
                            <tr style="background-color:#00a6d5; color:white;">
                                <th style="padding: 10px; text-align:left;">Cost Driver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($drivers)
                                @foreach (json_decode($drivers) as $driver)
                                    <tr>
                                        <td style="padding: 10px; text-align:left; border: 1px solid #000; color:#000;">
                                            {{ $driver }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-container" style="height: 30%;">
                <table style="width: 100%; height: 100%; border-collapse: collapse; border: 3px solid #504e4e;">
                    <thead>
                        <tr style="background-color:#00a6d5; color:white;">
                            <th style="padding: 10px; text-align:left;">Tools & Concepts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tools)
                            @foreach (json_decode($tools) as $tool)
                                <tr>
                                    <td style="padding: 10px; text-align:left; border: 1px solid #000; color:#000;">
                                        {{ $tool }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            </div>



            
        </div>
    </div>
    <div class="text-center" style="padding-bottom: 2%; padding-block-end: 2%">
        <a href="{{ route('details-list.index') }}" class="btn btn-secondary rounded-0">Back</a>

        <button class="btn btn-dark rounded-0" onclick="printPage()" style="background-color: #00a6d5;">Print</button>
    </div>    
    <script>
        window.onload = function() {
            printPage();
        };
    </script>
<script>
function printPage() {
    var printWindow = window.open('', '', 'height=1000,width=1200');
    var printContent = document.querySelector('.card-body').innerHTML;
    var companyName = "{{ $company }}"; // Example company name
    var date = new Date().toLocaleDateString('en-GB');
    var preparedBy = "{{ $name }}"; // Example user name
    var dynamicImageSrc = "/assets/img/print/1.jpg";
    var firstpage = `<div class="dynamic-image-container" style="page-break-after: always;">
        <img src="${dynamicImageSrc}" alt="Dynamic Image" class="dynamic-image">
        <div class="company-name">
            <h3>COMPANY:</h3><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${companyName}</p>
        </div>
        <div class="date">
            <h3>DATE:</h3><p>&nbsp;&nbsp;&nbsp;${date}</p>
        </div>
        <div class="prepared-by">
            <h3>PREPARED BY:</h3><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${preparedBy}</p>
        </div>
    </div>`;
    var tablepage = document.querySelector('.table-data').innerHTML;
    var headerImage = `
      <div style="page-break-after: always; width: 100%; margin-bottom: 20px;">
        <img src="/assets/img/print/2.png" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
        <img src="/assets/img/print/3.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
        <img src="/assets/img/print/4.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
        <img src="/assets/img/print/5.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
        <img src="/assets/img/print/6.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
        <img src="/assets/img/print/7.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
      </div>
    `;
    var FooterImage = `
      <div style="page-break-after: always; width: 100%; margin-bottom: 20px;">
        <img src="/assets/img/print/11.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
      </div>
    `;
    var ContactImage = `
      <div style="page-break-after: always; width: 100%; margin-bottom: 20px;">
        <img src="/assets/img/print/13.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
      </div>
    `;

    var barchartHtml = `
      <div style="margin-bottom: 10px; width: 100%; text-align: center;">
        <h2>Results</h2>
        <div id="bar-chart" style="width: 100%;">${document.querySelector('#bar-chart').outerHTML}</div>
      </div>
    `;

    var averageChartHTML = document.querySelector('#average-chart').outerHTML;
    var radialChartHTML = document.querySelector('#radial-chart').outerHTML;

    var basicchartsHTML = `
      <div class="chart-wrapper" style="width: 80%; margin: 0 auto 30px auto;">
        <div id="basiccharts">${document.querySelector('#basiccharts').outerHTML}</div>
      </div>
    `;

    var PillarChartHTML = `
      <div class="chart-wrapper" style="width: 80%; margin: 0 auto 30px auto;">
        <div id="PillarChart">${document.querySelector('#PillarChart').outerHTML}</div>
      </div>
    `;

    // Modified to display charts one per line (vertically)
    var charts = document.querySelectorAll('#questioncharts .chart-container');
    var questionchartsHTML = "";

    // Display each chart on its own line
    for (let i = 0; i < charts.length; i++) {
        questionchartsHTML += `
            <div class="chart-wrapper" style="width: 85%; margin: 0 auto 30px auto;">
                ${charts[i].outerHTML}
            </div>
        `;
        
        // Add page break after every 2 charts
        if ((i + 1) % 2 === 0 && i < charts.length - 1) {
            questionchartsHTML += `<div style="page-break-after: always;"></div>`;
        }
    }

    var titleAndContent = `
        <div style="padding:20px;margin:0px auto;padding-bottom:10px;">
            <div class="card-body">${printContent}</div>
        </div>
    `;
    
    var tablecontent = `
      <div style="page-break-after: always; width: 100%; height: 80%; margin: 0 auto; padding-bottom: 10px; box-sizing: border-box;">
        <div class="card-body" style="height: 80%;">${tablepage}</div>
      </div>
    `;

    var commentSection = `
      <div class="card-footer" style="margin-top: 20px; padding: 10px;">
        <h3><strong>Assessment Comments: </strong></h3>
        <p>${'{{ $comment ?? '  The assessor 's comments will be displayed here only if the assessment has been conducted by Concept Business Excellence Private Limited.'
 }}'}</p>
      </div>
    `;
    
    printWindow.document.write('<html><head><title>Six Sigma Report</title>');

    // Add print styles
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
        margin: 5mm;
      }
      
      @page :first {
        margin: 0.5mm;
      }

      .image-page {
        width: 100%;
        height: 100%;
        page-break-after: always;
      }

      .chart-container {
        display: flex;
        flex-direction: column;
        margin-top: 10px;
        justify-content: center;
        align-items: center;
        padding: 10px;
        width: 100%;
      }

      .chart-wrapper {
        display: block;
        margin-bottom: 30px;
        page-break-inside: avoid;
      }

      .apexcharts-toolbar {
        display: none !important;
      }

      h4, h5 {
        margin: 0;
        padding: 5px 0;
      }
      
      .card-body .comment {
        display: none;
      }
      
      .dynamic-image-container {
        position: relative; /* CRITICAL: Positioning context */
        width: 100%;
        margin-bottom: 20px;
      }

      .dynamic-image {
        max-width: 100%;
        height: auto;
      }

      .dynamic-content {
        position: absolute;
        font-size: 20pt;
        font-family: sans-serif;
      }

      .company-name h3{
        position: absolute;
        top: 32%;
        left: 8%;
        color: #000000;
        text-align: left;
        font-size: 40pt;
        white-space: nowrap;
        font-family: sans-serif;
      }
      
      .company-name p{
        position: absolute;
        top: 32%;
        left: 33%;
        color: #0077cc;
        text-align: left;
        font-size: 40pt;
        white-space: nowrap;
        font-weight: bold;
        font-family: sans-serif;
      }

      .date h3{
        position: absolute;
        bottom: 10%;
        left: 10%;
        font-size: 30pt;
        white-space: nowrap;
        font-family: sans-serif;
        color: white;
      }
      
      .date p{
        position: absolute;
        bottom: 10%;
        left: 21%;
        font-size: 30pt;
        white-space: nowrap;
        font-family: sans-serif;
        font-weight: bold;
        color: white;
      }

      .prepared-by h3{
        position: absolute;
        bottom: 6%;
        left: 10%;
        font-size: 30pt;
        white-space: nowrap;
        font-family: sans-serif;
        color: white;
      }
      
      .prepared-by p{
        position: absolute;
        bottom: 6%;
        left: 37%;
        font-size: 30pt;
        white-space: nowrap;
        font-family: sans-serif;
        color: white;
        font-weight: bold;
      }

      /* Print styles (Recommended) */
      @media print {
        .dynamic-content {
          color: black; /* Ensure black text when printing */
        }
        
        .chart-wrapper {
          page-break-inside: avoid;
        }
      }
      
      .card-footer h3{
        padding: 20px;
        margin-bottom: 20px;
        color: #007bff;
        font-size: 20pt;
        text-align: center;
      }

      .card-footer p {
        margin: 0;
        padding: 0;
        color: #333;
        padding-left: 20px;
        font-size: 20pt;
      }

      /* Print styles */
      @media print {
        /* Ensure the comment section is visible when printing, even if it's hidden normally */
        .card-footer {
          display: block !important;
        }
      }
      
      .centered-chart {
        text-align: center;
        margin-bottom: 10px;
        width: 100%;
      }

      .centered-chart h3,h5 {
        margin-bottom: 10px;
      }

      .centered-chart div {
        display: inline-block;
      }

      h2 {
        color: #00a6d5;
        text-align: center;
      }

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
        page-break-inside: avoid;
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
        transform: translateX(25%);
        background-color: #b63881;
        border-radius: 12px;
        text-align: center;
        line-height: 20px;
        color: white;
        font-size: 14px;
        white-space: nowrap;
        padding: 0px 20px 0px 20px;
        transition: left 0.3s ease;
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

      .progress-ansvalue {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        transform: translateX(18%);
        background-color: #244ed8;
        border-radius: 12px;
        text-align: center;
        line-height: 20px;
        color: white;
        font-size: 14px;
        white-space: nowrap;
        padding: 0px 30px 0px 30px;
        transition: left 0.3s ease;
      }
      
      .selected {
            background-color: #d3d3d3;
            border: 2px solid #d3d3d3;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, color 0.3s, border 0.3s, box-shadow 0.3s;

        }
    </style>
    `);

    // Add header image and bar chart HTML
    printWindow.document.write('</head><body>');
    printWindow.document.write(firstpage);
    printWindow.document.write(headerImage);
    printWindow.document.write(tablecontent);
    printWindow.document.write(barchartHtml);

    // FIXED: Remove the page break between charts by removing the wrapping div with page-break-after
    // Place the first two charts vertically without forcing a page break after
    printWindow.document.write('<div>');
    printWindow.document.write(basicchartsHTML);
    printWindow.document.write(PillarChartHTML);
    printWindow.document.write('</div>');
    
    // Add the question charts (vertically arranged)
    printWindow.document.write(questionchartsHTML);
    
    printWindow.document.write(titleAndContent);
    printWindow.document.write(FooterImage);
    printWindow.document.write(commentSection);
    printWindow.document.write(ContactImage);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Wait for content to load and trigger print
    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
}
</script>




@endsection
