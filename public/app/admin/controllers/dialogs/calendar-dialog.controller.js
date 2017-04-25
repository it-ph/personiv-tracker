admin
	.controller('calendarDialogController', ['MaterialDesign', 'ShiftSchedule', 'formService', 'Task', function(MaterialDesign, ShiftSchedule, formService, Task){
		var vm = this;

		vm.label = 'Go to date';

		vm.data = {}

		vm.cancel = function(){
			formService.cancel();
		}

		vm.toLocaleTimeString = function(){
			vm.data.timeStart = vm.data.timeStart.toLocaleTimeString();
			vm.data.timeEnd = vm.data.timeEnd.toLocaleTimeString();
		}

		vm.toDateString = function(){
			vm.data.dateShift = vm.data.dateShift.toDateString();
		}

		vm.toDateObject = function(){
			var today = new Date();

			vm.data.timeStart = new Date(today.toDateString() + ' ' + vm.data.timeStart);
			vm.data.timeEnd = new Date(today.toDateString() + ' ' + vm.data.timeEnd);
			vm.data.dateShift = new Date(vm.data.dateShift);
		}

		vm.data.dateShift = new Date();

		vm.data.timeStart = formService.timeFormat(new Date());
		vm.data.timeEnd = formService.timeFormat(new Date());

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
			
				Task.dashboard(vm.data)
					.then(function(response){
						Task.data = response.data;

						MaterialDesign.hide();
					}, function(){
						MaterialDesign.error();
					});
			}
		}
	}]);