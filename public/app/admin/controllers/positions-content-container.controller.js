(function() {
  angular
    .module('app')
    .controller('positionsContentContainerController', positionsContentContainerController)

    positionsContentContainerController.$inject = ['User', 'Position', 'MaterialDesign', 'dataService', 'toolbarService', 'fab',];

    function positionsContentContainerController(User, Position, MaterialDesign, dataService, toolbarService, fab) {
      var vm = this;

      vm.toolbar = toolbarService;
      vm.account = dataService.get('account');
      vm.position = Position;
      vm.user = User.user;
      vm.view = view;
      vm.edit = edit;
      vm.remove = remove;

      vm.fab = fab;
      vm.fab.icon = 'mdi-plus';
      vm.fab.label = 'Position';
      vm.fab.show = true;
      vm.fab.action = showForm;

      init();

      function error() {
        MaterialDesign.error();
      }

      function showForm() {
        vm.position.showForm = true;
        vm.fab.show = false;
      }

      function init() {
        vm.showList = false;

        return getPositions()
          .then(collectPositions, error)
          .then(setAutoComplete)
          .then(showList)

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

            return Position.enlist(query);
          }

          function collectPositions(response) {
            vm.position.data = response.data;
          }

          function setAutoComplete() {
            vm.toolbar.clearItems();

            angular.forEach(vm.position.data, function(position){
              var item = {display: position.name}
              vm.toolbar.items.push(item);
            });
          }

          function showList() {
            vm.showList = true;
          }
      }

      function view(position) {
        // $state.go('manage-positions', {accountId: account.id});
      }

      function edit(position) {
        dataService.set('position', position);

        var dialog = {
          controller: 'editPositionDialogController as vm',
          templateUrl: '/app/admin/templates/dialogs/edit-position-dialog.template.html',
        }

        MaterialDesign.customDialog(dialog)
          .then(init);
      }

      function remove(position) {
        var dialog = {
          title: 'Delete position',
          message: 'Are you sure you want to delete this position?',
          ok: 'Delete',
          cancel: 'Cancel',
        }

        MaterialDesign.confirm(dialog)
          .then(deleteRequest)
          .then(applyChanges);

        function deleteRequest() {
          return Position.detach(position.id, vm.account.id)
            .catch(function() {
              MaterialDesign.reject();
              MaterialDesign.error();
            });
        }

        function applyChanges() {
          MaterialDesign.notify('Position deleted.');
          init();
        }
      }
    }
})();
