shared
	.factory('Account', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		factory.data = [];

		factory.enlist = function(query){
			return $http.post('/account/enlist', query);
		}

		return factory;
	}]);