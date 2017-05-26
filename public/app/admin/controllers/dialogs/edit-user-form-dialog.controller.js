admin
  .controller('editUserFormDialogController', editUserFormDialogController)

  userFormController.$inject = ['MaterialDesign', 'User', 'Position', 'Experience', 'formService', '$filter'];

  function editUserFormDialogController(MaterialDesign, User, Position, Experience, formService, $filter) {
    var vm = this;

    vm.label = 'Edit user';

    vm.user = User;
    vm.edit = vm.user.clone('edit');
    vm.edit.experiences = [];

    vm.checkEmployeeNumber = checkEmployeeNumber;
    vm.checkEmail = checkEmail;
    vm.checkExperiences = checkExperiences;
    vm.cancel = cancel;
    vm.submit = submit;
    init();

    function init() {
      return getPositions()
        .then(setPositions)
        .then(getExperiences)
        .then(matchExperiences)
        .catch(error);
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
              },
            ],
          },
        ]
      }

      return Position.enlist(query)
    }

    function setPositions(response) {
      vm.positions = response.data;
    }

    function getExperiences() {
      var query = {
        where: [
          {
            column: 'user_id',
            condition: '=',
            value: vm.edit.id,
          },
        ],
        relationships: ['position'],
      }

      return Experience.enlist(query);
    }

    function matchExperiences(response) {
      angular.copy(vm.positions, vm.edit.experiences);

      angular.forEach(response.data, function(experience){
          experience.date_started = new Date(experience.date_started);
          experience.selected = true;

          var position = $filter('filter')(vm.positions, {id: experience.position_id});

          if(position)
          {
            var index = vm.positions.indexOf(position[0]);
            vm.edit.experiences[index] = experience;
          }
      });
    }

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

    function checkExperiences() {
      vm.hasExperience = false;
      angular.forEach(vm.edit.experiences, function(experience){
        if(experience.selected)
        {
          vm.hasExperience = true;
        }
      });
    }

    function cancel() {
      MaterialDesign.cancel();
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

				vm.user.update(vm.edit)
					.then(function(){
						vm.busy = false;
						MaterialDesign.notify('Changes saved.');
            MaterialDesign.hide();
					})
          .catch(error);
			}
    }

    function convertDatesToString(){
      angular.forEach(vm.edit.experiences, function(experience){
        if(experience.selected)
        {
          experience.date_started = experience.date_started.toDateString();
        }
      });
    }

    function revertDatesToObject(){
      angular.forEach(vm.edit.experiences, function(experience){
        if(experience.selected)
        {
          experience.date_started = new Date(experience.date_started);
        }
      });
    }

    function error() {
      MaterialDesign.reject();
      vm.busy = false;
      vm.error = true;
    }

  }
