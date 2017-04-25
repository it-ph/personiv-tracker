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
	.controller('dashboardContentContainerController', ['MaterialDesign','toolbarService', 'ShiftSchedule', 'Task', 'User', 'Chart', function(MaterialDesign, toolbarService, ShiftSchedule, Task, User, Chart){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.task = Task;
		vm.user = User;
		vm.shiftSchedule = ShiftSchedule;
		vm.chart = Chart;

		vm.dashboard = function(){
			vm.task.dashboard()
				.then(function(response){
					vm.shiftSchedule.toDateObject();

					// data per project then set data to charts
					vm.task.data = response.data;
				})
		}

		vm.init = function(){
			vm.dashboard();
		};

		vm.init();
	}]);
admin
	.controller('calendarDialogController', ['MaterialDesign', 'ShiftSchedule', 'formService', 'Task', function(MaterialDesign, ShiftSchedule, formService, Task){
		var vm = this;

		vm.label = 'Go to date';

		vm.data = {}

		vm.cancel = function(){
			formService.cancel();
		}

		vm.toLocaleTimeString = function(){
			vm.data.timeStart = vm.data.timeStart.toLocaleTimeString();
			vm.data.timeEnd = vm.data.timeEnd.toLocaleTimeString();
		}

		vm.toDateString = function(){
			vm.data.dateShift = vm.data.dateShift.toDateString();
		}

		vm.toDateObject = function(){
			var today = new Date();

			vm.data.timeStart = new Date(today.toDateString() + ' ' + vm.data.timeStart);
			vm.data.timeEnd = new Date(today.toDateString() + ' ' + vm.data.timeEnd);
			vm.data.dateShift = new Date(vm.data.dateShift);
		}

		vm.data.dateShift = new Date();

		vm.data.timeStart = formService.timeFormat(new Date());
		vm.data.timeEnd = formService.timeFormat(new Date());

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

				vm.toLocaleTimeString();
				vm.toDateString();
			
				Task.dashboard(vm.data)
					.then(function(response){
						Task.data = response.data;

						MaterialDesign.hide();
					}, function(){
						MaterialDesign.error();
					});
			}
		}
	}]);
admin
	.controller('downloadDialogController', ['MaterialDesign', 'ShiftSchedule', 'formService', '$window', function(MaterialDesign, ShiftSchedule, formService, $window){
		var vm = this;

		vm.label = 'Download';

		vm.data = {};

		vm.cancel = function(){
			formService.cancel();
		}

		vm.toLocaleTimeString = function(){
			vm.data.time_start = vm.data.time_start.toLocaleTimeString();
			vm.data.time_end = vm.data.time_end.toLocaleTimeString();
		}

		vm.toDateString = function(){
			vm.data.date_start = vm.data.date_start.toDateString();
			vm.data.date_end = vm.data.date_end.toDateString();
		}

		vm.toDateObject = function(){
			var today = new Date();

			vm.data.time_start = new Date(today.toDateString() + ' ' + vm.data.time_start);
			vm.data.time_end = new Date(today.toDateString() + ' ' + vm.data.time_end);
			vm.data.date_start = new Date(vm.data.date_start);
			vm.data.date_end = new Date(vm.data.date_end);
		}

		vm.data.date_start = new Date();
		vm.data.date_end = new Date();

		vm.data.time_start = formService.timeFormat(new Date());
		vm.data.time_end = formService.timeFormat(new Date());

		
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

				vm.toLocaleTimeString();
				vm.toDateString();
			
				$window.open('/task/download/' + vm.data.date_start + '/to/' + vm.data.date_end + '/at/' + vm.data.time_start + '/until/' + vm.data.time_end, '_blank');

				MaterialDesign.hide();
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