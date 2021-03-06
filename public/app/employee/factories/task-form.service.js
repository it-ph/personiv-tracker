employee
	.factory('taskFormService', ['$http', 'MaterialDesign', 'Task', function($http, MaterialDesign, Task){
		var factory = {}

		// object for new task
		factory.new = {}

		factory.store = function(){
			return $http.post('/task', factory.new);
		}

		factory.update = function(){
			return $http.put('/task/' + factory.data.id, factory.data);
		}

		// set new stored task as current task pinned at top
		factory.setCurrent = function(data){
			Task.formatData(data);
			Task.current = data;
		}

		// object for update
		factory.set = function(data){
			factory.data = data;
		}

		factory.setNumberofPhotos = function(data){
			factory.numberOfPhotos = data;
		}

		factory.changeNumberOfPhotos = function(data){
			if(data.number_of_photos)
			{
				factory.setNumberofPhotos(data.number_of_photos);

				data.number_of_photos = null;
			}
			else{
				data.number_of_photos = factory.numberOfPhotos;
			}
		}

		factory.init = function(){
			factory.data = {};
			factory.new = {};
			factory.numberOfPhotos = null;
		}

		return factory;
	}]);