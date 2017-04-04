auth
	.service('Registration', ['Rest', function(Rest){
		this.departments = function(){
			Rest.get('/department')
				.then(function(data){
					return data;
				})
		}
	}]);