angular.module('mgBlog')
    .controller('BlogListCtrl', ['$scope', '$http', '$location', 'checkLoginProvider', function($scope, $http, $location, checkLoginProvider) {

        angular.extend($scope, {
            page: 0,
            limit: 5,
            blogList: [],
            my: false,

            fetchListing: function() {

                var url = $scope.my ? '/blog/myBlogs' : '/blog/listing';
                var page = $scope.page > 0 ? ($scope.page * $scope.limit) : 0;

                $http.post(url, { page: page, limit: $scope.limit })
                    .then(function(response) {
                        var data = response.data && response.data.data ? response.data.data : [];
                        $scope.blogList = angular.copy(data);
                    });
            },

            deleteBlog: function(blog) {

                if (confirm("Are you sure want to delete ?")) {

                    $http.post('/blog/delete', { id: blog.id })
                        .then(function(response) {
                            if (response.data.status === 'success') {
                                $scope.fetchListing();
                            }
                        });
                }

            }
        });



        checkLoginProvider.checkLogin().then(function(response) {

            $scope.my = $location.path() === '/blog/my';
            $scope.isLoggedIn = response.data.ok;

            if (!response.data.ok && $scope.my) {
                $location.path('/login');
                $location.replace();
                return;
            }

            $scope.username = response.data.user;

            $scope.fetchListing();
        });
    }]);