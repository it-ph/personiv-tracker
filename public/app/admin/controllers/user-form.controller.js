admin
  .controller('userFormController', userFormController)

  userFormController.$inject = ['MaterialDesign', 'User', 'Position', 'formService', 'fab', '$filter'];

  function userFormController(MaterialDesign, User, Position, formService, fab, $filter) {
    var vm = this;

    vm.user = User;
    vm.user.new = {}
    vm.user.new.experiences = [];

    vm.fab = fab;

    vm.checkEmployeeNumber = checkEmployeeNumber;
    vm.checkEmail = checkEmail;
    vm.checkExperiences = checkExperiences;
    vm.focusOnForm = focusOnForm;
    vm.cancel = hideForm;
    vm.submit = submit;

    init();

    function init() {
      return getPositions().then(function(positions){
          angular.forEach(positions, function(item){
              item.position_id = item.id;
          });
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

    function checkExperiences() {
      vm.hasExperience = false;
      angular.forEach(vm.user.new.experiences, function(experience){
        if(experience.selected)
        {
          vm.hasExperience = true;
        }
      });
    }

    function focusOnForm()
    {
      angular.element(document).find('#newUser').addClass('md-input-focused');
      angular.element(document).find('#newUser > input').focus();
    }

    function submit()
    {
      vm.showErrors = true;
      // check every fields in the form for errors
			var formHasError = formService.validate(vm.form);

			if(formHasError || vm.duplicateEmail || vm.duplicateEmployeeNumber || !vm.hasExperience)
			{
				return;
			}
			else{
				vm.busy = true;

        convertDatesToString();

				vm.user.store()
          .then(notify)
          .then(getUser)
          .then(hideForm)
          .catch(error);
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

    function convertDatesToString(){
      angular.forEach(vm.user.new.experiences, function(experience){
        if(experience.selected)
        {
          experience.date_started = experience.date_started.toDateString();
        }
      });
    }

    function revertDatesToObject(){
      angular.forEach(vm.user.new.experiences, function(experience){
        if(experience.selected)
        {
          experience.date_started = new Date(experience.date_started);
        }
      });
    }

    function hideForm() {
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
