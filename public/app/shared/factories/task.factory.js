shared
	.factory('Task', ['$http', 'MaterialDesign', 'toolbarService', function($http, MaterialDesign, toolbarService){
		var factory = {}

		factory.data = []

		factory.search = function(data){
			factory.query.search = data;

			factory.init();
		}

		factory.enlist = function(query){
			return $http.post('/task/enlist', query);
		}

		factory.paginate = function(query, page){
			return $http.post('/task/enlist?page=' + page, query);
		}

		factory.init = function(){

		}

		factory.formatData = function(data){
			data.created_at = new Date(data.created_at);
			data.ended_at = data.ended_at ? new Date(data.ended_at) : null; 
		}

		factory.setToolbarItems = function(data){
			var entry = {}

			entry.display = data.title;
			entry.date = new Date(data.created_at).toDateString() + new Date(data.ended_at).toDateString();

			toolbarService.items.push(entry);
		}

		factory.finish = function(){
			return $http.post('/task/finish/' + factory.current.id);
		}

		return factory;
	}]);