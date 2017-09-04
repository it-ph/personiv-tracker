project40.factory('LoginDataOp', ['$http', function($http,$rootScope){
  var LoginDataOp = {};

  LoginDataOp.login = function(user){
		return $http({
			method: 'POST',
			url: 'login',
			dataType: 'json',
			data: user,
			//headers: { 'Content-Type': 'application/json; charset=UTF-8'}
			headers: { 'Content-Type': 'application/json; charset=UTF-8','X-CSRF-TOKEN':$rootScope.token}

		})
	}
  return LoginDataOp;

}]);
