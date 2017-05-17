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

		factory.config = function(data){
			factory.data.title.text = data.name;
			factory.data.subtitle.text = data.range;

			factory.data.xAxis.categories = data.categories;

			factory.data.series[0].data = data.new;
			factory.data.series[1].data = data.revisions;
			// factory.data.series[2].data = data.hours_spent;

			return factory.data;
		}

		return factory;
	})