shared
	.controller('mainViewController', ['User', 'Experience', 'MaterialDesign', function(User, Experience, MaterialDesign){
		var vm = this;

		vm.user = User;
		vm.logout = logout;
		vm.forceChangePassword = forceChangePassword;
		vm.setPositions = setPositions;

		function setPositions() {
			var dialog = {
				controller: 'experiencesDialogController as vm',
				templateUrl: '/app/employee/templates/dialogs/experiences-dialog.template.html'
		 	}

			MaterialDesign.customDialog(dialog)
		}

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

		 function forceSetPosition() {
			 if(!User.isRankAndFile())
			 {
				 return MaterialDesign.reject();
			 }
			 var query = {
				 where: [
					 {
						 column: 'user_id',
						 condition: '=',
						 value: vm.user.user.id
					 }
				 ]
			 }

			 return Experience.enlist(query)
			 	.then(function(response){
					if(!response.data.length)
					{
						var dialog = {
							title: 'Update Positions',
							message: "Please set your position per project.",
							ok: 'Update',
						}

						return MaterialDesign.confirm(dialog);
					}
					return MaterialDesign.reject();
				})
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
				.then(forceSetPosition)
				.then(setPositions)
				// .catch(logout);
		}();
	}]);
