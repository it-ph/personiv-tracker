(function() {
  'use strict';

  angular
    .module('app')
    .controller('experiencesDialogController', experiencesDialogController)

  experiencesDialogController.$inject = ['User', 'Account', 'Experience', 'MaterialDesign', 'formService', '$filter'];

  function experiencesDialogController(User, Account, Experience, MaterialDesign, formService, $filter) {
    var vm = this;

    vm.label = "Positions"
    vm.user = User.user;
    vm.user.experiences = [];
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
            value: vm.user.department_id,
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
            value: vm.user.id,
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

      if(formHasError || vm.duplicateEmail || vm.duplicateEmployeeNumber || !vm.user.experiences.length)
			{
				return;
			}
			else{
				vm.busy = true;
				User.update(vm.user)
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
                vm.user.experiences.push(experience);
              }
            });
          }
        });
      }
    }

    function convertDatesToString(){
      angular.forEach(vm.user.experiences, function(experience){
        experience.date_started = experience.date_started.toDateString();
      });
    }

    function revertDatesToObject(){
      angular.forEach(vm.user.experiences, function(experience){
        experience.date_started = new Date(experience.date_started);
      });
    }

    function error() {
      revertDatesToObject();
      MaterialDesign.reject();
      vm.busy = false;
      vm.error = true;
    }
  }
})();
