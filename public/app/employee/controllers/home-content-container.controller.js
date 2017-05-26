employee
	.controller('homeContentContainerController', ['MaterialDesign', 'toolbarService', 'Task', 'taskFormService', 'User', function(MaterialDesign, toolbarService, Task, taskFormService, User){
		var vm = this;

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
			vm.task.pause()
				.then(function(response){
					vm.paused = true;

					vm.setCurrent(response.data);

					MaterialDesign.notify('Paused');
				}, function(){
					MaterialDesign.error();
				})
		}

		vm.resume = function(){
			vm.task.resume()
				.then(function(response){
					vm.paused = false;

					vm.setCurrent(response.data);

					MaterialDesign.notify('Resumed');
				}, function(){
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
	}]);
