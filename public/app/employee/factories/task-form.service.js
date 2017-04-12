employee
	.factory('taskFormService', ['$http', 'MaterialDesign', 'Task', function($http, MaterialDesign, Task){
		var factory = {}

		factory.new = {}

		factory.store = function(){
			return $http.post('/task', factory.new);
		}

		factory.update = function(){
			return $http.put('/task/' + factory.data.id, factory.data);
		}

		factory.setCurrent = function(data){
			Task.formatData(data);
			Task.current = data;
		}

		factory.set = function(data){
			factory.data = data;
		}

		return factory;
	}]);