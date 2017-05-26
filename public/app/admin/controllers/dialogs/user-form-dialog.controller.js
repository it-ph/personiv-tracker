admin
  .controller('userFormDialogController', userFormDialogController)

  userFormController.$inject = ['MaterialDesign', 'User', 'formService'];

  function userFormDialogController(MaterialDesign, User, formService) {
    var vm = this;

    vm.label = User.view.name;
    vm.cancel = cancel;
    init();

    function cancel() {
      MaterialDesign.hide();
    }

    function init(){
      var query = {
        where: [
          {
            column: 'id',
            condition: '=',
            value: User.view.id,
          }
        ],
        relationships: ['experiences.position'],
        first: true,
      }

      User.enlist(query)
        .then(function(response){
          vm.user = response.data;

          angular.forEach(vm.user.experiences, function(experience){
            experience.date_started = new Date(experience.date_started);
          });
        })
        .catch(function(){
          MaterialDesign.error();
        });
    }
  }
