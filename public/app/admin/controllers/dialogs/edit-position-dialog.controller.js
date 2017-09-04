(function(){
  angular
    .module('app')
    .controller('editPositionDialogController', editPositionDialogController);

    editPositionDialogController.inject = ['MaterialDesign', 'User', 'Account', 'Position', 'dataService', 'formService'];

    function editPositionDialogController(MaterialDesign, User, Account, Position, dataService, formService) {
      var vm = this;

      vm.account = dataService.get('account');
      vm.user = User.user;

      vm.cancel = MaterialDesign.cancel;
      vm.checkDuplicate = checkDuplicate;
      vm.label = dataService.get('position').name;
      vm.submit = submit;

      init();

      function error() {
        MaterialDesign.error();
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

      function init() {
        var query = {
          where: [
            {
              column: 'id',
              condition: '=',
              value: dataService.get('position').id,
            }
          ],
          first: true,
        }

        return Position.enlist(query)
          .then(function(response){
            vm.position = response.data;
            vm.position.account_id = vm.account.id;
            console.log(vm.position);
            return vm.position;
          });
      }

      function submit() {
        var formhasError = formService.validate(vm.form);

        if(formhasError || vm.duplicate || vm.busy)
        {
          return;
        }

        vm.busy = true;

        Position.update(vm.position)
          .then(hideForm)
          .catch(showErrorMessage)

        function hideForm() {
          vm.busy = false;
          MaterialDesign.hide();
          MaterialDesign.notify('Changes saved.');
        }

        function showErrorMessage() {
          vm.error = true;
          vm.busy = false;
        }
      }
    }
})();
