project40.controller('LoginController', function($rootScope, $scope, $state,
		LoginDataOP) {

    var vm = this;
    vm.user ={
        employee_number: undefined,
        password:undefined
    };
    $scope.logUser = function(){
      LoginDataOp.login(vm.user).then(function(response){
        console.log(response.data);
      }).catch(function(error) {
        console.log(error);
      });
    }
});
