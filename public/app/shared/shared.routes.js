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
		 * Dark Purple theme.
		 */
		$mdThemingProvider.theme('dark-purple').backgroundPalette('deep-purple').dark();

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