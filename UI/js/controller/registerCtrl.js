angular.module('mgBlog')
.controller('RegisterCtrl', ['$scope', '$http', '$location', 'checkLoginProvider', function($scope, $http, $location, checkLoginProvider) {
		
	angular.extend($scope, {
		
		user: {},
		passwordMinLength: 6,
		passwordMaxLength: 14,
		userNameMaxLength: 20,

		notValid: function() {
			
			return !$scope.user.username || !$scope.user.password || !$scope.user.repassword || 
					($scope.user.password !== $scope.user.repassword) ||
					($scope.user.password.length < $scope.passwordMinLength) ||
					($scope.user.password.length > $scope.passwordMaxLength) ||
					($scope.user.username.length > $scope.userNameMaxLength);
					
		},
		
		registerUser: function() {
			$scope.alert = {};
			
			$http.post('/register', $scope.user).then(function(response){
				
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

