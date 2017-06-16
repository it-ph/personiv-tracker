(function() {
  angular
    .module('app')
    .controller('projectsContentContainerController', projectsContentContainerController)

    projectsContentContainerController.$inject = ['User', 'Account', 'MaterialDesign', 'dataService', 'fab'];

    function projectsContentContainerController(User, Account, MaterialDesign, dataService, fab) {
      var vm = this;

      vm.account = Account;
      vm.user = User.user;
      vm.view = view;
      vm.edit = edit;
      vm.remove = remove;

      vm.fab = fab;
      vm.fab.icon = 'mdi-plus';
      vm.fab.label = 'Project';
      vm.fab.show = true;
      vm.fab.action = showForm;

      init();

      function error() {
        MaterialDesign.error();
      }

      function showForm() {
        vm.account.showForm = true;
        vm.fab.show = false;
      }

      function init() {
        vm.showList = false;
        
        return getAccounts()
          .then(collectAccounts, error)
          .then(showList)

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

            return Account.enlist(query);
          }

          function collectAccounts(response) {
            vm.account.data = response.data;
          }

          function showList() {
            vm.showList = true;
          }
      }

      function view(account) {

      }

      function edit(account) {
        dataService.set('account', account);

        var dialog = {
          controller: 'editProjectDialogController as vm',
          templateUrl: '/app/admin/templates/dialogs/edit-project-dialog.template.html',
        }

        MaterialDesign.customDialog(dialog)
          .then(init);
      }

      function remove(account) {
        var dialog = {
          title: 'Delete project',
          message: 'Are you sure you want to delete this project?',
          ok: 'Delete',
          cancel: 'Cancel',
        }

        MaterialDesign.confirm(dialog)
          .then(deleteRequest, error)
          .then(applyChanges);

        function deleteRequest() {
          return Account.delete(account.id);
        }

        function applyChanges() {
          MaterialDesign.notify('Project deleted.');
          init();
        }
      }
    }
})();
