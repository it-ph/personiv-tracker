admin
	.controller('downloadDialogController', ['Department', 'User', 'MaterialDesign', 'formService', '$window', function(Department, User, MaterialDesign, formService, $window){
		var vm = this;

		vm.department = 'Department';
		vm.user = 'User';
		vm.label = 'Download';

		vm.data = {};

		vm.init = init;

		function init() {
			return vm.department.index()
				.then(function(response){
					vm.department.data = response.data;
				})
				.catch(function(){
					MaterialDesign.error();
				});
		}

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
			
				$window.open('/task/download/' + vm.data.date_start + '/to/' + vm.data.date_end + '/at/' + vm.data.time_start + '/until/' + vm.data.time_end + '/department/' + vm.data.department_id, '_blank');

				MaterialDesign.hide();
			}
		}

		vm.init();
	}]);