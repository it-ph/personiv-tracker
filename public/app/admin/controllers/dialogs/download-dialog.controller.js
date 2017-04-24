admin
	.controller('downloadDialogController', ['MaterialDesign', 'ShiftSchedule', 'formService', '$http', function(MaterialDesign, ShiftSchedule, formService, $http){
		var vm = this;

		vm.label = 'Download';

		vm.data = {};

		vm.cancel = function(){
			formService.cancel();
		}

		vm.timeFormat = function(time){
			if(time.getMinutes() < 30)
			{
				time.setMinutes(30);
			}
			else if(time.getMinutes() > 30)
			{
				time.setHours(time.getHours() + 1);
				time.setMinutes(0);
			}
			
			time.setSeconds(0);

			return time;
		}

		vm.toLocaleTimeString = function(){
			vm.data.time_start = vm.data.time_start.toLocaleTimeString();
			vm.data.time_end = vm.data.time_end.toLocaleTimeString();
		}

		vm.toDateObject = function(){
			var today = new Date();

			vm.data.time_start = new Date(today.toDateString() + ' ' + vm.data.time_start);
			vm.data.time_end = new Date(today.toDateString() + ' ' + vm.data.time_end);
		}

		vm.data.date_start = new Date();
		vm.data.date_end = new Date();

		vm.data.time_start = vm.timeFormat(new Date());
		vm.data.time_end = vm.timeFormat(new Date());

		
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

				var error = function(){
					vm.toDateObject();

					vm.busy = false;
					vm.error = true;
				}
			
				$http.post('/task/download', vm.data)
					.then(function(response){
						vm.busy = false;

						MaterialDesign.notify('Changes saved.');
						
						MaterialDesign.hide();
					}, function(){
						error();
					});
			}
		}
	}]);