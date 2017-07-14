'use strict';

angular.module('mgBlog', ['ngRoute'])
		
		.factory('checkLoginProvider', ['$http', function($http){
				return {
					checkLogin: function() {
						return $http.post('/login/check');
					}
				}
		}])
		.factory('setTitleProvider', [function(){
				return {
					setTitle: function(title) {
						window.document.title = 'A Simple Blog - ' + title;
					}
				};
		}])
		.factory('myInterceptor', ['$q', function($q){
				return {
					response: function(response) {
						if(response.data.status === 'error') {
							alert(response.data.message);
						}
						return response || $q.when(response);
					}
				}
		}])
		.config(['$httpProvider', function($httpProvider) {
			// add xmlhttprequest header will all request
			$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
			$httpProvider.interceptors.push('myInterceptor');
	
		}])
		.config(['$routeProvider', function($routeProvider){
				$routeProvider.when('/', {
					templateUrl: 'UI/template/list.html',
					controller: 'BlogListCtrl',
					resolve: {
						title: ['setTitleProvider', function(setTitleProvider){
							setTitleProvider.setTitle('Listing');	
						}]
					}
				})
				.when('/login', {
					templateUrl: 'UI/template/login.html',
					controller: 'LoginCtrl',
					resolve: {
						title: ['setTitleProvider', function(setTitleProvider){
							setTitleProvider.setTitle('Login');	
						}]
					}
				})
				.when('/register', {
					templateUrl: 'UI/template/register.html',
					controller: 'RegisterCtrl',
					resolve: {
						title: ['setTitleProvider', function(setTitleProvider){
							setTitleProvider.setTitle('Registration');	
						}]
					}
				})
				.when('/blog/create', {
					templateUrl: 'UI/template/blog_create.html',
					controller: 'BlogCreateCtrl',
					resolve: {
						title: ['setTitleProvider', function(setTitleProvider){
							setTitleProvider.setTitle('Create blog');	
						}]
					}
				})
				.when('/blog/edit/:id', {
					templateUrl: 'UI/template/blog_create.html',
					controller: 'BlogCreateCtrl'
				})
				.when('/blog/my', {
					templateUrl: 'UI/template/list.html',
					controller: 'BlogListCtrl',
					resolve: {
						title: ['setTitleProvider', function(setTitleProvider){
							setTitleProvider.setTitle('My Blogs');	
						}]
					}
				})
				.when('/blog/view/:id', {
					templateUrl: 'UI/template/blog_view.html',
					controller: 'BlogViewCtrl'
				})
				
				$routeProvider.otherwise({
					redirectTo: '/'
				});
		}])
	