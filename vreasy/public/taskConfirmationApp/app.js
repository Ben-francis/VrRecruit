angular.module('taskConfirmationApp',  ['ui.router', 'ngResource'])
.config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    // Use hashtags in URL
    $locationProvider.html5Mode(false);

    $urlRouterProvider.otherwise("/");
    $stateProvider
    .state('index', {
      url: "/",
      templateUrl: "/taskConfirmationApp/templates/index.html",
      controller: 'TaskCtrl'
    })
    .state('task',{
        url: "/task/:id",
        templateUrl: "/taskConfirmationApp/templates/task.html",
        controller: "TaskHistoryCtrl"
    });
   
})
.factory('Task', function($resource) {
    return $resource('/task/:id?format=json',
        {id:'@id'},
        {
            'get': {method:'GET'},
            'save': {method: 'PUT'},
            'create': {method: 'POST'},
            'query':  {method:'GET', isArray:true},
            'remove': {method:'DELETE'},
            'delete': {method:'DELETE'}
        }
    );
})
.factory('TaskHistory',function($resource){
    
    return $resource('/task-history/:id?format=json',
                    { id: '@id'} ,
                    {
                        
                        'query': { method: 'GET', isArray: true }
                    }
                    );
})
.controller('TaskCtrl', function($scope, Task) {
    $scope.tasks = Task.query();
    $scope.markComplete = function(id){
        Task.save({id:id,status:'complete'});
        $scope.tasks=Task.query();
    };
})

.controller('TaskHistoryCtrl',['$scope','$stateParams','Task','TaskHistory', function ($scope,$stateParams, Task, TaskHistory){
               
                $scope.taskHistories = TaskHistory.query({id:$stateParams.id});
                $scope.task = Task.get({id: $stateParams.id});
    }]
 );
