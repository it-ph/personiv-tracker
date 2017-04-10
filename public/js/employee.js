var employee = angular.module('app', ['shared']);
employee
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
						controller: 'homeContentContainerController as vm',
					},
					'toolbar@main': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						controller: 'homeToolbarController as vm',
					},
					'form@main': {
						templateUrl: '/app/employee/templates/content/task-form.template.html',
						controller: 'taskFormController as vm',
					},
					'content@main':{
						templateUrl: '/app/employee/templates/content/home-content.template.html',
					}
				}
			})
	}]);
employee
	.factory('taskFormService', ['$http', 'MaterialDesign', 'Task', function($http, MaterialDesign, Task){
		var factory = {}

		factory.new = {}

		factory.data = []

		factory.store = function(){
			return $http.post('/task', factory.new);
		}

		factory.update = function(data, id){
			return $http.put('/task/' + id, data);
		}

		factory.setCurrent = function(data){
			Task.current = data;
		}

		return factory;
	}]);
employee
	.controller('homeContentContainerController', ['MaterialDesign', 'toolbarService', 'Task', function(MaterialDesign, toolbarService, Task){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.task = Task;

		vm.query = {
			relationships: [
				'user',
			],
			whereNotNullClauses: [
				'ended_at',
			],
			paginate: 20,
		}

		vm.task.enlist(vm.query)
			.then(function(response){
				// vm.task.data = response.data;
			});
	}]);
employee
	.controller('taskFormController', ['MaterialDesign', 'taskFormService', 'formService', function(MaterialDesign, taskFormService, formService){
		var vm = this;

		vm.task = taskFormService;

		vm.submit = function(){
			var formHasError = formService.validate(vm.form);

			if(formHasError)
			{
				return;
			}
			else{
				vm.busy = true;

				vm.task.store()
					.then(function(response){
						vm.busy = false;

						MaterialDesign.notify('Task created.');
						
						vm.task.setCurrent(response.data);
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}
	}]);
employee
	.controller('homeToolbarController', ['MaterialDesign', 'toolbarService', 'Task', function(MaterialDesign, toolbarService, Task){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.toolbar.content = Task;

		vm.toolbar.parentState = null; //string
		vm.toolbar.childState = 'Home'; //string

		vm.toolbar.hideSearchIcon = false; //bool - true if deeper search icon should be hidden
		vm.toolbar.searchAll = true; // bool - true if a deeper search can be executed

		vm.toolbar.options = true; //bool - true if a menu button is needed in the view
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