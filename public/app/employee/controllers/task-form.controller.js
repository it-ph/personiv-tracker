employee
	.controller('taskFormController', ['MaterialDesign', 'taskFormService', 'formService', 'User', 'Account',  function(MaterialDesign, taskFormService, formService, User, Account){
		var vm = this;

		vm.task = taskFormService;
		vm.account = Account;
		vm.user = User;

		vm.task.new.revision = false;

		// determines the user if he can use batch tasks
		vm.setAccount = function(){
			vm.task.new.account_id = vm.task.new.account.id;

			vm.batchable = vm.task.new.account.batchable;
		}

		// fetch the accounts associated with the user
		vm.accounts = function(){
			var query = {
				where: [
					{
						column: 'department_id',
						condition: '=',
						value: vm.user.user.department_id,
					}
				],
			}

			vm.account.enlist(query)
				.then(function(data){
					vm.account.data = data.data;
				}, function(){
					Helper.failed()
						.then(function(){
							vm.accounts();
						});
				});
		}

		// submit the form
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
						// reset the task object
						vm.task.init();
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}

		/**
		 *
		*/
		vm.init = function(){
			vm.accounts();
		}();
	}]);
