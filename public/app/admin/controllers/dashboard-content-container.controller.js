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