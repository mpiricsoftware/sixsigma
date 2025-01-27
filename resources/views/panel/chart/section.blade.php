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
    <h4 style="text-align: center; margin-bottom: 20px; font-family: 'Arial', sans-serif;">Section Performance Levels</h4>
    <a href="{{url('chart.avg')}}">Next</a>
    @foreach ($sectionData as $sectionId => $data)
        <div style="margin-bottom: 40px;">
            <h5 style="text-align: center; font-family: 'Arial', sans-serif; color: #333;">{{ $data['name'] }}</h5>
            <div id="chart-{{ $sectionId }}" style="height: 400px; margin-top: 20px;"></div>
            <!-- Increased height for better visibility -->

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const chartLabels = {!! json_encode($data['labels']) !!};
                    const sectionPercentages = {!! json_encode($data['percentages']) !!};

                    var options = {
                        chart: {
                            type: 'bar',
                            height: 400, // Adjusted height
                            background: '#f9f9f9', // Light background
                            toolbar: {
                                show: true
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                animateGradually: {
                                    enabled: true,
                                    delay: 150
                                },
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            }
                        },
                        series: [{
                            name: 'Performance Level',
                            data: sectionPercentages
                        }],
                        xaxis: {
                            categories: chartLabels,
                            title: {
                                text: 'Questions',
                                style: {
                                    fontSize: '16px',
                                    fontWeight: 'bold',
                                    color: '#333'
                                }
                            },
                            labels: {
                                style: {
                                    fontSize: '12px' // Adjusted label size
                                }
                            }
                        },
                        colors: ['#00a6d5', '#5cb85c', '#f0ad4e', '#f04ef0', '#0275d8'], // Specific colors for series
                        plotOptions: {
                            bar: {
                                distributed: true,
                                borderRadius: 8, // Rounded corners for bars
                                horizontal: false,
                                columnWidth: '10%', // Increased width for better visibility
                                dataLabels: {
                                    position: 'top' // Positioning data labels on top of bars
                                }
                            }
                        },

                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '12px',
                                colors: ['#fff'] // White color for data labels on dark bars
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Percentage (%)',
                                style: {
                                    fontSize: '16px',
                                    fontWeight: 'bold',
                                    color: '#333'
                                }
                            },
                            min: 0,
                            max: 100,
                            tickAmount: 5,
                            labels: {
                                style: {
                                    colors: ['#333'], // Color for y-axis labels
                                    fontSize: '12px'
                                }
                            }
                        },
                        tooltip: {
                            theme: 'dark', // Dark theme for tooltips
                            style: {
                                fontSize: '12px'
                            },
                            x: {
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        },
                        grid: {
                            borderColor: '#e0e0e0', // Light grey grid lines
                            strokeDashArray: 4 // Dashed grid lines
                        },
                        legend: {
                            show: false // Hide the legend
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-{{ $sectionId }}"), options);
                    chart.render();
                });
            </script>
        </div>
    @endforeach

@endsection
