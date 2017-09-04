angular
  .module('shared')
  .factory('dataService', dataService);

  function dataService() {
      var service = {
        set: set,
        get: get,
      }

      return service;

      function set(key, value) {
        service[key] = value;
      }

      function get(key) {
        return service[key];
      }
  }
