<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en"><![endif]-->
<html lang="en">

<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Semmy</title>

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/foundation.min.css">
	<link rel="stylesheet" href="css/app.css">

	<script src="js/foundation/vendor/modernizr.js"></script>

</head>
<body>

	<header class="row">
		<div class="small-12 columns">
			<h1>{{ $pv_name }} ({{ number_format($pv_power, 0, ',', '.') }} Wp)</h1>
		</div>
	</header>

	<div class="row">
		<div class="small-12 columns">
			<p>Generated <span id="generation">{{ number_format($measurements['generation'], 0, ',', '.') }}</span> Wh so far,
				which comes down to <span id="pv_efficiency">{{ number_format($measurements['generation'] / $pv_power, 2, ',', '.') }}</span> kWh/kWp.
			</p>
		</div>
	</div>

	<div class="row">
		<div class="small-4 columns" id="ac-power">
		</div>
		<div class="small-4 columns" id="efficiency">
		</div>
		<div class="small-4 columns" id="temperature">
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
		<p>Semmy by <a href="https://www.vandomburg.net/">Roderick van Domburg</a> is licensed under the terms of the MIT License. <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Beautiful charts</span> are powered by <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.highcharts.com/" property="cc:attributionName" rel="cc:attributionURL">Highcharts</a>, which is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.</p>
	</div>
	<div class="small-2 columns">
		<p><a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a></p>
	</div>
	</footer>

	<script src="js/foundation/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.min.js"></script>

	<script src="js/highcharts/highcharts.js"></script>
	<script src="js/highcharts/highcharts-more.js"></script>
	<script src="js/highcharts/modules/solid-gauge.js"></script>
	<script src="js/highcharts/modules/no-data-to-display.js"></script>

	<script src="js/gauges.js"></script>
	<script src="js/refresh.js"></script>

	<script>
	$(document).foundation();

	$(function () {

		// The AC power gauge
		$('#ac-power').highcharts(Highcharts.merge(gaugeOptions, {
			yAxis: {
				min: 0,
				max: {{ $max_ac_power }},
				tickPositions: [0, {{ $max_ac_power }}],
				stops: [
					[0.1, '#254117'], // dark forest green
					[0.9, '#52D017']	// yellow green
				],
				title: {
					text: 'AC Power'
				}
			},

			series: [{
				name: 'AC Power',
				data: [{{ $measurements['ac_power'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.0f}</span><br/>' +
							'<span class="unit">Watt</span></div>'
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
					[0.1,  '#DF5353'], // red
					[0.90, '#FF0000'], // yellow
					[0.92, '#254117'], // dark forest green
					[0.99, '#52D017'], // yellow green
				],
				title: {
					text: 'Efficiency'
				}
			},

			series: [{
				name: 'Efficiency',
				data: [{{ $measurements['efficiency'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.1f}</span><br/>' +
							'<span class="unit">%</span></div>'
				},
				tooltip: {
					valueSuffix: ' %'
				}
			}]

		}));

		// The temperature gauge
		$('#temperature').highcharts(Highcharts.merge(gaugeOptions, {
			yAxis: {
				min: {{ $min_temperature }},
				max: {{ $max_temperature }},
				tickPositions: [{{ $min_temperature }}, {{ $max_temperature }}],
				stops: [
					[0.1,  '#368BC1'],  // glacial blue ice
					[0.33, '#56A5EC'],  // iceberg
					[0.9,  '#E42217'],  // fire brick
				],
				title: {
					text: 'Temperature'
				}
			},

			series: [{
				name: 'Weather',
				data: [{{ $temperature }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.1f}</span><br/>' +
							'<span class="unit">&deg;C</span></div>'
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
					[0.9, '#52D017']	// yellow green
				],
				title: {
					text: 'DC Power'
				}
			},

			series: [{
				name: 'DC Power',
				data: [{{ $measurements['dc_power'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.0f}</span><br/>' +
							'<span class="unit">Watt</span></div>'
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
					[{{ $dc_voltage_min_stop }},	 '#DF5353'], // red
					[{{ $dc_voltage_min_mpp_stop }}, '#254117'], // yellow
					[{{ $dc_voltage_nom_mpp_stop }}, '#52D017'], // yellow green
					[{{ $dc_voltage_max_mpp_stop }}, '#254117'], // yellow
					[0.9,							 '#DF5353']	 // red
				],
				title: {
					text: 'DC Voltage'
				}
			},

			series: [{
				name: 'DC Voltage',
				data: [{{ $measurements['dc_voltage'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.0f}</span><br/>' +
							'<span class="unit">Volt</span></div>'
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
					[0.9, '#DF5353']	// red
				],
				title: {
					text: 'DC Current'
				}
			},

			series: [{
				name: 'DC Current',
				data: [{{ $measurements['dc_current'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.1f}</span><br/>' +
							'<span class="unit">Ampere</span></div>'
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
					[0.1,						 '#DF5353'], // red
					[{{ $ac_voltage_nom_stop }}, '#52D017'], // yellow green
					[0.9,						 '#DF5353']	 // red
				],
				title: {
					text: 'AC Voltage'
				}
			},

			series: [{
				name: 'AC Voltage',
				data: [{{ $measurements['ac_voltage'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.0f}</span><br/>' +
							'<span class="unit">Volt</span></div>'
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
				data: [{{ $measurements['ac_current'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.1f}</span><br/>' +
							'<span class="unit">Ampere</span></div>'
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
					[0.1,							 '#DF5353'], // red
					[{{ $ac_frequency_nom_stop }}, '#52D017'], // yellow green
					[0.9,							 '#DF5353']	 // red
				],
				title: {
					text: 'AC Frequency'
				}
			},

			series: [{
				name: 'AC Frequency',
				data: [{{ $measurements['ac_frequency'] }}],
				dataLabels: {
					format: '<div class="text-center"><span class="value">{y:.2f}</span><br/>' +
							'<span class="unit">Hertz</span></div>'
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
