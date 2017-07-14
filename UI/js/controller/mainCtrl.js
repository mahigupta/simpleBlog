/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('mgBlog')
.controller('mainCtrl', ['$scope', '$http', 'checkLoginProvider', function($scope, $http, checkLoginProvider) {
		
	checkLoginProvider.checkLogin().then(function(response){
		$scope.isLoggedIn = response.data.ok;
		
		if (response.data.ok) {
			$scope.username = response.data.user;
		}
	});
		
}]);
