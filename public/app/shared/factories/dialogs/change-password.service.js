shared
	.factory('changePasswordService', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		/*
		 * Check if the password of the authenticated user is the same with his new password.
		 */
		factory.verifyPassword = function(){
			return $http.post('/user/verify-password', factory.data);
		}

		/*
		 * Clears all data in the service and closes the dialog.
		 */
		factory.cancel = function(){
			factory.init();
			MaterialDesign.cancel();
		}

		/*
		 * Submit the form.
		 */
		factory.submit = function(){
			return $http.post('/user/change-password', factory.data);
		}
		
		/*
		 * Initializes the service.
		 */
		factory.init = function(){
			factory.data = {};
		}

		return factory;
	}]);