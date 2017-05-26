shared
  .factory('Position', Position)

  Position.$inject = ['$http'];

  function Position($http)
  {
    var factory = {
      index: index,
      set: set,
      get: get,
      enlist: enlist,
    }

    return factory;

    function set(key, value)
    {
      factory[$key] = value;
    }

    function get(key)
    {
      return factory[key];
    }

    function index() {
      return $http.get('/position');
    }

    function enlist(query) {
      return $http.post('/position/enlist', query);
    }
  }
