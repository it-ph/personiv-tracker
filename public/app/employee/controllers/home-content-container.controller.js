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