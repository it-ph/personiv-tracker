(function() {
  angular
    .module('app')
    .controller('positionFormController', positionFormController)

    positionFormController.$inject = ['User', 'Position', 'MaterialDesign']

    function positionFormController(User, Position, MaterialDesign) {
      var vm = this;
    }
})();
