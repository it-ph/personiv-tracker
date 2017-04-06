admin
	.factory('Task', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		factory.query = {}

		factory.search = function(data){
			factory.query.search = data;

			factory.init();
		}

		factory.init = function(){

		}

		return factory;
	}]);