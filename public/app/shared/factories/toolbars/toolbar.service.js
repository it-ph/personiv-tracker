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
			factory.content.sortType = filter.type;
			factory.content.sortReverse = filter.sortReverse;
		}

		/**
		 * Toggles deleted records list
		*/
		factory.toggleActive = function(){
			factory.content.showInactive = !factory.content.showInactive.showInactive;
		}

		/**
		 * Toggles deleted records list
		*/
		factory.searchUserInput = function(data){
			factory.toolbar.content.search(data);
		}

		return factory;
	}]);