(function(){
  angular
    .module('app')
    .controller('editProjectDialogController', editProjectDialogController);

    editProjectDialogController.inject = ['MaterialDesign', 'User', 'Account', 'Department', 'dataService', 'formService'];

    function editProjectDialogController(MaterialDesign, User, Account, Department, dataService, formService) {
      var vm = this;

      vm.user = User.user;
      vm.cancel = MaterialDesign.cancel;
      vm.checkDuplicate = checkDuplicate;
      vm.label = dataService.get('account').name;
      vm.submit = submit;

      init();

      function error() {
        MaterialDesign.error();
      }

      function checkDuplicate() {
        var query = {
          where: [
            {
              column: 'name',
              condition: '=',
              value: vm.account.name
            },
          ],
          whereNotIn: [
            {
              column: 'id',
              values: [vm.account.id]
            },
          ],
          first: true,
        }

        $department = {
          column: 'department_id',
          condition: '=',
          value: vm.account.department_id ? vm.account.department_id : vm.user.department_id
        }

        request.where.push($department);

        Account.enlist(query)
          .then(duplicateResponse)
          .catch(error);

        function duplicateResponse(response) {
          if(response.data)
          {
            vm.duplicate = true;
          }
        }
      }

      function init() {
        getDepartments()
          .then(getAccount)
          .catch(error);

        function getDepartments() {
          return Department.index()
            .then(function(response){
              return vm.departments = response.data;
            })
        }

        function getAccount() {
          var query = {
            relationships: ['positions'],
            where: [
              {
                column: 'id',
                condition: '=',
                value: dataService.get('account').id,
              }
            ],
            first: true,
          }

          return Account.enlist(query)
            .then(function(response){
              return vm.account = response.data;
            });
        }
      }

      function submit() {
        var formhasError = formService.validate(vm.form);

        if(formhasError || vm.duplicate || vm.busy)
        {
          return;
        }

        vm.busy = true;

        Account.update(vm.account)
          .then(hideForm)
          .catch(showErrorMessage)

        function hideForm() {
          vm.busy = false;
          MaterialDesign.hide();
          MaterialDesign.notify('Changes saved.');
        }

        function showErrorMessage() {
          vm.error = true;
        }
      }
    }
})();
