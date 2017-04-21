shared
	.factory('ShiftSchedule', ['$http', 'MaterialDesign', function($http, MaterialDesign){
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

		factory.formatTime = function(time){
			if(time.getMinutes() < 30)
			{
				time.setMinutes(30);
			}
			else if(time.getMinutes() > 30)
			{
				time.setHours(time.getHours() + 1);
				time.setMinutes(0);
			}
			
			time.setSeconds(0);

			return time;
		}

		factory.init = function(){
			var now = new Date();

			factory.data = {};
			
			factory.data.from = factory.formatTime(now);
			factory.data.to = factory.formatTime(now);
		}

		return factory;
	}]);