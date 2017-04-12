employee
	.controller('editTaskDialogController', ['MaterialDesign', 'taskFormService', 'formService', function(MaterialDesign, taskFormService, formService){
		var vm = this;

		vm.task = taskFormService;

		vm.cancel = function(){
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
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}
	}]);