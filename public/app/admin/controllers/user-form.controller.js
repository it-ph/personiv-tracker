admin
  .controller('userFormController', userFormController)

  userFormController.$inject = ['MaterialDesign', 'User', 'Position', 'Experience', 'formService', 'fab', '$filter'];

  function userFormController(MaterialDesign, User, Position, Experience, formService, fab, $filter) {
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

    function init() {
      return getPositions().then(function(positions){
          angular.copy(positions, vm.user.new.experiences);
      })
    }

    function getPositions(){
      var query = {
        whereHas : [
          {
            relationship: 'departments',
            where: [
              {
                column: 'department_id',
                condition: '=',
                value: vm.user.user.department_id
              }
            ]
          }
        ]
      }

      return Position.enlist(query)
        .then(function(response){
          return vm.positions = response.data;
        })
        .catch(error);
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

        convertDatesToString();

				vm.user.store()
					.then(storeExperiences)
          .then(getUser)
          .then(hideForm)
          .catch(error);
			}

      function storeExperiences(response){
        vm.user.new.id = response.data;
        return Experience.store(vm.user.new)
      }

      function getUser() {
        return vm.user.get()
          .then(function(response){
            return vm.user.set('user', response.data);
          });
      }
    }

    function convertDatesToString(){
      angular.forEach(vm.user.new.experiences, function(experience){
        experience.date_started = experience.date_started.toDateString();
      });
    }

    function revertDatesToObject(){
      angular.forEach(vm.user.new.experiences, function(experience){
        experience.date_started = new Date(experience.date_started);
      });
    }

    function hideForm() {
      vm.busy = false;
      MaterialDesign.notify('User created.');
      vm.user.showForm = false;
      vm.user.new = {};
      vm.fab.show = true;
    }

    function error() {
      vm.busy = false;
      revertDatesToObject();
      MaterialDesign.error();
    }
  }
