shared
	.controller('mainViewController', ['User', 'MaterialDesign', function(User, MaterialDesign){
		var vm = this;

		vm.user = User;

		/**
		 * Get the record of the authenticated user.
		 */
		vm.getUser = function(){
			vm.user.get()
				.then(function(data){
					vm.user.set(data.data);
					// Initialize the websocket connection
					vm.user.pusher();
					// Initialize the file uploader for avatar
					vm.user.photoUploaderInit();
				}, function(){
					MaterialDesign.failed()
						.then(function(){
							vm.getUser();
						})
				});
		}

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

		/**
		 * Initialize
		*/
		var init = function(){
			vm.getUser();
		}();
	}]);