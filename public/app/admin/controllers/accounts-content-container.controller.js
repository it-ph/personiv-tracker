admin
  .controller('accountsContentContainerController', accountsContentContainerController)

accountsContentContainerController.$inject = ['MaterialDesign', 'User', 'fab', '$q'];

function accountsContentContainerController(MaterialDesign, User, fab, $q) {
  var vm = this;

  vm.user = User;
  vm.edit = edit;
  vm.view = view;
  vm.resetPassword = resetPassword;
  vm.deleteUser = deleteUser;

  vm.fab = fab;
  vm.fab.icon = 'mdi-plus';
  vm.fab.show = true;
  vm.fab.label = 'Create User';
  vm.fab.action = function() {
    vm.user.showForm = true;
    vm.fab.show = false;
  }

  function view(user) {
    vm.user.set('view', user);
    var dialog = {
      controller: 'userFormDialogController as vm',
      templateUrl: '/app/admin/templates/dialogs/user-form-dialog.template.html',
    }

    MaterialDesign.customDialog(dialog);
  }

  function edit(user){
    vm.user.set('edit', user);
    var dialog = {
      controller: 'editUserFormDialogController as vm',
      templateUrl: '/app/admin/templates/dialogs/edit-user-form-dialog.template.html',
    }

    MaterialDesign.customDialog(dialog)
      .then(seeChanges);

    function seeChanges(){
      vm.user.get()
        .then(function(response){
          vm.user.set('user', response.data);
        })
        .catch(error);
    }
  }

  function deleteUser(user) {
    var dialog = {
      title: 'Delete',
      message: 'Delete this user account?',
      ok: 'Delete',
      cancel: 'Cancel'
    }

    MaterialDesign.confirm(dialog)
      .then(deleteRequest)
      .then(spliceUser)
      .then(notifyChanges)

    function deleteRequest(){
      MaterialDesign.preloader();
      return vm.user.delete(user.id)
        .catch(function() {
          MaterialDesign.reject();
          MaterialDesign.error();
        });
    }

    function spliceUser(){
      var index = vm.user.user.subordinates.indexOf(user);
      vm.user.user.subordinates.splice(index, 1);
    }

    function notifyChanges(){
      MaterialDesign.hide();
      MaterialDesign.notify('User deleted.');
    }
  }

  function resetPassword(user) {
    var dialog = {
      title: 'Reset Password',
      message: 'Password will be set as !welcome10',
      ok: 'Reset Password',
      cancel: 'Cancel'
    }

    MaterialDesign.confirm(dialog)
      .then(function(){
        return vm.user.resetPassword(user)
          .catch(function() {
            MaterialDesign.reject();
            MaterialDesign.error();
          });
      })
      .then(function(){
        MaterialDesign.notify('Changes saved.');
      })
  }

  function error(){
    return MaterialDesign.error();
  }
}
