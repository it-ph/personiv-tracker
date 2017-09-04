var project40 = angular.module('project40App',['ui.router','ui.bootstrap']);

app.config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    $urlRouterProvider.otherwise('/');
    $stateProvider
    .state('home', {
          url: '/home',
          templateUrl: 'ng/partials/home.html',
		      controller: 'HomeController',
          controllerAs: 'vmHome'
      })
      .state('login', {
            url: '/login',
            templateUrl: 'ng/partials/login.html',
  		      controller: 'LoginController',
            controllerAs: 'vmLogin'
        })
      $locationProvider.html5Mode(false);
});
