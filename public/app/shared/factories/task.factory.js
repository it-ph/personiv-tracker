shared
	.factory('Task', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		factory.current = {}

		factory.search = function(data){
			factory.query.search = data;

			factory.init();
		}

		factory.enlist = function(query){
			return $http.post('/task/enlist', query);
		}

		factory.init = function(){

		}

		return factory;
	}]);