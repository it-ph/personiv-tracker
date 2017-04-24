shared
	.factory('toolbarService', ['$http', '$filter', 'MaterialDesign', function($http, $filter, MaterialDesign){
		var factory = {}

		factory.items = [];

		/**
		 * Displays search bar
		*/
		factory.showSearchBar = function(){			
			factory.searchBar = true;
		}

		/**
		 * Hides search bar
		*/
		factory.hideSearchBar = function(){
			factory.searchBar = false;
			factory.searchText = '';
			factory.searchItem = '';
			factory.refresh();
		}

		/**
		 * Autocomplete search from data
		*/
		factory.getItems = function(query){
			var results = query ? $filter('filter')(factory.items, query) : factory.items;
			return results;
		}

		/**
		 * Sorts content list
		*/
		factory.sortBy = function(filter){
			filter.sortReverse = !filter.sortReverse;			
			factory.sortType = filter.type;
			factory.sortReverse = filter.sortReverse;
		}

		/**
		 * Toggles deleted records list
		*/
		factory.toggleActive = function(){
			factory.showInactive = !factory.showInactive.showInactive;
		}

		/**
		 * Deeper search
		*/
		factory.searchUserInput = function(data){
			factory.content.search(data);
		}

		/**
		 * Refresh content list and removes search filter
		*/
		factory.refresh = function(){
			factory.content.refresh();
		}

		/**
		 * Clears auto complete items
		*/
		factory.clearItems = function()
		{
			factory.items = [];
		}

		factory.settings = function(){
			var dialog = {
				templateUrl: '/app/admin/templates/dialogs/settings-dialog.template.html',
				controller: 'settingsDialogController as vm',
			}

			MaterialDesign.customDialog(dialog);
		}

		factory.download = function(){
			var dialog = {
				templateUrl: '/app/admin/templates/dialogs/download-dialog.template.html',
				controller: 'downloadDialogController as vm',
			}

			MaterialDesign.customDialog(dialog);
		}

		return factory;
	}]);