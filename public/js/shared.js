var shared = angular.module('shared', [
	'ui.router',
	'ngMaterial',
	'ngMessages',
	'infinite-scroll',
	'highcharts-ng',
	'angularMoment',
	'angularFileUpload'
]);
shared
	.config(['$urlRouterProvider', '$stateProvider', '$mdThemingProvider', '$qProvider', function($urlRouterProvider, $stateProvider, $mdThemingProvider, $qProvider){
		$qProvider.errorOnUnhandledRejections(false);
		/*
		 * Set the default theme to Indigo - Amber.
		 */
		$mdThemingProvider.theme('default')
			.primaryPalette('indigo')
			.accentPalette('amber')
		
		/*
		 * Fallback route when a state is not found.
		 */
		$urlRouterProvider
			.otherwise('/page-not-found')
			.when('', '/');
		
		$stateProvider
			.state('page-not-found',{
				url: '/page-not-found',
				templateUrl: '/app/shared/views/page-not-found.view.html',
			})
	}]);
shared
	.factory('MaterialDesign', ['$mdDialog', '$mdToast', function($mdDialog, $mdToast){
		var factory = {}
		/*
		 * Opens an alert dialog.
		 *
		 * @params: title, message
		 */
		factory.alert = function(data){
			$mdDialog.show(
				$mdDialog.alert()
			        .parent(angular.element($('body')))
			        .clickOutsideToClose(true)
			        .title(data.title)
			        .textContent(data.message)
			        .ariaLabel(data.title)
			        .ok('Got it!')
			    );
		}

		/*
		 * Opens a custom dialog.
		 * 
		 * @params: controller, templateUrl, fullscreen
		 */
		factory.customDialog = function(data){
			$mdDialog.show({
		      	controller: data.controller,
		      	templateUrl: data.templateUrl,
		      	parent: angular.element(document.body),
		      	fullscreen: data.fullscreen,
		    });
		}

		/*
		 * Opens a confirmation dialog.
		 *
		 * @params: title, message, ok, cancel
		 */
		factory.confirm = function(data)
		{
			var confirm = $mdDialog.confirm()
		        .title(data.title)
		        .textContent(data.message)
		        .ariaLabel(data.title)
		        .ok(data.ok)
		        .cancel(data.cancel);

		    return $mdDialog.show(confirm);
		}

		/*
		 * Opens a prompt dialog.
		 *
		 * @params: title, message, placeholder, ok, cancel
		 */
		factory.prompt = function(data)
		{
			var prompt = $mdDialog.prompt()
		    	.title(data.title)
		      	.textContent(data.message)
		      	.placeholder(data.placeholder)
		      	.ariaLabel(data.title)
		      	.ok(data.ok)
		      	.cancel(data.cancel);

		    return $mdDialog.show(prompt);
		}

		/*
		 * Opens a simple toast.
		 *
		 * @params: message
		 */
		factory.notify = function(message) {
			var toast = $mdToast.simple()
		      	.textContent(message)
		      	.position('bottom right')
		      	.hideDelay(3000);
		      	
		    return $mdToast.show(toast);
		}

		/*
		 * Opens an indeterminate progress circular.
		 */
		factory.preloader = function(){
			$mdDialog.show({
				templateUrl: '/app/shared/templates/loading.template.html',
			    parent: angular.element(document.body),
			});
		}

		/*
		 * Cancels a dialog.
		 */
		factory.cancel = function(){
			$mdDialog.cancel();
		}

		/*
		 * Hides a dialog and can return a value.
		 */
		factory.hide = function(data){
			$mdDialog.hide(data);
		}

		/*
		 * Returns a basic error message.
		 */
		factory.error = function(){
			var dialog = {
				'title': 'Oops! Something went wrong!',
				'content': 'An error occured. Please try again later.',
			}

			factory.alert(dialog);
		}

		/*
		 * Returns a basic error message.
		 */
		factory.failed = function(){
			var dialog = {
				'title': 'Aw Snap!',
				'message': 'An error occured loading the resource.',
				'ok': 'Try Again'
			}

			factory.confirm(dialog);
		}

		return factory;
	}]);
