admin
	.config(['$stateProvider', function($stateProvider){
		$stateProvider
			.state('main', {
				url: '/',
				views: {
					'': {
						templateUrl: '/app/shared/views/main.view.html',
						controller: 'mainViewController as mainVm',
					},
					'content-container@main': {
						templateUrl: '/app/shared/views/content-container.view.html',
						controller: 'dashboardContentContainerController as vm',
					},
					'toolbar@main': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						controller: 'dashboardToolbarController as vm',
					},
					'content@main':{
						templateUrl: '/app/admin/templates/content/dashboard-content.template.html',
					}
				},
				resolve: {
					authentication: ['MaterialDesign', 'User', '$state', function(MaterialDesign, User, $state){
						return User.get()
							.then(function(data){
								User.set('user', data.data);
							}, function(){
								$state.go('page-not-found');
							});
					}],
				},
			})
			.state('main.manage-users', {
				url: 'users',
				views: {
					'content-container': {
						templateUrl: '/app/shared/views/content-container.view.html',
						controller: 'accountsContentContainerController as vm',
					},
					'toolbar@main.manage-users': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						controller: 'accountsToolbarController as vm',
					},
					'content@main.manage-users':{
						templateUrl: '/app/admin/templates/content/users-content.template.html',
					},
					'form@main.manage-users': {
						templateUrl: '/app/admin/templates/content/user-form.template.html',
						controller: 'userFormController as vm'
					}
				},
			});
	}]);
