shared
	.factory('Account', ['$http', function($http){
		var factory = {}

		factory.data = [];

		factory.enlist = function(query){
			return $http.post('/account/enlist', query);
		}

		factory.store = function(data){
			return $http.post('/account', data);
		}

		factory.update = function(data){
			return $http.put('/account/' + data.id, data);
		}

		factory.delete = function(id){
			return $http.delete('/account/' + id);
		}

		return factory;
	}]);