shared
	.factory('User', ['$http', '$state', 'MaterialDesign', function($http, $state, MaterialDesign){
		var factory = {};

		factory.user = {};

		/*
		 * Get the record of the authenticated user. 
		 */
		factory.get = function(){
			return $http.post('/user/check');
		}

		/*
		 * Sets the user
		*/
		factory.set = function(data){
			factory.user = data;
		}

		/*
		 * Set user's pusher subscription
		*/
		factory.pusher = function(){
			var pusher = new Pusher('f4ec05090428ca64a977', {
		      	encrypted: true,
		      	auth: {
				    headers: {
				      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				    }
			  	}
		    });

			var channel = {}

			channel.user = pusher.subscribe('private-App.User.' + factory.user.id);

			channel.user.bindings = [
				channel.user.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
			 		// formating the notification
			 		data.created_at = data.attachment.created_at;

			 		data.data = {};
			 		data.data.attachment = data.attachment;
			 		data.data.url = data.url;
			 		data.data.withParams = data.withParams;
			 		data.data.sender = data.sender;
			 		data.data.message = data.message;

			 		// pushes the new notification in the unread_notifications array
		 			factory.user.unread_notifications.unshift(data);
			 		
			 		// notify the user with a toast message
			 		MaterialDesign.notify(data.sender.name + ' ' + data.message);

			 		if($state.current.name == data.data.url)
					{
						$state.go($state.current, {}, {reload:true});
					}
			    }),
			]
		}

		/*
		 * Ends the session of the authenticated user. 
		 */
		factory.logout = function(){
			return $http.post('/user/logout');
		}

		/*
		 * Opens a form to change password.
		 */
		factory.changePassword = function(){
			var dialog = {
				'controller': 'changePasswordDialogController as vm',
				'templateUrl': '/app/shared/templates/dialogs/change-password-dialog.template.html'
			}

			return MaterialDesign.customDialog(dialog);
		}

		return factory;
	}]);
shared
	.factory('changePasswordService', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		/*
		 * Check if the password of the authenticated user is the same with his new password.
		 */
		factory.verifyPassword = function(){
			return $http.post('/user/verify-password', factory.data);
		}

		/*
		 * Clears all data in the service and closes the dialog.
		 */
		factory.cancel = function(){
			factory.init();
			MaterialDesign.cancel();
		}

		/*
		 * Submit the form.
		 */
		factory.submit = function(){
			return $http.post('/user/change-password', factory.data);
		}
		
		/*
		 * Initializes the service.
		 */
		factory.init = function(){
			factory.data = {};
		}

		return factory;
	}]);
shared
	.factory('MaterialDesign', ['$mdDialog', '$mdToast', function($mdDialog, $mdToast){
		var factory = {}
		/*
		 * Opens an alert dialog.
		 *
		 * @params: title, message
		 */
		factory.alert = function(data){
			$mdDialog.show(
				$mdDialog.alert()
			        .parent(angular.element($('body')))
			        .clickOutsideToClose(true)
			        .title(data.title)
			        .textContent(data.message)
			        .ariaLabel(data.title)
			        .ok('Got it!')
			    );
		}

		/*
		 * Opens a custom dialog.
		 * 
		 * @params: controller, templateUrl, fullscreen
		 */
		factory.customDialog = function(data){
			$mdDialog.show({
		      	controller: data.controller,
		      	templateUrl: data.templateUrl,
		      	parent: angular.element(document.body),
		      	fullscreen: data.fullscreen,
		    });
		}

		/*
		 * Opens a confirmation dialog.
		 *
		 * @params: title, message, ok, cancel
		 */
		factory.confirm = function(data)
		{
			var confirm = $mdDialog.confirm()
		        .title(data.title)
		        .textContent(data.message)
		        .ariaLabel(data.title)
		        .ok(data.ok)
		        .cancel(data.cancel);

		    return $mdDialog.show(confirm);
		}

		/*
		 * Opens a prompt dialog.
		 *
		 * @params: title, message, placeholder, ok, cancel
		 */
		factory.prompt = function(data)
		{
			var prompt = $mdDialog.prompt()
		    	.title(data.title)
		      	.textContent(data.message)
		      	.placeholder(data.placeholder)
		      	.ariaLabel(data.title)
		      	.ok(data.ok)
		      	.cancel(data.cancel);

		    return $mdDialog.show(prompt);
		}

		/*
		 * Opens a simple toast.
		 *
		 * @params: message
		 */
		factory.notify = function(message) {
			var toast = $mdToast.simple()
		      	.textContent(message)
		      	.position('bottom right')
		      	.hideDelay(3000);
		      	
		    return $mdToast.show(toast);
		}

		/*
		 * Opens an indeterminate progress circular.
		 */
		factory.preloader = function(){
			$mdDialog.show({
				templateUrl: '/app/shared/templates/loading.template.html',
			    parent: angular.element(document.body),
			});
		}

		/*
		 * Cancels a dialog.
		 */
		factory.cancel = function(){
			$mdDialog.cancel();
		}

		/*
		 * Hides a dialog and can return a value.
		 */
		factory.hide = function(data){
			$mdDialog.hide(data);
		}

		/*
		 * Returns a basic error message.
		 */
		factory.error = function(){
			var dialog = {
				'title': 'Oops! Something went wrong!',
				'content': 'An error occured. Please try again later.',
			}

			factory.alert(dialog);
		}

		/*
		 * Returns a basic error message.
		 */
		factory.failed = function(){
			var dialog = {
				'title': 'Aw Snap!',
				'message': 'An error occured loading the resource.',
				'ok': 'Try Again'
			}

			factory.confirm(dialog);
		}

		return factory;
	}]);
