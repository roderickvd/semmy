<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en"><![endif]-->
<html lang="en">

<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semmy</title>

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/foundation.min.css">

  <script src="js/foundation/vendor/modernizr.js"></script>

</head>
<body>

  <header class="row">
    <div class="small-12 columns">
      <h1>{{ $pv_name }} ({{ number_format($pv_power, 0, ',', '.') }} Wp)</h1>
    </div>
  </header>

  <div class="row">
    <div class="small-4 columns" id="ac-power">
    </div>
    <div class="small-4 columns" id="efficiency">
    </div>
    <div class="small-4 columns text-center" id="weather">
      <h2>Weather</h2>
      <p>No data to display.</p>
    </div>    
  </div>

  <div class="row">
    <div class="small-4 columns" id="dc-power">
    </div>
    <div class="small-4 columns" id="dc-voltage">
    </div>
    <div class="small-4 columns" id="dc-current">
    </div>
  </div>

  <div class="row">
    <div class="small-4 columns" id="ac-voltage">
    </div>
    <div class="small-4 columns" id="ac-current">
    </div>
    <div class="small-4 columns" id="ac-frequency">
    </div>
  </div>

  <footer class="row">
    <div class="small-10 columns">
      <p><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Semmy</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="https://www.vandomburg.net" property="cc:attributionName" rel="cc:attributionURL">Roderick van Domburg</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>. Beautiful graphs are powered by <a href="http://www.highcharts.com/">Highcharts</a>.</p>
    </div>
    <div class="small-2 columns">
      <p><a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a></p>
    </div>
  </footer>

  <script src="js/foundation/vendor/jquery.js"></script>
  <script src="js/foundation/foundation.min.js"></script>

  <script src="js/highcharts/highcharts.js"></script>
  <script src="js/highcharts/highcharts-more.js"></script>
  <script src="js/highcharts/modules/solid-gauge.js"></script>
  <script src="js/highcharts/modules/no-data-to-display.js"></script>

  <script>
    $(document).foundation();

    $(function () {

        var gaugeOptions = {

            chart: {
                type: 'solidgauge'
            },

            title: null,

            pane: {
                center: ['50%', '50%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor: '#EEE',
                    innerRadius: '60%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            tooltip: {
                enabled: false
            },

            // the value axis
            yAxis: {
                lineWidth: 0,
                minorTickInterval: null,
                tickWidth: 0,
                title: {
                    y: -90
                },
                labels: {
                    y: 16
                }
            },

            credits: {
                enabled: false
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        y: -56,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };

        // The AC power gauge
        $('#ac-power').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: {{ $max_ac_power }},
                tickPositions: [0, {{ $max_ac_power }}],
                stops: [
                    [0.1, '#254117'], // dark forest green
                    [0.9, '#52D017']  // yellow green
                ],
                title: {
                    text: 'AC Power'
                }
            },

            series: [{
                name: 'AC Power',
                data: [{{ $ac_power }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y}</span><br/>' +
                           '<span style="font-size:12px;color:silver">Watt</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Watt'
                }
            }]

        }));

        // The efficiency gauge
        $('#efficiency').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                tickPositions: [0, 100],
                stops: [
                    [0.90, '#DF5353'],  // red
                    [0.95, '#254117'],  // dark forest green
                    [0.98, '#52D017'], // yellow green
                ],
                title: {
                    text: 'Efficiency'
                }
            },

            series: [{
                name: 'Efficiency',
                data: [{{ $efficiency }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y:.1f}</span><br/>' +
                           '<span style="font-size:12px;color:silver">%</span></div>'
                },
                tooltip: {
                    valueSuffix: ' %'
                }
            }]

        }));

        // The DC power gauge
        $('#dc-power').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: {{ $max_dc_power }},
                tickPositions: [0, {{ $max_dc_power }}],
                stops: [
                    [0.1, '#254117'], // dark forest green
                    [0.9, '#52D017']  // yellow green
                ],
                title: {
                    text: 'DC Power'
                }
            },

            series: [{
                name: 'DC Power',
                data: [{{ $dc_power }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y}</span><br/>' +
                           '<span style="font-size:12px;color:silver">Watt</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Watt'
                }
            }]

        }));

        // The DC voltage gauge
        $('#dc-voltage').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: {{ $max_dc_voltage }},
                tickPositions: [0, {{ $max_dc_voltage }}],
                stops: [
                    [{{ $dc_voltage_min_stop }}, '#DF5353'],     // red
                    [{{ $dc_voltage_min_mpp_stop }}, '#254117'], // dark forest green
                    [{{ $dc_voltage_nom_mpp_stop }}, '#52D017'], // yellow green
                    [{{ $dc_voltage_max_mpp_stop }}, '#254117'], // dark forest green
                    [0.9, '#DF5353'] // red
                ],
                title: {
                    text: 'DC Voltage'
                }
            },

            series: [{
                name: 'DC Voltage',
                data: [{{ $dc_voltage }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y}</span><br/>' +
                           '<span style="font-size:12px;color:silver">Volt</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Volt'
                }
            }]

        }));

        // The DC current gauge
        $('#dc-current').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: {{ $max_dc_current }},
                tickPositions: [0, {{ $max_dc_current }}],
                stops: [
                    [0.1, '#254117'], // dark forest green
                    [0.5, '#52D017'], // yellow green
                    [0.9, '#DF5353']  // red
                ],
                title: {
                    text: 'DC Current'
                }
            },

            series: [{
                name: 'DC Current',
                data: [{{ $dc_current }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y:.1f}</span><br/>' +
                           '<span style="font-size:12px;color:silver">Ampere</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Ampere'
                }
            }]

        }));

        // The AC voltage gauge
        $('#ac-voltage').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: {{ $min_ac_voltage }},
                max: {{ $max_ac_voltage }},
                tickPositions: [{{ $min_ac_voltage }}, {{ $max_ac_voltage }}],
                stops: [
                    [0.1, '#DF5353'],                        // red
                    [{{ $ac_voltage_nom_stop }}, '#52D017'], // yellow green
                    [0.9, '#DF5353']                         // red
                ],
                title: {
                    text: 'AC Voltage'
                }
            },

            series: [{
                name: 'AC Voltage',
                data: [{{ $ac_voltage }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y}</span><br/>' +
                           '<span style="font-size:12px;color:silver">Volt</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Volt'
                }
            }]

        }));

        // The AC current gauge
        $('#ac-current').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: {{ $max_ac_current }},
                tickPositions: [0, {{ $max_ac_current }}],
                stops: [
                    [0.1, '#254117'], // dark forest green
                    [0.9, '#52D017'], // yellow green
                ],
                title: {
                    text: 'AC Current'
                }
            },

            series: [{
                name: 'AC Current',
                data: [{{ $ac_current }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y:.1f}</span><br/>' +
                           '<span style="font-size:12px;color:silver">Ampere</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Ampere'
                }
            }]

        }));

        // The AC frequency gauge
        $('#ac-frequency').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: {{ $min_ac_frequency }},
                max: {{ $max_ac_frequency }},
                tickPositions: [{{ $min_ac_frequency }}, {{ $max_ac_frequency }}],
                stops: [
                    [0.1, '#DF5353'],                          // red
                    [{{ $ac_frequency_nom_stop }}, '#52D017'], // yellow green
                    [0.9, '#DF5353']                           // red
                ],
                title: {
                    text: 'AC Frequency'
                }
            },

            series: [{
                name: 'AC Frequency',
                data: [{{ $ac_frequency }}],
                dataLabels: {
                    format: '<div class="text-center"><span style="font-size:25px;color:black">{y:.2f}</span><br/>' +
                           '<span style="font-size:12px;color:silver">Hz</span></div>'
                },
                tooltip: {
                    valueSuffix: ' Hz'
                }
            }]

        }));

    });
  </script>
</body>
</html>
