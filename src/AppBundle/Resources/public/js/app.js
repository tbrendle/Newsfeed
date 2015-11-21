var myApp = angular.module('twApp',[]);

myApp.controller('TwitterController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {
  $scope.firstId=null;
  $scope.lastId=null;
  $scope.tweets=[];
  $scope.load=false;
  $scope.bufferTop = [];
  $http.get('/api').success(function(result){
    $scope.tweets = result;
    console.log($scope.tweets[0]);
    console.log($scope.tweets[$scope.tweets.length-1]);
    $scope.load =true;
    $timeout(function () {
      twttr.widgets.load();
    }, 30);
  });
  $scope.bottom = function(){
    if($scope.tweets.length>0)
    $http.get('/api/'+$scope.tweets[$scope.tweets.length-1].id+'/desc').success(function(result){
      $scope.tweets = $scope.tweets.concat(result);
      $timeout(function () {
        twttr.widgets.load();
      }, 30);
    });
  };
  $scope.watchtop = function(){
    var id = '';
    if($scope.bufferTop.length>0)
      id = $scope.bufferTop[0].id;
    else if ($scope.tweets.length>0)
      id = $scope.tweets.length;
    if(id.length>0)
      $http.get('/api/'+$scope.tweets[0].id+'/asc').success(function(result){
        $scope.bufferTop = result.concat($scope.bufferTop);
        $timeout(function(){
          $scope.watchtop();
        }, 10000);
      });
    else
      $timeout(function(){
          $scope.watchtop();
      }, 10000);
  };
  $scope.buff = function(){
    $scope.tweets = $scope.bufferTop.concat($scope.tweets);
    $scope.bufferTop=[];
    $timeout(function () {
      twttr.widgets.load();
    }, 30);
  }
  $scope.watchtop();

}]).directive('template', ['$compile', function($compile){
  return {
    scope:{
      show: '='
    },
    link: function(scope, element, attrs){
      console.log('bite');
      scope.$watch('show', function(newValue, oldValue) {
        console.log(oldValue);
        console.log(newValue);
        if (!oldValue && newValue){
          var html = '<div ng-repeat="t in tweets"><blockquote class="twitter-tweet"><a ng-href="https://twitter.com/{{t.author.id}}/status/{{t.id}}"></a></blockquote></div>';
          console.log('html');
          console.log(element);
          element.html(html);
          $compile(element.contents())(scope.$parent);
        }
      });
    }
  };
}]);