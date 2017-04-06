var admin = angular.module('app', ['shared']);
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
				}
			})
	}]);
admin
	.factory('Task', ['$http', 'MaterialDesign', function($http, MaterialDesign){
		var factory = {}

		factory.query = {}

		factory.search = function(data){
			factory.query.search = data;

			factory.init();
		}

		factory.init = function(){

		}

		return factory;
	}]);
admin
	.controller('dashboardContentContainerController', ['MaterialDesign','toolbarService', 'Task', function(MaterialDesign, toolbarService, Task){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.task = Task;

		vm.toolbar.parentState = 'Test';

		vm.config = {
			title: {
		        text: 'Point interval unit is one hour'
		    },

		    xAxis: {
		    	type: 'datetime',
		    },

		    series: [{
		        data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2],
		        pointStart: Date.UTC(2010, 3, 6),
		        pointInterval: 1000 * 60 * 60,
		    }],

			navigation: {
		        buttonOptions: {
		            enabled: true
		        }
		    }		    
		}
	}]);
admin
	.controller('dashboardToolbarController', ['MaterialDesign', 'toolbarService', 'Task', function(MaterialDesign, toolbarService, Task){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.toolbar.content = Task;

		vm.toolbar.parentState = null; //string
		vm.toolbar.childState = 'Dashboard'; //string

		vm.toolbar.hideSearchIcon = true; //bool - true if deeper search icon should be hidden
		vm.toolbar.searchAll = false; // bool - true if a deeper search can be executed

		vm.toolbar.options = true; //bool - true if a menu button is needed in the view
		vm.toolbar.showInactive = false; //bool - true if user wants to view deleted records

		// Sort options
		vm.sort = [
			{
				'label': 'Recently added',
				'type': 'created_at',
				'sortReverse': false,
			},
		];
	}]);