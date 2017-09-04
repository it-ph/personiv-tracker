employee
	.controller('editTaskDialogController', ['MaterialDesign', 'taskFormService', 'formService', 'Account', 'User', 'Experience', '$filter', function(MaterialDesign, taskFormService, formService, Account, User, Experience, $filter){
		var vm = this;

		vm.task = taskFormService;
		vm.account = Account;
		vm.user = User;

		vm.department = vm.user.user.department.name;

		// determines the user if he can use batch tasks
		vm.setAccount = function(id, reset){
			var account = $filter('filter')(vm.account.data, {id:id})[0];

			vm.batchable = account.batchable;

			if(!vm.batchable)
			{
				vm.task.data.number_of_photos = null;
			}

			if(reset)
			{
				vm.task.data.experience_id = null;
			}
			fetchExperiences();
		}

		function fetchExperiences(){
			var query = {
				where: [
					{
						column: 'user_id',
						condition: '=',
						value: vm.user.user.id
					},
					{
						column: 'account_id',
						condition: '=',
						value: vm.task.data.account_id
					},
				],
				relationships: ['position'],
			}

			Experience.enlist(query)
				.then(function(response) {
					vm.experiences = response.data;
				})
				.catch(function(){
					Helper.error();
				})
		}

		// determines the user if he can use batch tasks
		if(vm.task.data.number_of_photos)
		{
			vm.batch = true;
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

			return vm.account.enlist(query)
				.then(function(data){
					return vm.account.data = data.data;
				}, function(){
					Helper.error();
				});
		}

		vm.cancel = function(){
			vm.task.init();
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

						vm.task.init();
					}, function(){
						vm.busy = false;
						MaterialDesign.error();
					})
			}
		}

		vm.init = function(){
			vm.accounts()
				.then(function(){
					vm.setAccount(vm.task.data.account_id, false);
				});
		}();
	}]);
