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
				},
				resolve: {
					authentication: ['MaterialDesign', 'User', '$state', function(MaterialDesign, User, $state){
						return User.get()
							.then(function(response){
								User.set('user', response.data);
							}, function(){
								$state.go('page-not-found');
							});
					}],
				},
			})
	}]);

employee
	.factory('taskFormService', ['$http', 'MaterialDesign', 'Task', function($http, MaterialDesign, Task){
		var factory = {}

		// object for new task
		factory.new = {}

		factory.store = function(){
			return $http.post('/task', factory.new);
		}

		factory.update = function(){
			return $http.put('/task/' + factory.data.id, factory.data);
		}

		// set new stored task as current task pinned at top
		factory.setCurrent = function(data){
			Task.formatData(data);
			Task.current = data;
		}

		// object for update
		factory.set = function(data){
			factory.data = data;
		}

		factory.setNumberofPhotos = function(data){
			factory.numberOfPhotos = data;
		}

		factory.changeNumberOfPhotos = function(data){
			if(data.number_of_photos)
			{
				factory.setNumberofPhotos(data.number_of_photos);

				data.number_of_photos = null;
			}
			else{
				data.number_of_photos = factory.numberOfPhotos;
			}
		}

		factory.init = function(){
			factory.data = {};
			factory.new = {};
			factory.numberOfPhotos = null;
		}

		return factory;
	}]);
