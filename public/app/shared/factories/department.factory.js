shared
	.factory('Department', ['$http', function($http){
		return {
			data : [],
			index: index,
		}

		function index(){
			return $http.get('department');
		}
	}]);