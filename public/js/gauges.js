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

$(function () {

	// Bring life to the dials
	setInterval(function () {
		$.getJSON('api/v1/measurements').done( function(data) {
			var chart,
				series,
				dials = [
					'ac-power',
					'efficiency',
					'dc-power',
					'dc-voltage',
					'dc-current',
					'ac-voltage',
					'ac-current',
					'ac-frequency'
				];
			
		
				for (var index in dials) {
					chart = $('#' + dials[index]).highcharts();

					if (chart) {
						series = chart.series[0];
						points = series.points;
						value = data.measurements[dials[index].replace('-','_')];

						// Explicitly check for null, because 0 evaluates as false
						if (value != null) {
							if (points[0]) {
								points[0].update(value);
							} else {
								series.addPoint(value);
							}
						} else {
							if (points[0]) {
								points[0].remove();
							}								 
						}
					}
				}

		});

	}, 2000);

});
