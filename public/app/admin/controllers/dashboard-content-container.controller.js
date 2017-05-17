admin
	.controller('dashboardContentContainerController', ['MaterialDesign','toolbarService', 'ShiftSchedule', 'Task', 'User', 'Chart', function(MaterialDesign, toolbarService, ShiftSchedule, Task, User, Chart){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.task = Task;
		vm.user = User;
		vm.chart = Chart;

		vm.dashboard = dashboard;
		vm.init = init;

		vm.init();

		function dashboard(){
			return vm.task.dashboard()
				.then(function(response){
					vm.isLoading = false;
					// data per project then set data to charts
					vm.task.data = response.data;

					if(vm.task.data.length)
					{
						angular.forEach(vm.task.data, function(item){
							setToolbarItem(item);
						});
					}

					return vm.task.data;
				})
				.catch(error);
		}

		function setToolbarItem(item)
		{
			var entry = {}

			entry.display = item.name;

			toolbarService.items.push(entry);
		}


		function error(){
			return MaterialDesign.failed()
				.then(function(){
					dashboard();
				})
				.catch(error);
		}

		function init (){
			vm.dashboard();
			vm.isLoading = true;
		};
	}]);