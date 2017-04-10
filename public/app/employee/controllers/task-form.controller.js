employee
	.controller('taskFormController', ['MaterialDesign', 'taskFormService', 'formService', function(MaterialDesign, taskFormService, formService){
		var vm = this;

		vm.task = taskFormService;

		vm.submit = function(){
			var formHasError = formService.validate(vm.form);

			if(formHasError)
			{
				return;
			}
			else{
				vm.busy = true;

				vm.task.store()
					.then(function(response){
						vm.busy = false;

						MaterialDesign.notify('Task created.');
						
						vm.task.setCurrent(response.data);
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}
	}]);