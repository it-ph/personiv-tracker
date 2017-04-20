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
			chart: {
		        type: 'column'
		    },

			title: {
		        text: 'DexMedia',
		    },

	        subtitle: {
	        	text: 'April 6, 2017', 
	        },

		    xAxis: {
		    	categories: [
		            'John Doe',
		            'Jane Doe',
		        ],
		        crosshair: true
		    },

		    yAxis: {
		    	min: 0,
		        title: {
		            text: 'Number of Compeleted Tasks',
		        },
		    },
		    plotOptions: {
		        column: {
		            dataLabels: {
		                enabled: true
		            },
		            enableMouseTracking: true
		        }
		    },

		    series: [{
		    	name: 'New',
		        data: [176, 144],
		    },
		    {
		    	name: 'Revision',
		        data: [71, 29],
		    },
		    {
		    	name: 'Hours Spent',
		        data: [7, 7.3],
		    }],

			navigation: {
		        buttonOptions: {
		            enabled: true
		        }
		    }		    
		}
	}]);