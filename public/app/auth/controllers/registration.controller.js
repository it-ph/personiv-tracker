auth
	.controller('registrationController', ['Registration', function(Registration){
		var vm = this;

		vm = Registration;

		console.log(vm.departments());
	}]);