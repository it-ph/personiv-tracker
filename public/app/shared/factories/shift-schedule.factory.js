shared
	.factory('ShiftSchedule', ['$http', 'MaterialDesign', 'formService', function($http, MaterialDesign, formService){
		var factory = {}

		factory.data = {}

		factory.index = function(){
			return $http.get('/shift-schedule');
		}

		factory.store = function(){
			return $http.post('/shift-schedule', factory.data);
		}

		factory.update = function(){
			return $http.put('/shift-schedule/' + factory.data.id, factory.data);
		}

		factory.toLocaleTimeString = function(){
			factory.data.from = factory.data.from.toLocaleTimeString();
			factory.data.to = factory.data.to.toLocaleTimeString();
		}

		factory.toDateObject = function(){
			var today = new Date();

			factory.data.from = new Date(today.toDateString() + ' ' + factory.data.from);
			factory.data.to = new Date(today.toDateString() + ' ' + factory.data.to);
		}

		factory.init = function(){
			var now = new Date();

			factory.data = {};
			
			factory.data.from = formService.timeFormat(now);
			factory.data.to = formService.timeFormat(now);
		}

		return factory;
	}]);