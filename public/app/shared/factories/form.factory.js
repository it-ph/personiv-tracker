shared
	.factory('formService', ['MaterialDesign', function(MaterialDesign){
		var factory = {}

		/**
		 * Checks the form for invalid fields and set the form as touched.
		*/
		factory.validate = function(form){
			if(form.$invalid){
				angular.forEach(form.$error, function(field){
					angular.forEach(field, function(errorField){
						errorField.$setTouched();
					});
				});

				return true;
			}
		}

		/**
		 * Hides dialog.
		*/
		factory.cancel = function(){
			MaterialDesign.cancel();
		}

		return factory;
	}]);