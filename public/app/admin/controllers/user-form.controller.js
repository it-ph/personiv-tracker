admin
  .controller('userFormController', userFormController)

  userFormController.$inject = ['MaterialDesign', 'User', 'Account', 'formService', 'fab', '$filter'];

  function userFormController(MaterialDesign, User, Account, formService, fab, $filter) {
    var vm = this;

    vm.user = User;
    vm.user.new = {}
    vm.user.new.experiences = [];

    vm.fab = fab;

    vm.checkEmployeeNumber = checkEmployeeNumber;
    vm.checkEmail = checkEmail;
    vm.focusOnForm = focusOnForm;
    vm.cancel = hideForm;
    vm.submit = submit;

    init();

    function hideForm() {
      vm.user.showForm = false;
      vm.user.new = {};
      vm.fab.show = true;
    }

    function focusOnForm() {
      angular.element(document).find('#newUser').addClass('md-input-focused');
      angular.element(document).find('#newUser > input').focus();
    }

    function init() {
      return getAccounts().then(function(response) {
        return vm.accounts = response.data;
      });
    }

    function getAccounts() {
      var query = {
        where: [
          {
            column: 'department_id',
            condition: '=',
            value: vm.user.user.department_id,
          }
        ],
        relationships: ['positions'],
      }

      return Account.enlist(query);
    }

    function checkEmployeeNumber() {
      var query = {
          where: [
            {
              column: 'employee_number',
              condition: '=',
              value: vm.user.new.employee_number,
            },
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
              value: vm.user.new.email,
            },
          ],
          withTrashed: true,
          first: true,
      }

      vm.user.enlist(query)
        .then(function(response){
          vm.duplicateEmail = response.data ? true : false;
        });
    }

    function submit() {
      vm.showErrors = true;
      // check every fields in the form for errors
			var formHasError = formService.validate(vm.form);

      setExperiences();
      convertDatesToString();

			if(formHasError || vm.duplicateEmail || vm.duplicateEmployeeNumber || !vm.user.new.experiences.length) {
				return;
			}
			else{
				vm.busy = true;

				vm.user.store()
          .then(notify)
          .then(getUser)
          .then(hideForm)
          .catch(error);
			}

      function setExperiences() {
        angular.forEach(vm.accounts, function(account){
          if(account.selected)
          {
            angular.forEach(account.positions, function(position){
              if(position.selected)
              {
                var experience = {
                  account_id: account.id,
                  position_id: position.id,
                  date_started: position.date_started,
                }
                vm.user.new.experiences.push(experience);
              }
            });
          }
        });
      }

      function convertDatesToString(){
        angular.forEach(vm.user.new.experiences, function(experience){
          experience.date_started = experience.date_started.toDateString();
        });
      }

      function notify() {
        vm.busy = false;
        MaterialDesign.notify('User created.');
      }

      function getUser() {
        return vm.user.get()
          .then(function(response){
            return vm.user.set('user', response.data);
          });
      }
    }

    function error() {
      vm.busy = false;
      revertDatesToObject();
      MaterialDesign.error();
    }

    function revertDatesToObject(){
      angular.forEach(vm.user.new.experiences, function(experience){
        experience.date_started = new Date(experience.date_started);
      });
    }
  }
