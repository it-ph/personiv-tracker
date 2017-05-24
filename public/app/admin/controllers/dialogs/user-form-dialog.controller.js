admin
  .controller('userFormDialogController', userFormDialogController)

  userFormController.$inject = ['MaterialDesign', 'User', 'formService'];

  function userFormDialogController(MaterialDesign, User, formService) {
    var vm = this;

    vm.label = 'Edit user';

    vm.user = User;
    vm.edit = vm.user.clone('edit');

    vm.checkEmployeeNumber = checkEmployeeNumber;
    vm.checkEmail = checkEmail;
    vm.cancel = cancel;
    vm.submit = submit;

    function checkEmployeeNumber() {
      var query = {
          where: [
            {
              column: 'employee_number',
              condition: '=',
              value: vm.edit.employee_number,
            },
          ],
          whereNotIn: [
            {
              column: 'id',
              values: [vm.edit.id],
            }
          ],
          withTrashed: true,
          first: true,
      }

      vm.user.enlist(query)
        .then(function(response){
          vm.duplicateEmployeeNumber = response.data ? true : false;
        });
    }

    function checkEmail() {
      var query = {
          where: [
            {
              column: 'email',
              condition: '=',
              value: vm.edit.email,
            },
          ],
          whereNotIn: [
            {
              column: 'id',
              values: [vm.edit.id],
            }
          ],
          withTrashed: true,
          first: true,
      }

      vm.user.enlist(query)
        .then(function(response){
          vm.duplicateEmail = response.data ? true : false;
        });
    }

    function cancel() {
      MaterialDesign.cancel();
    }

    function submit()
    {
      // check every fields in the form for errors
			var formHasError = formService.validate(vm.form);

			if(formHasError || vm.duplicateEmail || vm.duplicateEmployeeNumber)
			{
				return;
			}
			else{
				vm.busy = true;

				vm.user.update(vm.edit)
					.then(function(){
						vm.busy = false;
						MaterialDesign.notify('Changes saved.');
            MaterialDesign.hide();
					})
          .catch(error);
			}
    }

    function error() {
      vm.busy = false;
      vm.error = true;
    }

  }
