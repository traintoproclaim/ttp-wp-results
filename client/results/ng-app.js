'use strict';

angular.module('ttpResults', [
   'ui.bootstrap',
   'ngRoute',
   'ttpResults.countries'
])
.config(['$routeProvider', function($routeProvider) {
	var baseURL = '/wp/wp-content/plugins/ttp-wp-results/client/results/views';
    $routeProvider.when(
		'/countries', 
		{
			templateUrl: baseURL + '/country.html', 
			controller: 'CountriesCtrl'
		}
    );
    $routeProvider.when(
		'/country/:countryId', 
		{
			templateUrl: baseURL + '/country.html' ,
			controller: 'CountryCtrl'
		}
	);
    $routeProvider.otherwise({redirectTo: '/countries'});
}])
.controller('NavCtrl', ['$scope',
                         function($scope) {
}])
;
