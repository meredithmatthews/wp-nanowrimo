function WPService($http) {

	var WPService = {
		categories: [],
		posts: [],
		pageTitle: 'Latest Posts:',
		currentPage: 1,
		totalPages: 1,
		currentUser: {}
	};

	function _updateTitle(documentTitle, pageTitle) {
		document.querySelector('title').innerHTML = documentTitle + ' | AngularJS Demo Theme';
		WPService.pageTitle = pageTitle;
	}

	function _setArchivePage(posts, page, headers) {
		WPService.posts = posts;
		WPService.currentPage = page;
		WPService.totalPages = headers('X-WP-TotalPages');
	}

	WPService.getAllCategories = function() {
		if (WPService.categories.length) {
			return;
		}

		return $http.get('wp-json/wp/v2/categories').success(function(res){
			WPService.categories = res;
		});
	};

	WPService.getPosts = function(page) {
		return $http.get('wp-json/wp/v2/entry/?page=' + page + '&order=asc').success(function(res, status, headers){
			page = parseInt(page);

			if ( isNaN(page) || page > headers('X-WP-TotalPages') ) {
				_updateTitle('Page Not Found', 'Page Not Found');
			} else {
				if (page>1) {
					_updateTitle('Posts on Page ' + page, 'Posts on Page ' + page + ':');
				} else {
					_updateTitle('Home', 'Latest Posts:');
				}

				_setArchivePage(res,page,headers);
			}
		});
	};


	return WPService;
}

app.factory('WPService', ['$http', WPService]);