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
						// controller: 'reviewsContentContainerController',
					},
					'toolbar@main': {
						templateUrl: '/app/shared/templates/toolbar.template.html',
						// controller: 'reviewsToolbarController',
					},
					'content@main':{
						// templateUrl: '/app/components/reviews/templates/content/reviews-content.template.html',
					}
				}
			})
	}]);