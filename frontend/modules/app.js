angular.module('app', [])
.controller('Hello', function(oauthJWT, $scope, $http) {

    $scope.greeting = "tudo começa aqui!";

    console.log(oauthJWT);  

    // $http.get('http://172.27.0.3/auth').
    //     then(function(response) {
            
    //     });




})

.service('oauthJWT', function($http) {
    $http.get('http://172.27.0.3/auth').
        then(function(response) {
           
        });    
});