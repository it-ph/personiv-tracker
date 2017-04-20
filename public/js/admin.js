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
		        text: 'DexMedia',
		    },

	        subtitle: {
	        	text: 'April 6, 2017', 
	        },

		    xAxis: {
		    	type: 'datetime',
		    },

		    yAxis: {
		        title: {
		            text: 'Number of Compeleted Tasks',
		        },
		    },

		    // series: [{
		    // 	name: 'VAR',
		    //     data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2, 129.2],
		    //     pointStart: Date.UTC(2010, 3, 6),
		    //     pointInterval: 1000 * 60 * 60, // 1hour = 1000 ms * 60 sec * 60 mins
		    // },
		    // {
		    // 	name: 'SSG',
		    //     data: [129.2, 106.4, 71.5, 29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 129.2],
		    //     pointStart: Date.UTC(2010, 3, 6),
		    //     pointInterval: 1000 * 60 * 60, // 1hour = 1000 ms * 60 sec * 60 mins
		    // }],

		    series: [{
		    	name: 'John Doe',
		        data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2, 129.2],
		        pointStart: Date.UTC(2010, 3, 6),
		        pointInterval: 1000 * 60 * 60, // 1hour = 1000 ms * 60 sec * 60 mins
		    },
		    {
		    	name: 'Jane Doe',
		        data: [144.0, 176.0, 216.4, 71.5, 106.4, 129.2, 29.9, 135.6, 148.5, 54.4, 194.1, 95.6, 54.4,  148.5, 176.0, 135.6, 216.4, 194.1, 144.0, 95.6,  29.9, 71.5, 106.4, 129.2, 129.2],
		        pointStart: Date.UTC(2010, 3, 6),
		        pointInterval: 1000 * 60 * 60, // 1hour = 1000 ms * 60 sec * 60 mins
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