employee
	.controller('taskFormController', ['MaterialDesign', 'taskFormService', 'formService', function(MaterialDesign, taskFormService, formService){
		var vm = this;

		vm.task = taskFormService;

		vm.submit = function(){
			// check every fields in the form for errors
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
						// set the new task as current task pinned at top
						vm.task.setCurrent(response.data);
						// reset the new object
						vm.task.new = {};
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}
	}]);