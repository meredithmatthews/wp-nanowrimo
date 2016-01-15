var app = angular.module('app', ['ngRoute', 'ngSanitize', 'slick']);

//Config the route
app.config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
	$locationProvider.html5Mode(true);

	$routeProvider
		.when('/', {
			templateUrl: myLocalized.partials + 'main.html',
			controller: 'Main'
		})
		.otherwise({
			templateUrl: myLocalized.partials + 'main.html',
			controller: 'Main'
		});

	$httpProvider.interceptors.push([function() {
		return {
			'request': function(config) {
				config.headers = config.headers || {};
				//add nonce to avoid CSRF issues
				config.headers['X-WP-Nonce'] = myLocalized.nonce;

				return config;
			}
		};
	}]);
}]);

//Main controller
app.controller('Main', ['$scope', 'WPService', function($scope, WPService) {
	WPService.getAllCategories();
	WPService.getPosts(1);
	$scope.data = WPService;
}]);

//Paged controller
app.controller('Paged', ['$scope', '$routeParams', 'WPService', function($scope, $routeParams, WPService) {
	WPService.getAllCategories();
	WPService.getPosts($routeParams.page);
	$scope.data = WPService;
}]);

//postsNavLink Directive
app.directive('postsNavLink', function() {
	return {
		restrict: 'EA',
		templateUrl: myLocalized.partials + 'posts-nav-link.html',
		controller: ['$scope', '$element', '$routeParams', function($scope, $element, $routeParams) {
			var currentPage = (!$routeParams.page) ? 1 : parseInt($routeParams.page),
				linkPrefix = (!$routeParams.category) ? 'page/' : 'category/' + $routeParams.category + '/page/';

			$scope.postsNavLink = {
				prevLink: linkPrefix + (currentPage - 1),
				nextLink: linkPrefix + (currentPage + 1),
				sep: (!$element.attr('sep')) ? '|' : $element.attr('sep'),
				prevLabel: (!$element.attr('prev-label')) ? 'Previous Page' : $element.attr('prev-label'),
				nextLabel: (!$element.attr('next-label')) ? 'Next Page' : $element.attr('next-label')
			};
		}]
	};
});
