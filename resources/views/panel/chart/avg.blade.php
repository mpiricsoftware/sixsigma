@extends('layouts.layoutMaster')

@section('title', 'Level-Wise')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



@section('content')
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


    <h4 style="text-align:center; margin-bottom=20px; font-family:'Arial', sans-serif;"><strong>Section Performance
            Levels</strong></h4>

            @foreach ($sectionData as $sectionId => $data)
            <div style="display:flex; align-items:center; margin-bottom:40px;">
                <div id="chart-{{ $sectionId }}" data-section-name="{{ $data['name'] }}" data-section-description="{{ $data['description'] }}" style="height:400px; width:70%;"></div>
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
                                toolbar: { show: true }
                            },
                            series: [{ name: 'Performance Level', data: sectionPercentages }],
                            xaxis: { categories: chartLabels },
                            plotOptions: {
                                bar: {
                                    distributed: true,
                                    columnWidth: '10%',
                                    borderRadius: 8
                                }
                            },
                            dataLabels: { enabled: true },
                            yaxis: {
                                title: { text: 'Percentage (%)' },
                                min: 0,
                                max: 100
                            },
                            tooltip: { theme: 'dark' },
                            grid: { borderColor: '#e0e0e0' },
                            legend: { show: false }
                        };

                        var chart = new ApexCharts(document.querySelector("#chart-{{ $sectionId }}"), options);
                        chart.render();
                    });
                </script>
            </div>
        @endforeach


    <div class="text-center" style="padding-bottom: 2%; padding-block-end: 2%">
        <button class="btn btn-dark rounded-0" onclick="printPage()" style="background-color: #00a6d5;">Print</button>
    </div>
    <script>
function printPage() {
    var printWindow = window.open('', '', 'height=600,width=800');
    var headerImage = `
    <div style="page-break-after: always; width: 100%; margin-bottom: 20px;">
        <img src="/assets/img/print/six-sigma-report.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
    </div>
    `;
    var sectionsHTML = '';
    document.querySelectorAll('[id^="chart-"]').forEach(chartContainer => {
        const chartHTML = chartContainer.outerHTML;
        const sectionName = chartContainer.getAttribute('data-section-name');
        const sectionDescription = chartContainer.getAttribute('data-section-description');

        sectionsHTML += `
        <div style="display: flex; align-items: flex-start; margin-bottom: 40px; page-break-inside: avoid;">
            <div style="width: 70%; margin-right: 20px;">
                ${chartHTML}
            </div>
            <div style="width: 30%; font-family: Arial, sans-serif; color: #333;">
                <h5><strong>${sectionName}</strong></h5>
                <h5>${sectionDescription}</h5>
            </div>
        </div>
        `;
    });

    // Add the overall charts (average and radial)
    var averageChartHTML = document.querySelector('#average-chart').outerHTML;
    var radialChartHTML = document.querySelector('#radial-chart').outerHTML;
    var overallChartsHTML = `
    <div style="page-break-inside: avoid; margin-bottom: 40px;">
        <h4 style="text-align: center; font-family: Arial, sans-serif;"><strong>Average Performance Across Sections</strong></h4>
        <div style="display: flex; justify-content: space-around; align-items: flex-start; margin-top: 20px;">
            <div style="width: 50%;">${averageChartHTML}</div>
            <div style="width: 50%;">${radialChartHTML}</div>
        </div>
    </div>
    `;

    // Write the HTML content to the new window
    printWindow.document.write('<html><head><title>Six Sigma Report</title>');

    // Add styles for printing
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
            margin: 0px;
        }

        .image-page {
            width: 100%;
            height: 100%;
            page-break-after: always;
        }

        .chart-container {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
            justify-content: space-around;
            align-items: flex-start;
            padding: 30px;
            width: 100%;
        }

        .apexcharts-toolbar {
            display: none !important;
        }

        h4, h5 {
            margin: 0;
            padding: 5px 0;
        }
    </style>
    `);

    // Add the header image
    printWindow.document.write('<div class="image-page">');
    printWindow.document.write(headerImage);
    printWindow.document.write('</div>');

    // Add the overall charts
    printWindow.document.write('<div class="chart-container">');
    printWindow.document.write(overallChartsHTML);
    printWindow.document.write('</div>');

    // Add each section chart with its name and description
    printWindow.document.write('<div class="chart-container">');
    printWindow.document.write(sectionsHTML);  // Ensure sectionsHTML is correctly injected
    printWindow.document.write('</div>');

    // Close the document for rendering
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Wait for the content to load and then trigger printing
    printWindow.onload = function() {
        // Ensure the sections are properly rendered before printing
        printWindow.print();
        printWindow.close();
    };
}

</script>

@endsection
