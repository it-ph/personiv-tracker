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