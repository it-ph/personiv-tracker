var admin = angular.module('app', ['shared']);
admin
	.config(['$stateProvider', function($stateProvider){
		$stateProvider
			.state('main', {
				url: '/',
				views: {
					'': {
						templateUrl: '/app/shared/views/main.view.html',
						controller: 'mainViewController as mainVm',
					},
					'content-container@main': {
						templateUrl: '/app/shared/views/content-container.view.html',
						controller: 'dashboardContentContainerController as vm',
					},
					'toolbar@main': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						controller: 'dashboardToolbarController as vm',
					},
					'content@main':{
						templateUrl: '/app/admin/templates/content/dashboard-content.template.html',
					}
				},
				resolve: {
					authentication: ['MaterialDesign', 'User', '$state', function(MaterialDesign, User, $state){
						return User.get()
							.then(function(data){
								User.set(data.data);
							}, function(){
								$state.go('page-not-found');
							});
					}],
				},
			})
	}]);
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
admin
	.controller('settingsDialogController', ['MaterialDesign', 'ShiftSchedule', 'formService', function(MaterialDesign, ShiftSchedule, formService){
		var vm = this;

		vm.label = 'Settings';

		vm.shiftSchedule = ShiftSchedule;

		vm.cancel = function(){
			formService.cancel();
		}

		vm.submit = function(){
			// check form fields for errors, returns true if there are errors
			var formHasError = formService.validate(vm.form);

			if(formHasError)
			{
				return;
			}
			else
			{
				vm.busy = true;

				vm.shiftSchedule.toLocaleTimeString();

				var error = function(){
					vm.shiftSchedule.toDateObject();

					vm.busy = false;
					MaterialDesign.error();
				}

				if(vm.new)
				{
					vm.shiftSchedule.store()
						.then(function(response){
							vm.busy = false;

							MaterialDesign.notify('Shift schedule saved.');
							
							MaterialDesign.hide();
						}, function(){
							error();
						});
				}
				else{				
					vm.shiftSchedule.update()
						.then(function(response){
							vm.busy = false;

							MaterialDesign.notify('Changes saved.');
							
							MaterialDesign.hide();
						}, function(){
							error();
						});
				}
			}
		}

		vm.init = function(){
			vm.shiftSchedule.index()
				.then(function(response){
					if(response.data)
					{
						vm.shiftSchedule.data = response.data;

						vm.shiftSchedule.toDateObject();
					}
					else{
						vm.new = true;

						vm.shiftSchedule.init();
					}
				}, function(){
					MaterialDesign.error();
				});
		}();
	}]);
admin
	.controller('dashboardToolbarController', ['MaterialDesign', 'toolbarService', 'Task', function(MaterialDesign, toolbarService, Task){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.toolbar.content = Task;

		vm.toolbar.parentState = null; //string
		vm.toolbar.childState = 'Dashboard'; //string

		vm.toolbar.hideSearchIcon = true; //bool - true if deeper search icon should be hidden
		vm.toolbar.searchAll = false; // bool - true if a deeper search can be executed

		vm.toolbar.options = false; //bool - true if a menu button is needed in the view
		vm.toolbar.showInactive = false; //bool - true if user wants to view deleted records

		// Sort options
		vm.sort = [
			{
				'label': 'Recently added',
				'type': 'created_at',
				'sortReverse': false,
			},
		];
	}]);