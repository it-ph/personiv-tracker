shared
  .factory('Experience', Experience)

  Experience.$inject = ['$http'];

  function Experience($http) {
    return {
      store: store,
    }

    function store(experience) {
      return $http.post('/experience', experience);
    }
  }
