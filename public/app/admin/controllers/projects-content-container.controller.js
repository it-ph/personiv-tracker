(function() {
  angular
    .module('app')
    .controller('projectsContentContainerController', projectsContentContainerController)

    projectsContentContainerController.$inject = ['User', 'Account', 'MaterialDesign', 'dataService', 'toolbarService', 'fab', '$state',];

    function projectsContentContainerController(User, Account, MaterialDesign, dataService, toolbarService, fab, $state) {
      var vm = this;

      vm.toolbar = toolbarService;
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
          .then(setAutoComplete)
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

          function setAutoComplete() {
            vm.toolbar.clearItems();

            angular.forEach(vm.account.data, function(account){
              var item = {display: account.name}
              vm.toolbar.items.push(item);
            });
          }

          function showList() {
            vm.showList = true;
          }
      }

      function view(account) {
        $state.go('main.manage-positions', {accountId: account.id});
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
          .then(deleteRequest)
          .then(applyChanges);

        function deleteRequest() {
          return Account.delete(account.id)
            .catch(function() {
              MaterialDesign.reject();
              MaterialDesign.error();
            });
        }

        function applyChanges() {
          MaterialDesign.notify('Project deleted.');
          init();
        }
      }
    }
})();
