admin
  .controller('projectFormController', projectFormController)

  projectFormController.$inject = ['MaterialDesign', 'User', 'Account', 'Department', 'formService', 'fab', '$filter'];

  function projectFormController(MaterialDesign, User, Account, Department, formService, fab, $filter) {
    var vm = this;

    vm.user = User.user;
    vm.account = {}
    vm.account.batchable = false;
    vm.form = {}
    vm.fab = fab;

    vm.checkDuplicate = checkDuplicate;
    vm.focusOnForm = focusOnForm;
    vm.hideForm = hideForm;
    vm.submit = submit;

    init();

    function init() {
      Department.index()
        .then(function(response) {
          vm.departments = response.data;
        })
        .catch(MaterialDesign.error);
    }

    function hideForm() {
      Account.showForm = false;
      vm.fab.show = true;
    }

    function focusOnForm() {
      angular.element(document).find('#newAccount').addClass('md-input-focused');
      angular.element(document).find('#newAccount > input').focus();
    }

    function checkDuplicate() {
      vm.duplicate = false;

      var request = {
        where: [
          {
            column: 'name',
            condition: '=',
            value: vm.account.name
          },
        ],
        first: true
      }

      $department = {
        column: 'department_id',
        condition: '=',
        value: vm.account.department_id ? vm.account.department_id : vm.user.department_id
      }

      request.where.push($department);

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

			Account.store(vm.account)
        .then(getAccounts)
        .then(hideForm)
        .then(notify)
        .catch(error);

      function notify() {
        vm.busy = false;
        MaterialDesign.notify('Project created.');
      }

      function getAccounts() {
        var query = {
          relationships: ['positions'],
          relationshipCount: ['tasks'],
        }

        if(! vm.user.super_user)
        {
          query.where = [
            {
              column: 'department_id',
              condition: '=',
              value: vm.user.department_id,
            },
          ]
        }

        return Account.enlist(query)
          .then(function(response) {
            return Account.data = response.data;
          });
      }
    }

    function error() {
      vm.busy = false;
      MaterialDesign.error();
    }
  }
