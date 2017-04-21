admin
	.controller('dashboardContentContainerController', ['MaterialDesign','toolbarService', 'ShiftSchedule', 'Task', 'User', function(MaterialDesign, toolbarService, ShiftSchedule, Task, User){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.task = Task;
		vm.user = User;
		vm.shiftSchedule = ShiftSchedule;

		vm.dashboard = function(){
			console.log('ok');
			vm.task.dashboard(vm.shiftSchedule.data)
				.then(function(response){
					vm.shiftSchedule.toDateObject();

					console.log(Object.values(response.data));	
					// data per project then set data to charts 
				})
		}

		vm.init = function(){
			vm.shiftSchedule.index()
				.then(function(response){
					if(typeof response.data == 'object')
					{
						vm.shiftSchedule.data = response.data;

						vm.shiftSchedule.toDateObject();
						vm.shiftSchedule.toLocaleTimeString();
					}
					else{
						var today = new Date();

						vm.shiftSchedule.data.from = new Date(today.toDateString() + ' 00:00:00');
						vm.shiftSchedule.data.to = new Date(today.toDateString() + ' 23:59:59');

						vm.shiftSchedule.toLocaleTimeString();
					}

					vm.dashboard();
				}, function(){
					MaterialDesign.failed()
						.then(function(){
							vm.init();
						});
				});
		};

		vm.init();

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