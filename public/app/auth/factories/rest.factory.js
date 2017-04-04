auth
	.factory('Rest', ['$http', function($http){
		return {
			get: function(url){
				return $http.get(url);
			},
			post: function(url, data){
				return $http.post(url, data);
			},
			put: function(url, data){
				return $http.put(url, data);
			},
			delete: function(url){
				return $http.delete(url);
			},
		}
	}]);