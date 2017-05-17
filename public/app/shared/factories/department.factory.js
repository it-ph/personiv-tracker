shared
	.factory('Department', ['$http', function($http){
		var factory = {
			data : [],
			index: index,
		}

		return factory;

		function index(){
			return $http.get('department');
		}
	}]);