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


    <h4 style="text-align:center; margin-bottom:20px;"><strong>All Over Average Performance</strong></h4>

    <div id="pie-chart" style="height: 350px; width: 40%; margin:0 auto;"></div><br>

    <script>
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
                    height: 350,
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

            var pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieOptions);
            pieChart.render(); // Render the pie chart
        });
    </script>



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
    @endforeach
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
                height: 200
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    horizontal: true,
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
            /* Adjust the width to your desired size */
            margin: 0 auto;
            /* Center the chart */
        }
    </style>
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

              // Log the section name and description to ensure they are captured
              console.log(`Section Name: ${sectionName}, Section Description: ${sectionDescription}`);

              sectionsHTML += `
                  <div style="page-break-inside: avoid; display: flex; align-items: center; margin-bottom: 20px;">
                      <div style="flex: 0 0 50%; margin-right: 20px;">
                          ${chartHTML}
                      </div>
                      <div style="flex: 0 0 15%; font-family: Arial, sans-serif; color: #333; text-align: left; font-size:18px;">
                          <h5 style="text-align: center;"><strong>${sectionName}</strong></h5>
                          <h5 style="text-align: center;">${sectionDescription}</h5>
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

          // Add the bar chart
          var basicchartstHTML = `

              <div id="basiccharts">${document.querySelector('#basiccharts').outerHTML}</div>
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
                      #basiccharts {
                      margin: 0 auto;

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
          printWindow.document.write(sectionsHTML);
          printWindow.document.write('</div>');

         // Add the bar chart
          printWindow.document.write('<div class="chart-container">');
          printWindow.document.write(basicchartstHTML);
          printWindow.document.write('</div>');
          // Close the document for rendering
          printWindow.document.write('</body></html>');
          printWindow.document.close();

          // Wait for the content to load and then trigger printing
          printWindow.onload = function() {
              printWindow.print();
              printWindow.close();
          };
      }
  </script>


@endsection
