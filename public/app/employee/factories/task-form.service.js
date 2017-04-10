employee
	.factory('taskFormService', ['$http', 'MaterialDesign', 'Task', function($http, MaterialDesign, Task){
		var factory = {}

		factory.new = {}

		factory.data = []

		factory.store = function(){
			return $http.post('/task', factory.new);
		}

		factory.update = function(data, id){
			return $http.put('/task/' + id, data);
		}

		factory.setCurrent = function(data){
			Task.current = data;
		}

		return factory;
	}]);