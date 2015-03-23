function addThousandsSeperator(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}

$(function () {

	var animation = {
		duration: 1000,
		easing: 'swing'
	};

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
						value  = data.measurements[dials[index].replace('-','_')];

						// Explicitly check for null, because 0 evaluates as false
						if (value != null) {
							series.setData([value], true, animation, true);
						} else {
							series.removePoint(0);
						}
					}
				}

				generation  = data.measurements.generation || 0;
				efficiency  = generation / data.id.power;

				$('#generation').text(addThousandsSeperator(generation));
				$('#pv_efficiency').text(efficiency.toFixed(2).toString().replace(".", ","));

		});

	}, inverterInterval);

	setInterval(function () {
		$.getJSON('api/v1/weather').done( function(data) {
			var chart,
				series,

				chart = $('#temperature').highcharts();

				if (chart) {
					series = chart.series[0];
					value  = data.temperature;

					// Explicitly check for null, because 0 evaluates as false
					if (value != null) {
						series.setData([value], true, animation, true);
					} else {
						series.removePoint(0);
					}
				}

		});

	}, weatherInterval);

});
