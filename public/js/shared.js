var shared = angular.module('shared', [
	'ui.router',
	'ngMaterial',
	'ngMessages',
	'infinite-scroll',
	'highcharts-ng',
	'angularMoment',
	'angularFileUpload',
	'ui.bootstrap',
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
		 * Dark themes.
		 */
		$mdThemingProvider.theme('dark-purple').backgroundPalette('deep-purple').dark();
		$mdThemingProvider.theme('dark-orange').backgroundPalette('orange').dark();

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
	.factory('Account', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		factory.data = [];

		factory.enlist = function(query){
			return $http.post('/account/enlist', query);
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
shared
	.factory('MaterialDesign', ['$mdDialog', '$mdToast', function($mdDialog, $mdToast){
		var factory = {}
		/*
		 * Opens an alert dialog.
		 *
		 * @params: title, message
		 */
		factory.alert = function(data){
			return $mdDialog.show(
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
			var dialog = {
		      	controller: data.controller,
		      	templateUrl: data.templateUrl,
		      	parent: angular.element(document.body),
		      	fullscreen: data.fullscreen,
		    }

			return $mdDialog.show(dialog);
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
			return $mdDialog.cancel();
		}

		/*
		 * Hides a dialog and can return a value.
		 */
		factory.hide = function(data){
			return $mdDialog.hide(data);
		}

		/*
		 * Returns a basic error message.
		 */
		factory.error = function(){
			var dialog = {
				'title': 'Oops! Something went wrong!',
				'message': 'An error occured. Please try again later.',
			}

			return factory.alert(dialog);
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

			return factory.confirm(dialog);
		}

		return factory;
	}]);
shared
	.factory('ShiftSchedule', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		factory.index = function(){
			return $http.get('/shift-schedule');
		}

		factory.store = function(){
			return $http.post('/shift-schedule', factory.data);
		}

		factory.update = function(){
			return $http.put('/shift-schedule/' + factory.data.id, factory.data);
		}

		factory.toLocaleTimeString = function(){
			factory.data.from = factory.data.from.toLocaleTimeString();
			factory.data.to = factory.data.to.toLocaleTimeString();
		}

		factory.toDateObject = function(){
			var today = new Date();

			factory.data.from = new Date(today.toDateString() + ' ' + factory.data.from);
			factory.data.to = new Date(today.toDateString() + ' ' + factory.data.to);
		}

		factory.formatTime = function(time){
			if(time.getMinutes() < 30)
			{
				time.setMinutes(30);
			}
			else if(time.getMinutes() > 30)
			{
				time.setHours(time.getHours() + 1);
				time.setMinutes(0);
			}
			
			time.setSeconds(0);

			return time;
		}

		factory.init = function(){
			var now = new Date();

			factory.data = {};
			
			factory.data.from = factory.formatTime(now);
			factory.data.to = factory.formatTime(now);
		}

		return factory;
	}]);
shared
	.factory('Task', ['$http', 'MaterialDesign', 'toolbarService', function($http, MaterialDesign, toolbarService){
		var factory = {}

		// task paginated data
		factory.data = []

		// add search property to enlist query
		factory.search = function(data){
			factory.query.search = data;

			factory.init();
		}

		// refresh the enlist and removes search property
		factory.refresh = function(){
			factory.query.search = null;

			factory.init();
		}

		factory.enlist = function(query){
			return $http.post('/task/enlist', query);
		}

		factory.paginate = function(query, page){
			return $http.post('/task/enlist?page=' + page, query);
		}

		factory.pause = function(){
			return $http.post('/task/pause/' + factory.current.id);
		}

		factory.resume = function(){
			return $http.post('/task/resume/' + factory.current.id, factory.current.pauses[0]);
		}

		factory.finish = function(){
			return $http.post('/task/finish/' + factory.current.id, factory.current.pauses.length ? factory.current.pauses[0] : null);
		}

		factory.delete = function(id){
			return $http.delete('/task/' + id);
		}

		// format task item
		factory.formatData = function(data){
			data.created_at = new Date(data.created_at);
			data.ended_at = data.ended_at ? new Date(data.ended_at) : null; 
		}

		// push paginated task to paginated data
		factory.pushItem = function(data){
			factory.data.push(data);
		}

		// add items to toolbar autocomplete search
		factory.setToolbarItems = function(data){
			var entry = {}

			entry.display = data.title;
			entry.date = new Date(data.created_at).toDateString() + new Date(data.ended_at).toDateString();

			toolbarService.items.push(entry);
		}

		return factory;
	}]);
shared
	.factory('toolbarService', ['$http', '$filter', 'MaterialDesign', function($http, $filter, MaterialDesign){
		var factory = {}

		factory.items = [];

		/**
		 * Displays search bar
		*/
		factory.showSearchBar = function(){			
			factory.searchBar = true;
		}

		/**
		 * Hides search bar
		*/
		factory.hideSearchBar = function(){
			factory.searchBar = false;
			factory.searchText = '';
			factory.searchItem = '';
			factory.refresh();
		}

		/**
		 * Autocomplete search from data
		*/
		factory.getItems = function(query){
			var results = query ? $filter('filter')(factory.items, query) : factory.items;
			return results;
		}

		/**
		 * Sorts content list
		*/
		factory.sortBy = function(filter){
			filter.sortReverse = !filter.sortReverse;			
			factory.sortType = filter.type;
			factory.sortReverse = filter.sortReverse;
		}

		/**
		 * Toggles deleted records list
		*/
		factory.toggleActive = function(){
			factory.showInactive = !factory.showInactive.showInactive;
		}

		/**
		 * Deeper search
		*/
		factory.searchUserInput = function(data){
			factory.content.search(data);
		}

		/**
		 * Refresh content list and removes search filter
		*/
		factory.refresh = function(){
			factory.content.refresh();
		}

		/**
		 * Clears auto complete items
		*/
		factory.clearItems = function()
		{
			factory.items = [];
		}

		factory.settings = function(){
			var dialog = {
				templateUrl: '/app/admin/templates/dialogs/settings-dialog.template.html',
				controller: 'settingsDialogController as vm',
			}

			MaterialDesign.customDialog(dialog);
		}

		return factory;
	}]);
shared
	.factory('User', ['$http', '$state', 'MaterialDesign', 'FileUploader', function($http, $state, MaterialDesign, FileUploader){
		var factory = {};

		factory.user = {};

		factory.currentTime = Date.now();

		/*
		 * Get the record of the authenticated user. 
		 */
		factory.get = function(){
			return $http.post('/user/check');
		}

		/*
		 * Sets the user
		*/
		factory.set = function(user){
			factory.user = user;
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
				channel.user.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(notification) {
			 		// formating the notification
			 		notification.created_at = notification.attachment.created_at;

			 		notification.data = {};
			 		notification.data.attachment = notification.attachment;
			 		notification.data.url = notification.url;
			 		notification.data.withParams = notification.withParams;
			 		notification.data.sender = notification.sender;
			 		notification.data.message = notification.message;

			 		// pushes the new notification in the unread_notifications array
		 			factory.user.unread_notifications.unshift(notification);
			 		
			 		// notify the user with a toast message
			 		MaterialDesign.notify(notification.sender.name + ' ' + notification.message);

			 		if($state.current.name == notification.data.url)
					{
						$state.go($state.current, {}, {reload:true});
					}
			    }),
			]
		}

		/*
		 * Mark notification as read
		 *
		*/
		factory.markAsRead = function(notification){
			return $http.post('/user/mark-as-read', notification);
		}

		/*
		 * Remove the notification from the user notification array.
		 *
		*/
		factory.removeNotifications = function(notification){
			var index = factory.user.unread_notifications.indexOf(notification);

			factory.user.unread_notifications.splice(index, 1);
		}

		/*
		 * Mark all unread notifications as read
		 *
		*/
		factory.markAllAsRead = function(){
			return $http.post('/user/mark-all-as-read');
		}

		/*
		 * Read notification and go to the url.
		 *
		*/
		factory.read = function(notification)
		{
			$state.go(notification.data.url);

			factory.markAsRead(notification);
		}

		/*
		 * Clears the unread notifications property of the user.
		 *
		*/
		factory.clearNotifications = function(){
			factory.user.unread_notifications = [];
		}

		/*
		 * Ends the session of the authenticated user. 
		 */
		factory.logout = function(){
			return $http.post('/user/logout');
		}

		factory.checkDefaultPassword = function(){
			return $http.post('/user/check-default-password');
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

		/*
		 * Opens a form to change password.
		 */
		factory.uploader = {};

		factory.uploader.filter = {
            name: 'photoFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };

        factory.uploader.sizeFilter = {
		    'name': 'enforceMaxFileSize',
		    'fn': function (item) {
		        return item.size <= 2000000;
		    }
        }

        factory.uploader.error = function(item /*{File|FileLikeObject}*/, filter, options) {
            MaterialDesign.error();
            factory.photoUploader.queue = [];
        };

        factory.headers = { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')};

        factory.photoUploaderInit = function(){
	        factory.photoUploader = new FileUploader({
				url: '/user/upload-avatar/' + factory.user.id,
				headers: factory.headers,
				queueLimit : 1
			})

			factory.photoUploader.filters.push(factory.uploader.filter);
	        factory.photoUploader.filters.push(factory.uploader.sizeFilter);
	        factory.photoUploader.onWhenAddingFileFailed = factory.uploader.error;
			factory.photoUploader.onAfterAddingFile  = function(){
				if(factory.photoUploader.queue.length)
				{	
					factory.photoUploader.uploadAll()
				}
			};

			factory.photoUploader.onCompleteItem  = function(data, response){
				if(factory.user.avatar_path)
				{
					factory.currentTime = Date.now();
					factory.photoUploader.queue = [];
				}
				else{
					$state.go($state.current, {}, {reload:true});
				}
			}

        	factory.showUploader = true;
        }

		return factory;
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

				return;
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
						vm.service.init();
						MaterialDesign.hide();

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