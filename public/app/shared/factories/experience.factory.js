(function() {
  'use strict';

  angular
    .module('shared')
    .factory('Experience', Experience);

    Experience.$inject = ['$http'];

    function Experience($http) {
      return {
        enlist: enlist,
      }

      function enlist(query) {
        return $http.post('/experience/enlist', query);
      }
    }
})();
