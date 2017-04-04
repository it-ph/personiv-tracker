var auth = angular.module('auth', ['ngMaterial', 'ngMessages',]);
auth
	.config(['$mdThemingProvider', function($mdThemingProvider){
		/*
		 * Set the default theme to Indigo - Amber.
		 */
		$mdThemingProvider.theme('default')
			.primaryPalette('indigo')
			.accentPalette('amber')
	}]);
auth
	.controller('formController',  function(){
		var vm = this;

		/*
		 * Reveals the form. 
		*/
		vm.show = function(){
			angular.element(document.querySelector('#main')).removeClass('no-opacity');
		};
	});
auth
	.controller('registrationController', ['Registration', function(Registration){
		var vm = this;

		vm = Registration;

		console.log(vm.departments());
	}]);
auth
	.factory('Rest', ['$http', function($http){
		return {
			get: function(url){
				return $http.get(url);
			},
			post: function(url, data){
				return $http.post(url, data);
			},
			put: function(url, data){
				return $http.put(url, data);
			},
			delete: function(url){
				return $http.delete(url);
			},
		}
	}]);
auth
	.service('Registration', ['Rest', function(Rest){
		this.departments = function(){
			Rest.get('/department')
				.then(function(data){
					return data;
				})
		}
	}]);