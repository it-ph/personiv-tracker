admin
  .controller('positionFormController', positionFormController)

  positionFormController.$inject = ['MaterialDesign', 'User', 'Account', 'Position', 'formService', 'dataService', 'fab'];

  function positionFormController(MaterialDesign, User, Account, Position, formService, dataService, fab) {
    var vm = this;

    vm.account = dataService.get('account');
    vm.user = User.user;
    vm.position = {}
    vm.position.account_id = vm.account.id;
    vm.form = {}
    vm.fab = fab;

    vm.checkDuplicate = checkDuplicate;
    vm.focusOnForm = focusOnForm;
    vm.hideForm = hideForm;
    vm.submit = submit;

    function hideForm() {
      Position.showForm = false;
      vm.fab.show = true;
    }

    function focusOnForm() {
      angular.element(document).find('#newPosition').addClass('md-input-focused');
      angular.element(document).find('#newPosition > input').focus();
    }

    function checkDuplicate() {
      vm.duplicate = false;

      var request = {
        whereHas: [
          {
            relationship: 'positions',
            where: [
                {
                  column: 'name',
                  condition: '=',
                  value: vm.position.name
                },
            ]
          },
        ],
        where: [
          {
            column: 'id',
            condition: '=',
            value: vm.account.id
          },
        ],
        first: true
      }

      Account.enlist(request)
        .then(duplicateResponse)

        function duplicateResponse(response) {
          if(response.data)
          {
            vm.duplicate = true;
          }
        }
    }

    function submit() {
      // check every fields in the form for errors
			var formHasError = formService.validate(vm.form);

			if(formHasError || vm.duplicate || vm.busy) {
				return;
			}

			vm.busy = true;

			Position.store(vm.position)
        .then(getPositions)
        .then(hideForm)
        .then(notify)
        .catch(error);

      function notify() {
        vm.busy = false;
        MaterialDesign.notify('Project created.');
      }

      function getPositions() {
        var query = {
          relationshipCountWithConstraints: [
            {
              relationship: 'experiences',
              where: [
                {
                  column: 'account_id',
                  condition: '=',
                  value: vm.account.id
                },
              ]
            }
          ],
          whereHas: [
            {
              relationship: 'accounts',
              where: [
                {
                  column: 'account_id',
                  condition: '=',
                  value: vm.account.id
                },
              ]
            },
          ],
        }

        return Position.enlist(query)
          .then(function(response) {
            return Position.data = response.data;
          });
      }
    }

    function error() {
      vm.busy = false;
      MaterialDesign.error();
    }
  }
