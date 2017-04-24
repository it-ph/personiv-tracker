shared
	.factory('Task', ['$http', 'MaterialDesign', 'toolbarService', function($http, MaterialDesign, toolbarService){
		var factory = {}

		// task paginated data
		factory.data = []

		// add search property to enlist query
		factory.search = function(data){
			factory.query.search = data;

			factory.init();
		}

		// refresh the enlist and removes search property
		factory.refresh = function(){
			factory.query.search = null;

			factory.init();
		}

		factory.enlist = function(query){
			return $http.post('/task/enlist', query);
		}

		factory.paginate = function(query, page){
			return $http.post('/task/enlist?page=' + page, query);
		}

		factory.pause = function(){
			return $http.post('/task/pause/' + factory.current.id);
		}

		factory.resume = function(){
			return $http.post('/task/resume/' + factory.current.id, factory.current.pauses[0]);
		}

		factory.dashboard = function(){
			return $http.post('/task/dashboard');
		}

		factory.finish = function(){
			return $http.post('/task/finish/' + factory.current.id, factory.current.pauses.length ? factory.current.pauses[0] : null);
		}

		factory.delete = function(id){
			return $http.delete('/task/' + id);
		}

		// format task item
		factory.formatData = function(data){
			data.created_at = new Date(data.created_at);
			data.ended_at = data.ended_at ? new Date(data.ended_at) : null; 
		}

		// push paginated task to paginated data
		factory.pushItem = function(data){
			factory.data.push(data);
		}

		// add items to toolbar autocomplete search
		factory.setToolbarItems = function(data){
			var entry = {}

			entry.display = data.title;
			entry.date = new Date(data.created_at).toDateString() + new Date(data.ended_at).toDateString();

			toolbarService.items.push(entry);
		}

		return factory;
	}]);