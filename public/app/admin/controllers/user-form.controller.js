admin
  .controller('userFormController', userFormController)

  userFormController.$inject = ['MaterialDesign', 'User', 'formService', 'fab'];

  function userFormController(MaterialDesign, User, formService, fab) {
    var vm = this;

    vm.user = User;
    vm.fab = fab;

    vm.checkEmployeeNumber = checkEmployeeNumber;
    vm.checkEmail = checkEmail;
    vm.focusOnForm = focusOnForm;
    vm.cancel = hideForm;
    vm.submit = submit;

    function checkEmployeeNumber() {
      var query = {
          where: [
            {
              column: 'employee_number',
              condition: '=',
              value: vm.user.new.employee_number,
            },
          ],
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
              value: vm.user.new.email,
            },
          ],
          first: true,
      }

      vm.user.enlist(query)
        .then(function(response){
          vm.duplicateEmail = response.data ? true : false;
        });
    }

    function focusOnForm()
    {
      angular.element(document).find('#newUser').addClass('md-input-focused');
      angular.element(document).find('#newUser > input').focus();
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

				vm.user.store()
					.then(function(){
						vm.busy = false;
						MaterialDesign.notify('User created.');
					})
          .then(hideForm)
          .then(getUser)
          .catch(error);
			}
    }

    function hideForm() {
      vm.user.showForm = false;
      vm.user.new = {};
      vm.fab.show = true;
    }

    function getUser() {
      vm.user.get()
      .then(function(response){
        vm.user.set('user', response.data);
      });
    }

    function error() {
      vm.busy = false;
      MaterialDesign.error();
    }

  }
