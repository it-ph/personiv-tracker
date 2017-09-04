admin
	.controller('positionsToolbarController', ['MaterialDesign', 'toolbarService', 'User', '$state', 'dataService', function(MaterialDesign, toolbarService, User, $state, dataService){
		var vm = this;

		vm.toolbar = toolbarService;
		vm.toolbar.content = User;

		vm.toolbar.parentState = dataService.get('account').name; //string
		vm.toolbar.childState = 'Positions'; //string

		vm.toolbar.hideSearchIcon = false; //bool - true if deeper search icon should be hidden
		vm.toolbar.searchAll = false; // bool - true if a deeper search can be executed

		vm.toolbar.options = false; //bool - true if a menu button is needed in the view
		vm.toolbar.showInactive = false; //bool - true if user wants to view deleted records

		vm.toolbar.state = $state.current.name;

		// Sort options
		vm.sort = [
			{
				'label': 'Recently added',
				'type': 'created_at',
				'sortReverse': false,
			},
		];
	}]);
