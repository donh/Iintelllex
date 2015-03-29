'use strict';
var itApp = angular.module('itApp', ['flow', 'ngRoute']);
// var itApp = angular.module('itApp', ['flow']);
// var itApp = angular.module('itApp');

/**
 * @config:			itApp.config(['$routeProvider', '$locationProvider'])
 * @description:	This config sets routing.
 * @related issues:	ITL-003
 * @param:			void
 * @return:			void
 * @author:			Don Hsieh
 * @since:			03/29/2015
 * @last modified: 	03/29/2015
 * @called by:		URL
 */
// http://viralpatel.net/blogs/angularjs-routing-and-views-tutorial-with-example/
// https://docs.angularjs.org/api/ngRoute/service/$route#example
itApp.config(['flowFactoryProvider', '$routeProvider', '$locationProvider', function(flowFactoryProvider, $routeProvider, $locationProvider) {
// itApp.config(['flowFactoryProvider', function(flowFactoryProvider) {
	flowFactoryProvider.defaults = {
			target: '',
			permanentErrors: [500, 501],
			maxChunkRetries: 1,
			chunkRetryInterval: 5000,
			simultaneousUploads: 1
		};
		flowFactoryProvider.on('catchAll', function (event) {
			console.log('catchAll', arguments);
		});
		// Can be used with different implementations of Flow.js
		// flowFactoryProvider.factory = fustyFlowFactory;
	}
	// $routeProvider
	// 	.when('/login', {
	// 		templateUrl: '/templates/login.html',
	// 		controller: 'LoginController',
	// 	})
	// 	.when('/signup', {
	// 		templateUrl: '/templates/signup.html',
	// 		controller: 'SignupController',
	// 	})
	// 	.otherwise({
	// 		redirectTo: '/'
	// 	});
	// 	$locationProvider.html5Mode(true);
	// }
]);



// itApp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
// 	$routeProvider
// 		// .when('/login', {
// 		// 	templateUrl: '/templates/login.html',
// 		// 	controller: 'LoginController',
// 		// })
// 		// .when('/signup', {
// 		// 	templateUrl: '/templates/signup.html',
// 		// 	controller: 'SignupController',
// 		// })
// 		.otherwise({
// 			redirectTo: '/'
// 		});
// 		$locationProvider.html5Mode(true);
// 	}
// ]);


/**
 * @controller:		AppController
 * @description:	This controller opens dress page in a new window.
 * @related issues:	ITL-003
 * @param:			object $scope
 * @param:			object $routeParams
 * @param:			object $http
 * @param:			object $window
 * @param:			object $document
 * @param:			object $compile
 * @param:			object $location
 * @param:			object AUTH_EVENTS
 * @param:			object AuthService
 * @param:			object Session
 * @return:			void
 * @author:			Don Hsieh
 * @since:			03/27/2015
 * @last modified: 	03/27/2015
 * @called by:		<body ng-controller="AppController">
 *					 in php/public/index.html
 */
itApp.controller('AppController', function ($scope, $routeParams, $http, $window, $document, $compile, $location) {
	$scope.$location = $location;
	$scope.$path = $location.$$path;
	// $scope.studentShow = false;
	$scope.studentShow = true;
	$scope.practictionerShow = false;

	$scope.user = {
		// firstName: '',
		// lastName: '',
		// username: '',
		// password: '',
		// password_confirmation: '',
		// email: '',
		photo: '',
		institution: '',
		graduationYear: '',
		company: '',
		supervisor: '',
		competition: '',
		result: '',
		publicationName: '',
		publicationType: '',
		publicationUrl: '',
		publicationCitation: '',
	};

	/**
	 * @function name:	$scope.setUserType = function(userType)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/27/2015
	 * @last modified: 	03/27/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setUserType = function(userType)
	{
		$scope.studentShow = false;
		$scope.practictionerShow = false;
		// console.log('userType =', userType);
		if (userType === 'student') {
			$scope.studentShow = !$scope.studentShow;
			// $scope.studentShow = true;
			$scope.PractictionerShow = false;
		} else if (userType === 'practictioner') {
			// console.log('$scope.practictionerShow =', $scope.practictionerShow);
			$scope.practictionerShow = !$scope.practictionerShow;
			// $scope.practictionerShow = true;
			$scope.studentShow = false;
			// console.log('$scope.practictionerShow =', $scope.practictionerShow);
		} else {
			// $scope.studentShow = false;
			// $scope.PractictionerShow = false;
		}
	};


	/**
	 * @function name:	signup = function (user)
	 * @description:	This function submits user password reset request.
	 * @related issues:	ITL-003
	 * @param:			object user
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/27/2015
	 * @last modified: 	03/27/2015
	 * @called by:		<form id="signupForm" ng-controller="SignupController" ng-submit="signup(user)">
	 *					 in php/public/index.html
	 *					 in php/public/templates/signup.html
	 */
	$scope.signup = function (user)
	{
		console.log('user =', user);
		// if (user.noweddingdate) user.weddingDate = '';
		// // console.log('user.weddingDate =', user.weddingDate);
		// user.url = $location.url();
		// $http.post('/api/signup', user)
		// 	.success(function(data, status, headers, config) {
		// 		// console.log('data =', data);
		// 		$scope.setMessages(data.messages);
		// 	})
		// 	.error(function(data, status, headers, config) {
		// 		$scope.status = status;
		// 	});
	};



	/**
	 * @function name:	signup = function (user)
	 * @description:	This function submits user password reset request.
	 * @related issues:	ITL-003
	 * @param:			object user
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/27/2015
	 * @last modified: 	03/27/2015
	 * @called by:		<form id="signupForm" ng-controller="SignupController" ng-submit="signup(user)">
	 *					 in php/public/index.html
	 *					 in php/public/templates/signup.html
	 */
	// $scope.setYear = function (year)
	// {
	// 	console.log('year =', year);
	// };

	/**
	 * @function name:	signup = function (user)
	 * @description:	This function submits user password reset request.
	 * @related issues:	ITL-003
	 * @param:			object user
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/27/2015
	 * @last modified: 	03/27/2015
	 * @called by:		<form id="signupForm" ng-controller="SignupController" ng-submit="signup(user)">
	 *					 in php/public/index.html
	 *					 in php/public/templates/signup.html
	 */
	// $scope.setMonth = function (month)
	// {
	// 	console.log('month =', month);
	// };

});
