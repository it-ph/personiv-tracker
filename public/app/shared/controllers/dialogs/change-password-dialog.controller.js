shared
	.controller('changePasswordDialogController', ['User', 'MaterialDesign', 'changePasswordService', function(User, MaterialDesign, changePasswordService){
		var vm = this;

		/**
		 * Instantiate the service.
		*/
		vm.service = changePasswordService;
		vm.service.init();

		/**
	     * Check if the input password of user is same with current password.
	     *
	     * @return bool
	     */
		vm.verifyPassword = function(){
			vm.service.verifyPassword()
				.then(function(response){
					vm.match = response.data;
					vm.show = true;
				}, function(){
					vm.error = true;
				})
		}

		vm.submit = function(){
			/**
			 * Check for invalid forms.
			 */
			if(vm.changePasswordForm.$invalid){
				angular.forEach(vm.changePasswordForm.$error, function(field){
					angular.forEach(field, function(errorField){
						errorField.$setTouched();
					});
				});
			}

			/**
			 * Check if old password is equal the new password or new password is not equal with the confirmation password.
			 *
			 * @return void
			 */
			if(vm.service.data.old == vm.service.data.new || vm.service.data.new != vm.service.data.confirm)
			{
				return;
			}
			else {
				/**
				 * Runs the preloader.
				 */
				vm.busy = true;

				vm.service.submit()
					.then(function(){
						/**
						 * Stops the preloader.
						 */
						vm.busy = false;

						/**
						 * Closes the dialog.
						 */
						vm.service.cancel();

						/**
						 * Notify the user for success.
						 */
						 MaterialDesign.notify('Password changed.');
					}, function(){
						vm.error = true;
					})
			}
		}
	}]);