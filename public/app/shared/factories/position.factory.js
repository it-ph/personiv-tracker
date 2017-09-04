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
      store: store,
      update: update,
      detach: detach,
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

    function store(position) {
      return $http.post('/position', position);
    }

    function update(position) {
      return $http.put('/position/' + position.id, position);
    }

    function destroy(id) {
      return $http.delete('/position/' + id);
    }

    function detach(positionId, accountId) {
      return $http.post('/position/detach/' + positionId, {
        position_id: positionId,
        account_id: accountId,
      });
    }
  }
