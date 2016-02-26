var myApp = angular.module('twApp',[]);

myApp.controller('TwitterController', ['$scope', '$http', '$timeout', '$window', '$document',  function($scope, $http, $timeout, $window, $document) {
  $scope.typeCount = 2;
  $scope.currentType = 1;
  $scope.alreadyDisplayed={};
  $scope.tw = [];
  $scope.bufferTop = [];
  for (var j = 1; j <= $scope.typeCount; j++) {
    $scope.tw.push([]);
    $scope.bufferTop.push([]);
  }
 $scope.writeTweet = function(tweet){
    if($scope.alreadyDisplayed[tweet.id]===undefined){
      $scope.alreadyDisplayed[tweet.id]=true;
      return '<blockquote class="twitter-tweet"><a href="https://twitter.com/'+tweet.author.id+'/status/'+tweet.id+'"></a></blockquote>';
    } else {
      console.log("Warning:tweet from"+tweet.author.id+" of id "+tweet.id+" already displayed");
      return "";
    }
  }

  $scope.addElements = function(type, tweets, top){
    var el = angular.element(document.getElementById("tweetArea"+(type-1)));
    console.log(tweets)
    var len = tweets.length;
    if(!top){
      $scope.tw[type-1] = $scope.tw[type-1].concat(tweets);
      for (var i = 0; i < len; i++) {
        el.append($scope.writeTweet(tweets[i]));
      }
    } else {
      $scope.tw[type-1] = tweets.concat($scope.tw[type-1]);
      for (var i = len-1; i >= 0; i--) {
        el.prepend($scope.writeTweet(tweets[i]));
      }
    }
    twttr.widgets.load();
  }
  $scope.loading = true;
  for (var i = 1; i <= $scope.typeCount; i++) {
    (function(index){
      $http.get('/api/'+index).success(function(result){
        $scope.addElements(index, result);
        $scope.loading = false;
    });})(i)
  }
  $scope.swap = function(){
    console.log('swap');
    var newType = $scope.currentType%$scope.typeCount+1;
    $scope.$evalAsync(function(){
      $scope.currentType = newType;
    });
  };

  $window.onscroll = function(ev) {
    console.log('scroll');
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight  && !$scope.loading) {
      $scope.loading=true;
      $scope.bottom($scope.currentType);
    } 
  }; 
  $scope.bottom = function(type){
    if($scope.tw[type-1].length>0){
      console.log("CALLING bottom")
      $http.get('/api/'+type+'/'+$scope.tw[type-1][$scope.tw[type-1].length-1].id+'/desc').success(function(result){
        $scope.addElements(type, result);
        $timeout(function(){
          $scope.loading = false;
        }, 5000);
      });
    } else
      $scope.loading = false;
  };
  $scope.watchtop = function(type){
    var id = '';
    if($scope.bufferTop[type-1].length>0)
      id = $scope.bufferTop[type-1][0].id;
    else if ($scope.tw[type-1].length>0)
      id = $scope.tw[type-1][0].id;
    if(id.length>0)
      $http.get('/api/'+type+'/'+id+'/asc').success(function(result){
        console.log(result);
        $scope.bufferTop[type-1] = result.concat($scope.bufferTop[type-1]);
        $timeout(function(){
          $scope.watchtop($scope.currentType);
        }, 10000);
      });
    else
      $timeout(function(){
          console.log(('timeouted'));
          $scope.watchtop($scope.currentType);
      }, 10000);
  };
  $scope.buff = function(){
    console.log($scope.bufferTop)
    for (var i = 1; i <= $scope.typeCount; i++) {
      $scope.addElements(i, $scope.bufferTop[i-1], true);
      $scope.bufferTop[i-1]=[];
    }
  };
  $scope.watchtop($scope.currentType);

}]);