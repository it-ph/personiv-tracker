admin
	.controller('dashboardContentContainerController', ['MaterialDesign','toolbarService', 'Task', 'User', function(MaterialDesign, toolbarService, Task, User){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.task = Task;
		vm.user = User;

		var start = new Date();
		var end = new Date();

		start.setHours(0, 0, 0);
		end.setHours(24, 0 ,0);

		var query = {
			where: [
				{
					column: 'immediate_supervisor_id',
					condition: '=',
					value: vm.user.user.id,
				}
			],
			relationshipsWithConstraints: [
				{
					relationship: 'tasks',
					whereBetween : [
						{
							column: 'ended_at',
							start: start.toDateString(),
							end: end.toDateString(),
						},
					]
				}
			],
		}

		vm.config = {
			title: {
		        text: 'DexMedia - ProjectName',
		    },

	        subtitle: {
	        	text: 'April 6, 2017', 
	        },

		    xAxis: {
		    	categories: [
		            'John Doe',
		            'Jane Doe',
		            'Mark Doe',
		            'Marie Doe',
		        ],
		        crosshair: true
		    },

		    yAxis: [
		    	{
			    	min: 0,
			        title: {
			            text: 'Compeleted Tasks',
			        },
			    },
			    {
			    	min: 0,
			        title: {
			            text: 'Hours Worked',
			        },
			        labels: {
				        format: '{value} hrs.',
				    },
				    opposite: true
			    },
			],
		    plotOptions: {
		        column: {
		            dataLabels: {
		                enabled: true
		            },
		            enableMouseTracking: true
		        },
		    },

		    series: [{
		    	name: 'New',
		    	type: 'column',
		        data: [176, 144, 50, 80],
		    },
		    {
		    	name: 'Revision',
		    	type: 'column',
		        data: [71, 29, 20, 33],
		    },
		    {
		    	name: 'Hours Spent',
		    	type: 'spline',
		    	yAxis: 1,
		        data: [7, 7.3, 5, 2.3],
		        tooltip: {
		            valueSuffix: ' hrs.'
		        }
		    }],

			navigation: {
		        buttonOptions: {
		            enabled: true
		        }
		    }		    
		}
	}]);