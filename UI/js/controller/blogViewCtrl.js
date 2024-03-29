angular.module('mgBlog')
    .controller('BlogViewCtrl', ['$scope', '$http', '$routeParams',
        'checkLoginProvider', 'setTitleProvider',
        function($scope, $http, $routeParams, checkLoginProvider, setTitleProvider) {

            angular.extend($scope, {

                commentPage: 0,
                commentLimit: 5,
                currentComment: '',
                commentMaxLength: 1000,

                alert: {},

                fetchBlog: function() {

                    $http.post('/blog/view', { id: $routeParams.id, slug: $routeParams.slug }).then(function(response) {
                        var data = response.data && response.data.data ? response.data.data[0] : {};
                        $scope.blog = data;

                        if ($scope.blog) {
                            setTitleProvider.setTitle($scope.blog.title);
                            $scope.fetchComment();
                        }
                    });
                },

                fetchComment: function() {

                    var page = $scope.commentPage > 0 ? ($scope.commentPage * $scope.commentLimit) : 0;

                    $http.post('/comments/get', { blog_id: $routeParams.id, page: page, limit: $scope.commentLimit }).then(function(response) {
                        var data = response.data && response.data.data ? response.data.data : {};
                        $scope.commentList = data;
                    });
                },

                postComment: function() {

                    $scope.alert = {};

                    $http.post('/comments/post', { blog_id: $routeParams.id, comment: $scope.currentComment }).then(function(response) {

                        if (response.data.status === 'success') {
                            $scope.commentPage = 0;
                            $scope.fetchComment();
                            $scope.blog.comment_count += 1;
                        }

                        $scope.currentComment = '';
                        $scope.alert = { message: response.data.message, status: response.data.status === 'success' ? 'success' : 'danger' };

                    });
                },

                deleteBlog: function(blog) {

                    if (confirm("Are you sure want to delete ?")) {

                        $http.post('/blog/delete', { id: blog.id })
                            .then(function(response) {
                                if (response.data.status === 'success') {
                                    window.location = '#!/';
                                }
                            });
                    }

                }
            });

            checkLoginProvider.checkLogin().then(function(response) {
                $scope.isLoggedIn = response.data.ok;
                $scope.username = response.data.user;
                $scope.fetchBlog();
            });

        }
    ]);