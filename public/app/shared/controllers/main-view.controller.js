shared
	.controller('mainViewController', ['User', 'MaterialDesign', function(User, MaterialDesign){
		var vm = this;

		vm.user = User;

		/*
		 * Ends the session of the authenticated user.
		 */
		vm.logout = function(){
			vm.user.logout()
				.then(function(){
					window.location.href = '/';
				});
		}

  		/**
		 * Opens the upload form of avatar
  		*/
		vm.clickUpload = function(){
		    angular.element('#upload').trigger('click');
		};

		/**
		 * Mark notification as read
		*/
		vm.markAsRead = function(data){
			vm.user.markAsRead()
				.then(function(){
					vm.user.removeNotification(data);
				}, function(){
					MaterialDesign.error();
				});
		}
		/**
		 * Mark all unread notifications as read
		*/
		vm.markAllAsRead = function(){
			vm.user.markAllAsRead()
				.then(function(){
					vm.user.clearNotifications();
				}, function(){
					MaterialDesign.error();
				});
		}

		vm.forceChangePassword = function(){
			var dialog = {
				title: 'Change Password',
				message: 'Please change your default password.',
				ok: 'Got it!',
			}

			MaterialDesign.confirm(dialog)
				.then(function(){
					vm.user.changePassword()
						.then(function(){
							console.log('done')
							MaterialDesign.hide();
						}, function(){
							vm.forceChangePassword();
						});
				}, function(){
					vm.logout();
				});
		}

		/**
		 * Initialize
		*/
		var init = function(){
			vm.user.checkDefaultPassword()
				.then(function(response){
					if(response.data)
					{
						vm.forceChangePassword();
						// vm.user.changePassword()
						// 	.then(function(){

						// 	}, function(){

						// 	})
					}
				})
			// vm.user.pusher();
			vm.user.photoUploaderInit();
		}();
	}]);