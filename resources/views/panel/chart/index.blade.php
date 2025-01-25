@extends('layouts.layoutMaster')

@section('title', 'Chart')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
    <h4>Level</h4>
    <div id="chart" style="width:70%;padding-left:20%"></div>
    <a href="{{ route('chart-list.create') }}">Next</a>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 500,
                    background: '#fff', // White background for the chart
                    toolbar: {
                        show: true // Show toolbar for additional options (like download)
                    }
                },
                series: [{
                    name: 'User Count',
                    data: [20, 40, 60, 80, 100] // Dummy data
                }],
                xaxis: {
                    categories: ['Nascent', 'Stable', 'Maturing', 'Efficient', 'World Class'], // Labels
                    title: {
                        text: 'Maturity Levels', // Title for the x-axis
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#333' // Color for x-axis title
                        }
                    }
                },
                colors: ['#00a6d5', '#5cb85c', '#f0ad4e', '#f04ef0', '#0275d8'],
                plotOptions: {
                    bar: {
                        distributed: true,
                        borderRadius: 8, // Rounded corners for bars
                        horizontal: false,
                        columnWidth: '30%' // Width of the bars relative to the available space
                    }
                },
                dataLabels: {
                    enabled: false, // Show data labels on bars
                    style: {
                        colors: ['#fff'], // Color of the data labels
                        fontSize: '12px',
                        fontWeight: 'bold'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Levels data',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#333' // Color for y-axis title
                        }
                    },
                    min: 0,
                    tickAmount: 5, // Number of ticks on y-axis
                    labels: {
                        style: {
                            colors: ['#333'], // Color for y-axis labels
                            fontSize: '12px'
                        }
                    }
                },
                tooltip: {
                    theme: 'dark' // Dark theme for tooltips
                },
                grid: {
                    borderColor: '#e0e0e0' // Light grey grid lines
                },
                legend: {
                    show: false // Hide the legend
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
            // document.getElementById('redirectButton').addEventListener('click', function() {
            //       window.location.href = "{{ route('chart-list.create') }}"; // Replace with your route
            //   });
        });
    </script>



@endsection
