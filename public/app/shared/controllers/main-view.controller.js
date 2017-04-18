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

		/**
		 * Initialize
		*/
		var init = function(){
			vm.user.pusher();
			vm.user.photoUploaderInit();
		}();
	}]);