angular
  .module("app", [])
  .factory("AuthService", AuthService)
  .directive('thumbslike', thumbsUp)
  .directive('thumbsnot', thumbsDown)
  .directive('jplayer', jplayerPlay)
  .directive('jplayerrewind', jplayerRewind)
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

function jplayerRewind() {
  return {
    link: function(scope, element, attrs) {
      function rewind () {
        var currentTime = $('#jp_jplayer_'+ attrs.id).data('jPlayer').status.currentTime;
        if (currentTime > 5) {
            $('#jp_jplayer_'+ attrs.id).jPlayer("play", currentTime - 5);     
        }
      }
      element.on('click', rewind);
    }
  }
}


function thumbsUp($http) {
  return {
    link: function(scope, element, attrs) {
      function rating () {
        $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
        $http.post('/apirest/rating', "rate=positive&data="+attrs.rating).then(
          function(){

            var data = JSON.parse(attrs.rating);

            $('.tup-'+data.id).addClass('fa-thumbs-up-active');
            $('.tdown-'+data.id).attr('disabled');
          }
        )
      }
      element.on('click', rating);
    }
  }
}

function thumbsDown($http) {
  return {
    link: function(scope, element, attrs) {
      function rating () {
        $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
        $http.post('/apirest/rating', "rate=negative&data="+attrs.rating).then(
          function(){

            var data = JSON.parse(attrs.rating);

            $('.tdown-'+data.id).addClass('fa-thumbs-down-active');
            $('.tup-'+data.id).attr('disabled');
          }
        )
      }
      element.on('click', rating);
    }
  }
}


function jplayerPlay() {
  return {
    restrict: 'EA',
    template: '<div></div>',
    link: function(scope, element, attrs) {
      var $control = element,
          $player = $control.children('div'),
          cls = 'pause fa-pause-circle';

      var updatePlayer = function() {
        $player.jPlayer({

          swfPath: '/assets/js/jplayer/',
          supplied: 'mp3',
          solution: 'html, flash',
          preload: 'auto',
          wmode: 'window',
          ready: function () {
            $player
              .jPlayer("setMedia", {mp3: '/assets/songs/' + attrs.audio})
              .jPlayer(attrs.autoplay === 'true' ? 'play' : 'stop');
          },
          play: function() {
            $control.addClass(cls);
            if (attrs.pauseothers === 'true') {
              $player.jPlayer('pauseOthers');
            }
          },
          pause: function() {
            $control.removeClass(cls);
          },
          stop: function() {
            $control.removeClass(cls);
          },
          ended: function() {
            $control.removeClass(cls);
          }
        })
        .end()
        .unbind('click').click(function(e) {
          $player.jPlayer($control.hasClass(cls) ? 'stop' : 'play');
        });
      };
      updatePlayer();
    }
  };
}