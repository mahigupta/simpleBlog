angular.module('mgBlog')
.controller('LoginCtrl', ['$scope', '$http', '$location', 'checkLoginProvider', function($scope, $http, $location, checkLoginProvider) {
		
	angular.extend($scope, {
		
		loginUser: function() {
			
			$scope.alert = {};
			
			$http.post('/login/authenticate', $scope.user).then(function(response){
				
				if (response.data.status === 'success') {
					window.location = '/';
					return;
				}
				
				$scope.user = {};
				
				$scope.alert = {message: response.data.message, status: 'danger'};
			});
		}
	});
	
	checkLoginProvider.checkLogin().then(function(response){
		if (response.data.ok) {
			$location.path('/');
			$location.replace();
		}
	});
	
		
}]);