shared
	.factory('User', ['$http', '$state', 'MaterialDesign', function($http, $state, MaterialDesign){
		var factory = {};

		factory.user = {};

		/*
		 * Get the record of the authenticated user. 
		 */
		factory.get = function(){
			return $http.post('/user/check');
		}

		/*
		 * Sets the user
		*/
		factory.set = function(data){
			factory.user = data;
		}

		/*
		 * Set user's pusher subscription
		*/
		factory.pusher = function(){
			var pusher = new Pusher('f4ec05090428ca64a977', {
		      	encrypted: true,
		      	auth: {
				    headers: {
				      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				    }
			  	}
		    });

			var channel = {}

			channel.user = pusher.subscribe('private-App.User.' + factory.user.id);

			channel.user.bindings = [
				channel.user.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
			 		// formating the notification
			 		data.created_at = data.attachment.created_at;

			 		data.data = {};
			 		data.data.attachment = data.attachment;
			 		data.data.url = data.url;
			 		data.data.withParams = data.withParams;
			 		data.data.sender = data.sender;
			 		data.data.message = data.message;

			 		// pushes the new notification in the unread_notifications array
		 			factory.user.unread_notifications.unshift(data);
			 		
			 		// notify the user with a toast message
			 		MaterialDesign.notify(data.sender.name + ' ' + data.message);

			 		if($state.current.name == data.data.url)
					{
						$state.go($state.current, {}, {reload:true});
					}
			    }),
			]
		}

		/*
		 * Ends the session of the authenticated user. 
		 */
		factory.logout = function(){
			return $http.post('/user/logout');
		}

		/*
		 * Opens a form to change password.
		 */
		factory.changePassword = function(){
			var dialog = {
				'controller': 'changePasswordDialogController as vm',
				'templateUrl': '/app/shared/templates/dialogs/change-password-dialog.template.html'
			}

			return MaterialDesign.customDialog(dialog);
		}

		return factory;
	}]);
