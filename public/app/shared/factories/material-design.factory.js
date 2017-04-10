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