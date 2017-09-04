shared
	.factory('User', ['$http', '$state', '$filter', 'MaterialDesign', 'FileUploader', function($http, $state, $filter, MaterialDesign, FileUploader){
		var factory = {};

		factory.user = {};

		factory.currentTime = Date.now();

		/*
		 * Get the record of the authenticated user.
		 */
		factory.get = function(){
			return $http.post('/user/check');
		}

		factory.update = function(user){
			return $http.put('/user/' + user.id, user);
		}

		factory.resetPassword = function(user){
			return $http.put('/user/reset-password/' + user.id);
		}

		factory.delete = function(id) {
			return $http.delete('/user/' + id);
		}

		factory.clone = function(index) {
			return angular.copy(factory[index]);
		}

		/*
		 * Sets data in the factory
		*/
		factory.set = function(key, value){
			return factory[key] = value;
		}

		/*
		 * Checks if authenticated user is a supervisor
		*/
		factory.isSupervisor = function(){
			var roles = $filter('filter')(factory.user.roles, {name:'Supervisor'}, true);
			return roles.length ? true : false;
		}

		factory.isRankAndFile = function(){
			return factory.user.roles.length ? false : true;
		}

		factory.store = function()
		{
			return $http.post('/user', factory.new);
		}

		factory.enlist = function(query)
		{
			return $http.post('/user/enlist', query);
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
