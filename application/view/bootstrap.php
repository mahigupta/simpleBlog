<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A Simple Blog</title>
    <link href="/UI/js/libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/UI/css/main.css" rel="stylesheet">

  </head>

  <body ng-app="mgBlog" ng-cloak>

	  <nav class="navbar navbar-default" ng-controller="mainCtrl">

		  <div class="container-fluid">
			  <div class="navbar-header">
				  <a class="navbar-brand" href="/">A Simple Blog</a>
			  </div>

			  <ul class="nav navbar-nav navbar-right">

				<li ng-if="isLoggedIn"><a href="#!/blog/create">Create Blog</a></li>

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						{{username ? username : 'Account'}}
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu" ng-if="isLoggedIn">
					  <li><a href="#!/blog/my">My Blogs</a></li>
					  <li><a href="#!/blog/create">Write Blog</a></li>
					  <li role="separator" class="divider"></li>
					  <li><a href="/logout">Logout</a></li>

					</ul>

					<ul class="dropdown-menu" ng-if="!isLoggedIn">
					  <li><a href="#!/login">Login</a></li>
					  <li><a href="#!/register">Register</a></li>
					</ul>
				  </li>
			  </ul>
		  </div>
	  </nav>

	  <div ng-view class="main-view"></div>

    <script src="/UI/js/libraries/jquery/jquery.min.js"></script>
    <script src="/UI/js/libraries/bootstrap/js/bootstrap.min.js"></script>
	<script src="/UI/js/libraries/angular/angular.min.js"></script>
	<script src="/UI/js/libraries/angular/angular.route.min.js"></script>

	<script src="/UI/js/app.js"></script>
	<script src="/UI/js/controller/mainCtrl.js"></script>
	<script src="/UI/js/controller/blogListCtrl.js"></script>
	<script src="/UI/js/controller/registerCtrl.js"></script>
	<script src="/UI/js/controller/loginCtrl.js"></script>
	<script src="/UI/js/controller/blogCreateCtrl.js"></script>
	<script src="/UI/js/controller/blogViewCtrl.js"></script>
  </body>

</html>
