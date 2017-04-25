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