shared
	.factory('Chart', function() {
		var factory = {}

		factory.data = {
			title: {},
			subtitle : {},
			xAxis: {
				crosshair: true,
			},
			yAxis: [
		    	{
			    	min: 0,
			        title: {
			            text: 'Compeleted Tasks',
			        },
			    },
			    // {
			    // 	min: 0,
			    //     title: {
			    //         text: 'Hours Worked',
			    //     },
			    //     labels: {
				   //      format: '{value} hrs.',
				   //  },
				   //  opposite: true
			    // },
			],
			plotOptions: {
		        column: {
		            dataLabels: {
		                enabled: true
		            },
		            enableMouseTracking: true
		        },
		    },
		    series: [
		    	{
			    	name: 'New',
			    	type: 'column',
			    },
			    {
			    	name: 'Revisions',
			    	type: 'column',
			    },
			    // {
			    // 	name: 'Hours Spent',
			    // 	type: 'spline',
			    // 	yAxis: 1,
			    //     tooltip: {
			    //         valueSuffix: ' hrs.'
			    //     }
			    // },
			],
			navigation: {
		        buttonOptions: {
		            enabled: true
		        }
		    }
		}

		factory.config = function(position){
			factory.data.title.text = position.name;
			// factory.data.subtitle.text = account.range;

			factory.data.xAxis.categories = position.names;

			factory.data.series[0].data = position.new;
			factory.data.series[1].data = position.revisions;
			// factory.data.series[2].data = data.hours_spent;

			return factory.data;
		}

		return factory;
	})
