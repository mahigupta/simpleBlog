angular.module('mgBlog')
    .controller('BlogCreateCtrl', ['$scope', '$http', '$location', 'checkLoginProvider',
        '$routeParams', 'setTitleProvider',
        function($scope, $http, $location,
            checkLoginProvider, $routeParams, setTitleProvider) {

            angular.extend($scope, {

                maxContentLength: 30000,

                publishBlog: function() {

                    $scope.alert = {};

                    $http.post('/blog/post', $scope.blog).then(function(response) {

                        if (response.data.status === 'success' && response.data.data) {
                            $location.path('/blog/view/' + ($scope.blog.id ? $scope.blog.id : response.data.data));
                            $location.replace();
                        }

                        $scope.blog = '';
                        $scope.alert = { message: response.data.message, status: response.data.status === 'success' ? 'success' : 'danger' };

                    });
                }
            });

            checkLoginProvider.checkLogin().then(function(resp) {
                if (!resp.data.ok) {
                    $location.path('/login');
                    $location.replace();
                }

                var path = $location.path();

                if (path.indexOf('/blog/edit') !== -1) {
                    $http.post('/blog/view', { id: $routeParams.id, slug: $routeParams.slug }).then(function(response) {
                        var data = response.data && response.data.data ? response.data.data[0] : {};

                        if (data.username != resp.data.user) {
                            $location.path('/');
                            $location.replace();
                        }

                        $scope.blog = data;
                        setTitleProvider.setTitle("Editing " + $scope.blog.title);
                    });
                }
            });

        }
    ]);