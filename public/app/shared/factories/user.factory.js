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