employee
	.controller('editTaskDialogController', ['MaterialDesign', 'taskFormService', 'formService', 'Account', 'User', 'Experience', '$filter', function(MaterialDesign, taskFormService, formService, Account, User, Experience, $filter){
		var vm = this;

		vm.task = taskFormService;
		vm.account = Account;
		vm.user = User;

		vm.department = vm.user.user.department.name;

		// determines the user if he can use batch tasks
		vm.setAccount = function(id, reset){
			var account = $filter('filter')(vm.account.data, {id:id})[0];

			vm.batchable = account.batchable;

			if(!vm.batchable)
			{
				vm.task.data.number_of_photos = null;
			}

			if(reset)
			{
				vm.task.data.experience_id = null;
			}
			fetchExperiences();
		}

		function fetchExperiences(){
			var query = {
				where: [
					{
						column: 'user_id',
						condition: '=',
						value: vm.user.user.id
					},
					{
						column: 'account_id',
						condition: '=',
						value: vm.task.data.account_id
					},
				],
				relationships: ['position'],
			}

			Experience.enlist(query)
				.then(function(response) {
					vm.experiences = response.data;
				})
				.catch(function(){
					Helper.error();
				})
		}

		// determines the user if he can use batch tasks
		if(vm.task.data.number_of_photos)
		{
			vm.batch = true;
		}

		// fetch the accounts associated with the user
		vm.accounts = function(){
			var query = {
				where: [
					{
						column: 'department_id',
						condition: '=',
						value: vm.user.user.department_id,
					}
				],
			}

			return vm.account.enlist(query)
				.then(function(data){
					return vm.account.data = data.data;
				}, function(){
					Helper.error();
				});
		}

		vm.cancel = function(){
			vm.task.init();
			formService.cancel();
		}

		vm.submit = function(){
			// check form fields for errors, returns true if there are errors
			var formHasError = formService.validate(vm.taskForm);

			if(formHasError)
			{
				return;
			}
			else
			{
				vm.busy = true;

				vm.task.update()
					.then(function(response){
						vm.busy = false;

						MaterialDesign.notify('Changes saved.');

						MaterialDesign.hide();

						vm.task.init();
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}

		vm.init = function(){
			vm.accounts()
				.then(function(){
					vm.setAccount(vm.task.data.account_id, false);
				});
		}();
	}]);

(function() {
  'use strict';

  angular
    .module('app')
    .controller('experiencesDialogController', experiencesDialogController)

  experiencesDialogController.$inject = ['User', 'Account', 'Experience', 'MaterialDesign', 'formService', '$filter'];

  function experiencesDialogController(User, Account, Experience, MaterialDesign, formService, $filter) {
    var vm = this;

    vm.label = "Positions"
    vm.user = User.user;
    vm.user.experiences = [];
    vm.cancel = cancel;
    vm.submit = submit;
    init();

    function init() {
      return getPositions()
        .then(setPositions)
        .then(getExperiences)
        .then(matchExperiences)
        .catch(error);
    }

    function getPositions(){
      var query = {
        where: [
          {
            column: 'department_id',
            condition: '=',
            value: vm.user.department_id,
          }
        ],
        relationships: ['positions'],
      }

      return Account.enlist(query);
    }

    function setPositions(response) {
      vm.accounts = response.data;
    }

    function getExperiences() {
      var query = {
        where: [
          {
            column: 'user_id',
            condition: '=',
            value: vm.user.id,
          },
        ],
        relationships: ['account.positions'],
        relationshipCount: ['tasks'],
      }

      return Experience.enlist(query);
    }

    function matchExperiences(response) {
      angular.forEach(response.data, function(experience){
          var account = $filter('filter')(vm.accounts, {id: experience.account_id});
          if(account)
          {
            var accountIndex = vm.accounts.indexOf(account[0]);
            account[0].selected = true;
            account[0].locked = experience.tasks_count ? true : false;
            vm.accounts[accountIndex] = account[0];

            var position = $filter('filter')(vm.accounts[accountIndex].positions, {id: experience.position_id});

            if(position)
            {
              var positionIndex = vm.accounts[accountIndex].positions.indexOf(position[0]);

              position[0].experience_id = experience.id;
              position[0].date_started = new Date(experience.date_started);
              position[0].selected = true;
              position[0].locked = experience.tasks_count ? true : false;

              vm.accounts[accountIndex].positions[positionIndex] = position[0];
            }
          }
      });
    }

    function cancel() {
      MaterialDesign.cancel();
    }

    function submit()
    {
      vm.showErrors = true;
      // check every fields in the form for errors
			var formHasError = formService.validate(vm.form);

      setExperiences();
      convertDatesToString();

      if(formHasError || vm.duplicateEmail || vm.duplicateEmployeeNumber || !vm.user.experiences.length)
			{
				return;
			}
			else{
				vm.busy = true;
				User.update(vm.user)
					.then(function(){
						vm.busy = false;
						MaterialDesign.notify('Changes saved.');
            MaterialDesign.hide();
					})
          .catch(error);
			}

      function setExperiences() {
        angular.forEach(vm.accounts, function(account){
          if(account.selected)
          {
            angular.forEach(account.positions, function(position){
              if(position.selected)
              {
                var experience = {
                  id: position.experience_id,
                  account_id: account.id,
                  position_id: position.id,
                  date_started: position.date_started,
                }
                vm.user.experiences.push(experience);
              }
            });
          }
        });
      }
    }

    function convertDatesToString(){
      angular.forEach(vm.user.experiences, function(experience){
        experience.date_started = experience.date_started.toDateString();
      });
    }

    function revertDatesToObject(){
      angular.forEach(vm.user.experiences, function(experience){
        experience.date_started = new Date(experience.date_started);
      });
    }

    function error() {
      revertDatesToObject();
      MaterialDesign.reject();
      vm.busy = false;
      vm.error = true;
    }
  }
})();

employee
	.controller('homeContentContainerController', ['MaterialDesign', 'toolbarService', 'Task', 'taskFormService', 'User', function(MaterialDesign, toolbarService, Task, taskFormService, User){
		var vm = this;
		var busy = false;

		vm.toolbar = toolbarService;
		vm.task = Task;
		vm.user = User;

		vm.setCurrent = function(data){
			if(data)
			{
				vm.task.formatData(data);

				if(data.pauses.length)
				{
					vm.paused = true;

					angular.forEach(data.pauses, function(item){
						vm.task.formatData(item);
					});
				}

				vm.task.current = data;
			}
		}

		vm.pause = function(){
			if(busy)
			{
				return serverBusy();
			}
			busy = true;
			vm.task.pause()
				.then(function(response){
					vm.paused = true;

					vm.setCurrent(response.data);

					MaterialDesign.notify('Paused');
					busy = false;
				}, function(){
					busy = false;
					MaterialDesign.error();
				})
		}

		vm.resume = function(){
			if(busy)
			{
				return serverBusy();
			}
			busy = true;
			vm.task.resume()
				.then(function(response){
					vm.paused = false;

					vm.setCurrent(response.data);

					MaterialDesign.notify('Resumed');
					busy = false;
				}, function(){
					busy = false;
					MaterialDesign.error();
				})
		}

		// submit current task as finished
		vm.finish = function(){
			var dialog = {
				title: 'Finish Task',
				message: 'Are you sure you want to finsih this task? This action cannot be undone.',
				ok: 'Finish',
				cancel: 'Cancel',
			}

			MaterialDesign.confirm(dialog)
				.then(function(){
					MaterialDesign.preloader();

					vm.task.finish()
						.then(function(){
							MaterialDesign.hide();

							MaterialDesign.notify('Task completed.');
							// remove the task pinned at top
							vm.task.current = null;

							vm.task.init();

							vm.paused = false;
						}, function(){
							MaterialDesign.error();
						});
				})
		}

		// edit a completed task record
		vm.edit = function(data){
			var dialog = {
				templateUrl: '/app/employee/templates/dialogs/edit-task-dialog.template.html',
				controller: 'editTaskDialogController as vm',
			}

			taskFormService.set(data);

			MaterialDesign.customDialog(dialog)
				.then(function(){
					vm.task.init();
				});
		}

		// delete a completed task record;
		// vm.delete = function(id){
		// 	var dialog = {
		// 		'title': 'Delete Task',
		// 		'message': 'This task will be deleted permanently.',
		// 		'ok': 'Delete',
		// 		'cancel': 'Cancel',
		// 	}

		// 	MaterialDesign.confirm(dialog)
		// 		.then(function(){
		// 			MaterialDesign.preloader();

		// 			vm.task.delete(id)
		// 				.then(function(){
		// 					MaterialDesign.hide();

		// 					MaterialDesign.notify('Task deleted.');

		// 					vm.task.init();
		// 				})
		// 		})
		// }

		// fetch the current task to be pinned at top
		vm.currentTask = function(){
			var query = {
				relationships: ['account', 'experience.position'],
				relationshipsWithConstraints: [
					{
						relationship: 'pauses',
						whereNull: ['ended_at'],
						orderBy: [
							{
								column: 'created_at',
								order: 'desc',
							},
						],
					}
				],
				whereNull: ['ended_at'],
				where: [
					{
						column: 'user_id',
						condition: '=',
						value: vm.user.user.id,
					}
				],
				first: true,
			}

			vm.task.enlist(query)
				.then(function(response){
					vm.setCurrent(response.data);
				}, function(){
					MaterialDesign.failed()
						.then(function(){
							vm.currentTask();
						})
				})
		}

		vm.task.query = {
			relationships: ['account', 'experience.position'],
			whereNotNull: ['ended_at'],
			where: [
				{
					column: 'user_id',
					condition: '=',
					value: vm.user.user.id,
				}
			],
			orderBy: [
				{
					'column': 'created_at',
					'order': 'desc',
				},
			],
			paginate: 20,
		}

		// fetch completed tasks
		vm.completedTasks = function(){
			vm.task.enlist(vm.task.query)
				.then(function(response){
					vm.nextPage = 2;

					vm.pagination = response.data

					vm.task.data = response.data.data;

					// show the data and stops preloader
					vm.show = true;
					vm.isLoading = false;

					// iterate every item to format and push to autocomplete
					if(vm.task.data.length){
						angular.forEach(vm.task.data, function(item){
							vm.task.formatData(item);
							vm.task.setToolbarItems(item);
						});
					}

					// pagination call
					vm.loadNextPage = function(){
						// kills the function if request is busy or pagination reaches last page
						if(vm.busy || (vm.nextPage > vm.pagination.last_page)){
							vm.isLoading = false;
							return;
						}
						// disable pagination call if previous request is still busy.
						vm.busy = true;
						vm.isLoading = true;

						// Calls the next page of pagination.
						vm.task.paginate(vm.task.query, vm.nextPage)
							.then(function(response){
								// sets the next page
								vm.nextPage++;

								// iterate every item to format and push to autocomplete
								angular.forEach(response.data.data, function(item){
									vm.task.formatData(item);
									vm.task.pushItem(item);
									vm.task.setToolbarItems(item);
								});

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

		vm.task.init = function(){
			// shows preloader
			vm.show = false;
			vm.isLoading = true;

			vm.toolbar.clearItems();
			vm.currentTask();
			vm.completedTasks();
		}

		vm.task.init();

		function serverBusy() {
			var alert = {
				title: 'Server Busy',
				message: 'Your request is being processed.',
			}

			MaterialDesign.alert(alert);
		}
	}]);

employee
	.controller('taskFormController', ['MaterialDesign', 'taskFormService', 'formService', 'User', 'Account', 'Experience',  function(MaterialDesign, taskFormService, formService, User, Account, Experience){
		var vm = this;

		vm.task = taskFormService;
		vm.account = Account;
		vm.user = User;

		vm.task.new.revision = false;

		// determines the user if he can use batch tasks
		vm.setAccount = function(){
			vm.task.new.account_id = vm.task.new.account.id;
			vm.batchable = vm.task.new.account.batchable;
			vm.task.new.experience_id = null;
			fetchExperiences();
		}

		function fetchExperiences(){
			var query = {
				where: [
					{
						column: 'user_id',
						condition: '=',
						value: vm.user.user.id
					},
					{
						column: 'account_id',
						condition: '=',
						value: vm.task.new.account_id
					},
				],
				relationships: ['position'],
			}

			Experience.enlist(query)
				.then(function(response) {
					vm.experiences = response.data;
				})
				.catch(function(){
					Helper.failed()
						.then(function(){
							fetchExperiences();
						});
				})
		}

		// fetch the accounts associated with the user
		vm.accounts = function(){
			var query = {
				where: [
					{
						column: 'department_id',
						condition: '=',
						value: vm.user.user.department_id,
					}
				],
			}

			vm.account.enlist(query)
				.then(function(data){
					vm.account.data = data.data;
				}, function(){
					Helper.failed()
						.then(function(){
							vm.accounts();
						});
				});
		}

		// submit the form
		vm.submit = function(){
			// check every fields in the form for errors
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
						// set the new task as current task pinned at top
						vm.task.setCurrent(response.data);
						// reset the task object
						vm.task.init();
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}

		/**
		 *
		*/
		vm.init = function(){
			vm.accounts();
		}();
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