shared
	.controller('mainViewController', ['User', 'MaterialDesign', function(User, MaterialDesign){
		var vm = this;

		vm.user = User;

		/*
		 * Get the record of the authenticated user.
		 */
		vm.getUser = function(){
			vm.user.get()
				.then(function(data){
					vm.user.set(data.data);

					vm.user.pusher();
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

		vm.init = function(){
			vm.getUser();
		}();

		// $scope.changePassword = function()
		// {
		// 	$mdDialog.show({
		//       controller: 'changePasswordDialogController',
		//       templateUrl: '/app/shared/templates/dialogs/change-password-dialog.template.html',
		//       parent: angular.element(document.body),
		//       fullscreen: true,
		//     })
		//     .then(function(){
		//     	Helper.notify('Password changed.')
		//     });
		// }

		// var uploader = {};

		// uploader.filter = {
  //           name: 'photoFilter',
  //           fn: function(item /*{File|FileLikeObject}*/, options) {
  //               var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
  //               return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
  //           }
  //       };

  //       uploader.sizeFilter = {
		//     'name': 'enforceMaxFileSize',
		//     'fn': function (item) {
		//         return item.size <= 2000000;
		//     }
  //       }

  //       uploader.error = function(item /*{File|FileLikeObject}*/, filter, options) {
  //           $scope.fileError = true;
  //           $scope.photoUploader.queue = [];
  //       };

  //       uploader.headers = { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')};

		// $scope.clickUpload = function(){
		//     angular.element('#upload').trigger('click');
		// };

		// $scope.markAllAsRead = function(){
		// 	Helper.post('/user/mark-all-as-read')
		// 		.success(function(){
		// 			$scope.user.unread_notifications = [];
		// 		})
		// }

		// var fetchUnreadNotifications = function(){
		// 	Helper.post('/user/check')
	 //    		.success(function(data){
	 //    			$scope.user = data;
	 //    		});
		// }

		// Helper.post('/user/check')
		// 	.success(function(data){
		// 		var notifications = {
		// 			'state': 'main.notifications',
		// 			'icon': 'mdi-bell',
		// 			'label': 'Notifications',
		// 			'show': true,
		// 		}

		// 		$scope.menu.static.push(notifications);

		// 		$scope.user = data;

		// 		$scope.currentTime = Date.now();

		// 		Helper.setAuthUser(data);

		// 		/* Photo Uploader */
		// 		$scope.photoUploader = new FileUploader({
		// 			url: '/user/upload-avatar/' + $scope.user.id,
		// 			headers: uploader.headers,
		// 			queueLimit : 1
		// 		})

		// 		// FILTERS
		//         $scope.photoUploader.filters.push(uploader.filter);
		//         $scope.photoUploader.filters.push(uploader.sizeFilter);
		        
		// 		$scope.photoUploader.onWhenAddingFileFailed = uploader.error;
		// 		$scope.photoUploader.onAfterAddingFile  = function(){
		// 			$scope.fileError = false;
		// 			if($scope.photoUploader.queue.length)
		// 			{	
		// 				$scope.photoUploader.uploadAll()
		// 			}
		// 		};

		// 		$scope.photoUploader.onCompleteItem  = function(data, response){
		// 			if($scope.user.avatar_path)
		// 			{
		// 				$scope.currentTime = Date.now();
		// 				$scope.photoUploader.queue = [];
		// 			}
		// 			else{
		// 				$state.go($state.current, {}, {reload:true});
		// 			}
		// 		}

		// 		var pusher = new Pusher('ade8d83d4ed5455e3e18', {
		// 	      	encrypted: true,
		// 	      	auth: {
		// 			    headers: {
		// 			      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		// 			    }
		// 		  	}
		// 	    });

		// 		var channel = {};

		// 		channel.user = pusher.subscribe('private-App.User.' + $scope.user.id);

		// 		channel.user.bindings = [
		// 		 	channel.user.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
		// 		 		// formating the notification
		// 		 		data.created_at = data.attachment.created_at;

		// 		 		data.data = {};
		// 		 		data.data.attachment = data.attachment;
		// 		 		data.data.url = data.url;
		// 		 		data.data.withParams = data.withParams;
		// 		 		data.data.sender = data.sender;
		// 		 		data.data.message = data.message;

		// 		 		// pushes the new notification in the unread_notifications array
		// 		 		$scope.$apply(function(){
		// 			    	$scope.user.unread_notifications.unshift(data);
		// 		 		});

		// 		 		// notify the user with a toast message
		// 		 		Helper.notify(data.sender.name + ' ' + data.message);

		// 		 		if($state.current.name == data.data.url)
		// 				{
		// 					$state.go($state.current, {}, {reload:true});
		// 				}
		// 		    }),
		// 		];
		// 	})

		// $scope.markAsRead = function(notification){
		// 	Helper.post('/user/mark-as-read', notification)
		// 		.success(function(){
		// 			var index = $scope.user.unread_notifications.indexOf(notification);

		// 			$scope.user.unread_notifications.splice(index, 1);
		// 		})
		// 		.error(function(){
		// 			Helper.error();
		// 		});
		// }

		// $scope.read = function(notification){			
		// 	$state.go(notification.data.url);

		// 	$scope.markAsRead(notification);
		// }
	}]);
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
shared
	.controller('listItemActionsDialogController', ['$scope', 'Helper', function($scope, Helper){
		$scope.data = Helper.fetch();
	}]);
shared
	.controller('mainViewController', ['User', 'MaterialDesign', function(User, MaterialDesign){
		var vm = this;

		vm.user = User;

		/*
		 * Get the record of the authenticated user.
		 */
		vm.getUser = function(){
			vm.user.get()
				.then(function(data){
					vm.user.set(data.data);

					vm.user.pusher();
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

		vm.init = function(){
			vm.getUser();
		}();

		// $scope.changePassword = function()
		// {
		// 	$mdDialog.show({
		//       controller: 'changePasswordDialogController',
		//       templateUrl: '/app/shared/templates/dialogs/change-password-dialog.template.html',
		//       parent: angular.element(document.body),
		//       fullscreen: true,
		//     })
		//     .then(function(){
		//     	Helper.notify('Password changed.')
		//     });
		// }

		// var uploader = {};

		// uploader.filter = {
  //           name: 'photoFilter',
  //           fn: function(item /*{File|FileLikeObject}*/, options) {
  //               var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
  //               return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
  //           }
  //       };

  //       uploader.sizeFilter = {
		//     'name': 'enforceMaxFileSize',
		//     'fn': function (item) {
		//         return item.size <= 2000000;
		//     }
  //       }

  //       uploader.error = function(item /*{File|FileLikeObject}*/, filter, options) {
  //           $scope.fileError = true;
  //           $scope.photoUploader.queue = [];
  //       };

  //       uploader.headers = { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')};

		// $scope.clickUpload = function(){
		//     angular.element('#upload').trigger('click');
		// };

		// $scope.markAllAsRead = function(){
		// 	Helper.post('/user/mark-all-as-read')
		// 		.success(function(){
		// 			$scope.user.unread_notifications = [];
		// 		})
		// }

		// var fetchUnreadNotifications = function(){
		// 	Helper.post('/user/check')
	 //    		.success(function(data){
	 //    			$scope.user = data;
	 //    		});
		// }

		// Helper.post('/user/check')
		// 	.success(function(data){
		// 		var notifications = {
		// 			'state': 'main.notifications',
		// 			'icon': 'mdi-bell',
		// 			'label': 'Notifications',
		// 			'show': true,
		// 		}

		// 		$scope.menu.static.push(notifications);

		// 		$scope.user = data;

		// 		$scope.currentTime = Date.now();

		// 		Helper.setAuthUser(data);

		// 		/* Photo Uploader */
		// 		$scope.photoUploader = new FileUploader({
		// 			url: '/user/upload-avatar/' + $scope.user.id,
		// 			headers: uploader.headers,
		// 			queueLimit : 1
		// 		})

		// 		// FILTERS
		//         $scope.photoUploader.filters.push(uploader.filter);
		//         $scope.photoUploader.filters.push(uploader.sizeFilter);
		        
		// 		$scope.photoUploader.onWhenAddingFileFailed = uploader.error;
		// 		$scope.photoUploader.onAfterAddingFile  = function(){
		// 			$scope.fileError = false;
		// 			if($scope.photoUploader.queue.length)
		// 			{	
		// 				$scope.photoUploader.uploadAll()
		// 			}
		// 		};

		// 		$scope.photoUploader.onCompleteItem  = function(data, response){
		// 			if($scope.user.avatar_path)
		// 			{
		// 				$scope.currentTime = Date.now();
		// 				$scope.photoUploader.queue = [];
		// 			}
		// 			else{
		// 				$state.go($state.current, {}, {reload:true});
		// 			}
		// 		}

		// 		var pusher = new Pusher('ade8d83d4ed5455e3e18', {
		// 	      	encrypted: true,
		// 	      	auth: {
		// 			    headers: {
		// 			      'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		// 			    }
		// 		  	}
		// 	    });

		// 		var channel = {};

		// 		channel.user = pusher.subscribe('private-App.User.' + $scope.user.id);

		// 		channel.user.bindings = [
		// 		 	channel.user.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
		// 		 		// formating the notification
		// 		 		data.created_at = data.attachment.created_at;

		// 		 		data.data = {};
		// 		 		data.data.attachment = data.attachment;
		// 		 		data.data.url = data.url;
		// 		 		data.data.withParams = data.withParams;
		// 		 		data.data.sender = data.sender;
		// 		 		data.data.message = data.message;

		// 		 		// pushes the new notification in the unread_notifications array
		// 		 		$scope.$apply(function(){
		// 			    	$scope.user.unread_notifications.unshift(data);
		// 		 		});

		// 		 		// notify the user with a toast message
		// 		 		Helper.notify(data.sender.name + ' ' + data.message);

		// 		 		if($state.current.name == data.data.url)
		// 				{
		// 					$state.go($state.current, {}, {reload:true});
		// 				}
		// 		    }),
		// 		];
		// 	})

		// $scope.markAsRead = function(notification){
		// 	Helper.post('/user/mark-as-read', notification)
		// 		.success(function(){
		// 			var index = $scope.user.unread_notifications.indexOf(notification);

		// 			$scope.user.unread_notifications.splice(index, 1);
		// 		})
		// 		.error(function(){
		// 			Helper.error();
		// 		});
		// }

		// $scope.read = function(notification){			
		// 	$state.go(notification.data.url);

		// 	$scope.markAsRead(notification);
		// }
	}]);