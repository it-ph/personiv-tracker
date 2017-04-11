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