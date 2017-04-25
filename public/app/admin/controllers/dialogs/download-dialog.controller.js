admin
	.controller('downloadDialogController', ['MaterialDesign', 'ShiftSchedule', 'formService', '$window', function(MaterialDesign, ShiftSchedule, formService, $window){
		var vm = this;

		vm.label = 'Download';

		vm.data = {};

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
			
				$window.open('/task/download/' + vm.data.date_start + '/to/' + vm.data.date_end + '/at/' + vm.data.time_start + '/until/' + vm.data.time_end, '_blank');

				MaterialDesign.hide();
			}
		}
	}]);