admin
  .controller('editUserFormDialogController', editUserFormDialogController)

  userFormController.$inject = ['MaterialDesign', 'User', 'Account', 'Experience', 'formService', '$filter'];

  function editUserFormDialogController(MaterialDesign, User, Account, Experience, formService, $filter) {
    var vm = this;

    vm.label = 'Edit user';

    vm.user = User;
    vm.edit = vm.user.clone('edit');
    vm.edit.experiences = [];

    vm.checkEmployeeNumber = checkEmployeeNumber;
    vm.checkEmail = checkEmail;
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

    function setPositions(response) {
      vm.accounts = response.data;
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
        relationships: ['account.positions'],
      }

      return Experience.enlist(query);
    }

    function matchExperiences(response) {
      angular.forEach(response.data, function(experience){
          var account = $filter('filter')(vm.accounts, {id: experience.account_id});

          if(account)
          {
            var accountIndex = vm.accounts.indexOf(account[0]);
            account[0].selected = true;
            vm.accounts[accountIndex] = account[0];

            var position = $filter('filter')(vm.accounts[accountIndex].positions, {id: experience.position_id});

            if(position)
            {
              var positionIndex = vm.accounts[accountIndex].positions.indexOf(position[0]);
              position[0].date_started = new Date(experience.date_started);
              position[0].selected = true;
              vm.accounts[accountIndex].positions[positionIndex] = position[0];
            }
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

    function cancel() {
      MaterialDesign.cancel();
    }

    function submit()
    {
      vm.showErrors = true;
      // check every fields in the form for errors
			var formHasError = formService.validate(vm.form);

      setExperiences();
      convertDatesToString();

      if(formHasError || vm.duplicateEmail || vm.duplicateEmployeeNumber || !vm.edit.experiences.length)
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
                vm.edit.experiences.push(experience);
              }
            });
          }
        });
      }
    }

    function convertDatesToString(){
      angular.forEach(vm.edit.experiences, function(experience){
        experience.date_started = experience.date_started.toDateString();
      });
    }

    function revertDatesToObject(){
      angular.forEach(vm.edit.experiences, function(experience){
        experience.date_started = new Date(experience.date_started);
      });
    }

    function error() {
      MaterialDesign.reject();
      vm.busy = false;
      vm.error = true;
    }

  }
