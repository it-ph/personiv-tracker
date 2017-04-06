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