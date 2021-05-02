angular
  .module("app", [])
  .factory("AuthService", AuthService)
  .controller("Hello",  function ($scope, AuthService) {
    $scope.hello = "Olá";

    AuthService.auth()
    setTimeout(() => {
      AuthService.list().then(function (response) {
        $scope.playlist = response.playlist;
      });
    }, 200);
    
  
  });
  
function AuthService($http, $q) {
  return {
    auth: function () {
      var promessa = $q.defer();
      $http.post("/apirest/auth").then(function (response) {
        $http.defaults.headers.common.Authorization = "Bearer " + response.data.data.Authorization;
      });
      return promessa.promise;
    },
    list: function () {
      var promessa = $q.defer();
      $http.get("/apirest/list").then(function (response) {
        
        promessa.resolve(response.data.data);
        
      });
      return promessa.promise;
    },
  };
}
