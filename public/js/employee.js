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

		factory.store = function(){
			return $http.post('/task', factory.new);
		}

		factory.update = function(data, id){
			return $http.put('/task/' + id, data);
		}

		factory.setCurrent = function(data){
			Task.formatData(data);
			Task.current = data;
		}

		return factory;
	}]);
employee
	.controller('homeContentContainerController', ['MaterialDesign', 'toolbarService', 'Task', function(MaterialDesign, toolbarService, Task){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.task = Task;

		vm.currentTask = function(){
			var query = {
				relationships: ['user'],
				whereNull: ['ended_at'],
				first: true,
			}

			vm.task.enlist(query)
				.then(function(response){
					if(response.data)
					{
						vm.task.formatData(response.data);
						vm.task.current = response.data;

						console.log(vm.task.current);
					}
				}, function(){
					MaterialDesign.failed()
						.then(function(){
							vm.currentTask();
						})
				})
		}

		vm.completedTasks = function(){
			var query = {
				relationships: ['user'],
				whereNotNull: ['ended_at'],
				orderBy: [
					{
						'column': 'created_at',
						'order': 'desc',
					},
				],
				paginate: 20,
			}

			vm.task.enlist(query)
				.then(function(response){
					vm.nextPage = 2;
					
					vm.pagination = response.data

					vm.task.data = response.data.data;

					vm.show = true;

					if(vm.task.data.length){
						angular.forEach(vm.task.data, function(item){
							vm.task.formatData(item);
							vm.task.setToolbarItems(item);
						});
					}

					vm.loadNextPage = function(){
						// kills the function if request is busy or pagination reaches last page
						if(vm.busy || (vm.nextPage > vm.pagination.last_page)){
							vm.isLoading = false;
							return;
						}
						// sets to true to disable pagination call if still busy.
						vm.busy = true;
						vm.isLoading = true;

						// Calls the next page of pagination.
						vm.task.paginate(vm.query, vm.nextPage)
							.then(function(response){
								// sets the next page
								vm.nextPage++;

								vm.task.formatData();
								vm.task.setToolbarItems(vm.task.data);
								
								// Enables again the pagination call for next call.
								vm.busy = false;
								vm.isLoading = false;	
							}, function(){
								vm.loadNextPage();
							});
					}
				}, function(){
					MaterialDesign.failed()
						.then(function(){
							vm.completedTasks();
						})
				});
		}

		vm.finish = function(){
			MaterialDesign.preloader();

			vm.task.finish()
				.then(function(){
					MaterialDesign.hide();
					MaterialDesign.notify('Task completed.');

					vm.task.current = null;

					vm.init();
				}, function(){
					MaterialDesign.error();
				});
		}

		vm.init = function(){
			vm.toolbar.clearItems();
			vm.currentTask();
			vm.completedTasks();
		}

		vm.init();
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

						vm.task.new = {};
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