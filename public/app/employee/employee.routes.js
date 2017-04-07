employee
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
						// controller: 'dashboardContentContainerController as vm',
					},
					'toolbar@main': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						// controller: 'dashboardToolbarController as vm',
					},
					'content@main':{
						templateUrl: '/app/employee/templates/content/home-content.template.html',
					}
				}
			})
	}]);