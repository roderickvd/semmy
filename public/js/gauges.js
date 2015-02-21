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
			},
			wrap: false
		}
	}
};
