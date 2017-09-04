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
					authentication: ['User', '$state', function(User, $state){
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
			})
			.state('main.manage-projects', {
				url: 'projects',
				views: {
					'content-container': {
						templateUrl: '/app/shared/views/content-container.view.html',
						controller: 'projectsContentContainerController as vm',
					},
					'toolbar@main.manage-projects': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						controller: 'projectsToolbarController as vm',
					},
					'content@main.manage-projects':{
						templateUrl: '/app/admin/templates/content/projects-content.template.html',
					},
					'form@main.manage-projects': {
						templateUrl: '/app/admin/templates/content/project-form.template.html',
						controller: 'projectFormController as vm'
					}
				},
			})
			.state('main.manage-positions', {
				url: 'project/{accountId}/positions',
				params: {accountId: null},
				resolve: {
					authorize: ['Account', 'dataService', '$state', '$stateParams', function(Account, dataService, $state, $stateParams){
						return Account.show($stateParams.accountId)
							.then(function(response) {
								dataService.set('account', response.data);
							})
							.catch(function(){
								return $state.go('page-not-found');
							});
					}],
				},
				views: {
					'content-container': {
						templateUrl: '/app/shared/views/content-container.view.html',
						controller: 'positionsContentContainerController as vm',
					},
					'toolbar@main.manage-positions': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						controller: 'positionsToolbarController as vm',
					},
					'content@main.manage-positions':{
						templateUrl: '/app/admin/templates/content/positions-content.template.html',
					},
					'form@main.manage-positions': {
						templateUrl: '/app/admin/templates/content/position-form.template.html',
						controller: 'positionFormController as vm'
					}
				},
			});
	}]);
