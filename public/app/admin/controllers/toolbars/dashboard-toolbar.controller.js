admin
	.controller('dashboardToolbarController', ['MaterialDesign', 'toolbarService', 'Task', function(MaterialDesign, toolbarService, Task){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.toolbar.content = Task;

		vm.toolbar.parentState = null; //string
		vm.toolbar.childState = 'Dashboard'; //string

		vm.toolbar.hideSearchIcon = true; //bool - true if deeper search icon should be hidden
		vm.toolbar.searchAll = false; // bool - true if a deeper search can be executed

		vm.toolbar.options = false; //bool - true if a menu button is needed in the view
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