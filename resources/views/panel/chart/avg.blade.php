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

<!-- Container for both charts -->
<div style="display: flex; justify-content: space-around; align-items: flex-start; margin-top: 20px;">
    <!-- Bar Chart Container -->
    <div id="average-chart" style="height: 500px; width: 50%;"></div>

    <!-- Radial Bar Chart Container -->
    <div id="radial-chart" style="height: 350px; width: 40%; margin-left: 20px;"></div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      const chartLabels = {!! json_encode($chartLabels) !!}; // Existing section names
      const chartData = {!! json_encode($chartData) !!}; // Existing average scores

      // Bar Chart Options (unchanged)
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
                  borderRadius: 8// Adjust this to change bar thickness
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

      // Render Bar Chart
      var barChart = new ApexCharts(document.querySelector("#average-chart"), barOptions);
      barChart.render();

      // Radial Bar Chart Options using your data
      var radialOptions = {
        series: chartData, // Use existing average scores
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
                        return seriesName + ": " + opts.w.globals.series[opts.seriesIndex] + "%"; // Display percentage
                    },
                },
            }
        },
        colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5'], // You can customize this based on your needs
        labels: chartLabels, // Use existing section names as labels
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    show: false
                }
            }
        }]
      };

      // Render Radial Bar Chart
      var radialChart = new ApexCharts(document.querySelector("#radial-chart"), radialOptions);
      radialChart.render();
  });
</script>


<h4 style="text-align:center; margin-bottom=20px; font-family:'Arial', sans-serif;"><strong>Section Performance Levels</strong></h4>

@foreach ($sectionData as $sectionId => $data)
    <div style="display:flex; align-items:center; margin-bottom:40px;">
        <!-- Chart Container -->
        <div id="chart-{{ $sectionId }}" style="height:400px; width:70%;"></div>

        <!-- Details Container -->
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
                      categories: chartLabels,
                      title: {
                          text: ''
                      }
                  },
                  plotOptions: {
                      bar: {
                          distributed: true,
                          columnWidth: '10%', // Adjusted to make bars thinner
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

    <div class="text-center" style="padding-bottom: 2%; padding-block-end: 2%">
      <button class="btn btn-dark rounded-0" onclick="printPage()" style="background-color: #00a6d5;">Print</button>
  </div>
 <script>
    function printPage() {
        // Create a new print window
        var printWindow = window.open('', '', 'height=600,width=800');

        // Define the header image HTML with improved styles
        var headerImage = `
            <div style="page-break-after: always; width: 100%; margin-bottom: 20px;">
                <img src="/assets/img/print/six-sigma-report.jpg" alt="Six Sigma Report" style="max-width: 100%; height: auto;">
            </div>
        `;

        // Add the content (name and description) to be printed
        var content = `
            <div style="width: 30%; padding-left: 20px;">
                <h5 style="font-family: 'Arial', sans-serif; color: #333;">
                    <strong>{{ $data['name'] }}</strong>
                </h5>
                <h5 style="font-family: 'Arial', sans-serif; color: #333;">
                    {{ $data['description'] }}
                </h5>
            </div>
        `;

        // Collect all chart containers
        var chartContainers = document.querySelectorAll('#average-chart, #radial-chart, [id^="chart-"]');
        var chartHTML = Array.from(chartContainers).map(chart => chart.outerHTML).join('');

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
                    margin: 0;
                }

                /* Image page styles */
                .image-page {
                    width: 100%;
                    height: 100%;
                    page-break-after: always;
                }

                .content {
                    width: 30%;
                    padding-left: 20px;
                    margin-top: 20px;
                }

                /* Chart container layout */
                .chart-container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    margin: 40px 0; /* Space between charts and content */
                    padding: 30px;
                    width: 100%;
                }

                /* Ensure charts are well presented */
                .chart-container canvas {
                    display: block;
                    max-width: 100%;
                    max-height: 100%;
                    height: auto;
                    width: auto;
                }
           </style>
        `);

        // Add the content (name, description, and header image)
        printWindow.document.write('<div class="image-page">');
        printWindow.document.write(headerImage);
        printWindow.document.write('</div>');

        // Add chart container
        printWindow.document.write('<div class="chart-container">');
        printWindow.document.write(chartHTML);
        printWindow.document.write('</div>');

        // Add content (name and description) below the charts
        printWindow.document.write('<div class="content">');
        printWindow.document.write(content);
        printWindow.document.write('</div>');

        printWindow.document.write('</body></html>');

        // Close the document for rendering
        printWindow.document.close();

        // Wait for the content to load and then trigger printing
        printWindow.onload = function () {
            printWindow.print();
            printWindow.close();
        };
    }
</script>






@endsection
