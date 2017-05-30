shared
	.controller('mainViewController', ['User', 'MaterialDesign', function(User, MaterialDesign){
		var vm = this;

		vm.user = User;
		vm.logout = logout;
		vm.forceChangePassword = forceChangePassword;
		/*
		 * Ends the session of the authenticated user.
		 */
		 function logout() {
			 MaterialDesign.reject();
			 return vm.user.logout()
 				.then(function(){
 					window.location.href = '/';
 				});
		 }

		 function forceChangePassword() {
			 var dialog = {
 				title: 'Change Password',
 				message: 'Please change your default password.',
 				ok: 'Got it!',
 			}

 			return MaterialDesign.confirm(dialog)
		 }

		 function changePasswordDialog() {
			 return vm.user.changePassword()
		 }

		/**
		 * Initialize
		*/
		var init = function(){
			vm.user.checkDefaultPassword()
				.then(function(response){
					if(response.data)
					{
						return vm.forceChangePassword()
							.then(changePasswordDialog)
							.catch(logout);
					}
				})
		}();
	}]);
