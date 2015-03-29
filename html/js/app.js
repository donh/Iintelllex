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
	$scope.userType = false;
	// $scope.studentShow = false;
	$scope.studentShow = true;
	$scope.practictionerShow = false;


	var years = [];
	for (var i=1990 ; i<=2020; i++) {
		years.push(i);
	}
	$scope.years = years;

	// var months = [];
	// for (var i=1 ; i<=12; i++) {
	// 	months.push(i);
	// }
	// $scope.months = months;
	$scope.months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	$scope.types = ['Journal', 'Online Article'];
	$scope.qualifications = ['CFA Level 1', 'CFA Level 2', 'CFA Level 3', 'CPA', 'MBBS', 'Others'];
	
	$scope.user = {
		// firstName: '',
		// lastName: '',
		// username: '',
		// password: '',
		// password_confirmation: '',
		// email: '',
		// photo: '',
		// userType: '',
		institution: '',
		graduationYear: '',
		company: '',
		monthFrom: '',
		yearFrom: '',
		monthTo: '',
		yearTo: '',
		supervisor: '',
		competitionName: '',
		competitionResult: '',
		publicationName: '',
		publicationType: '',
		publicationUrl: '',
		publicationCitation: '',
		qualification: '',
		otherQualification: '',
		// otherOthers: '',
		otherYear: '',
	};

	$scope.graduationYear = 'Year';
	$scope.monthFrom = 'Month';
	$scope.monthTo = 'Month';
	$scope.yearFrom = 'Year';
	$scope.yearTo = 'Year';
	$scope.publicationType = 'Type';
	$scope.qualification = 'Qualification';
	$scope.otherYear = 'Year';

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
	// $scope.signup = function (user, $flow)
	$scope.editStudent = function (student)
	{
		// console.log('student =', student);
		// var graduationYear = angular.element(document.querySelector('#graduationYear')).val();
		// console.log('graduationYear =', graduationYear);

		// var monthFrom = angular.element(document.querySelector('#monthFrom')).val();
		// console.log('monthFrom =', monthFrom);
		// var yearFrom = angular.element(document.querySelector('#yearFrom')).val();
		// console.log('yearFrom =', yearFrom);
		// var monthTo = angular.element(document.querySelector('#monthTo')).val();
		// console.log('monthTo =', monthTo);
		// var yearTo = angular.element(document.querySelector('#yearTo')).val();
		// console.log('yearTo =', yearTo);
		// var publicationType = angular.element(document.querySelector('#publicationType')).val();
		// console.log('publicationType =', publicationType);

		// student.graduationYear = graduationYear;
		// student.monthFrom = monthFrom;
		// student.yearFrom = yearFrom;
		// student.monthTo = monthTo;
		// student.yearTo = yearTo;
		// student.userType = $scope.userType;
		student.graduationYear = $scope.graduationYear;
		student.monthFrom = $scope.monthFrom;
		student.yearFrom = $scope.yearFrom;
		student.monthTo = $scope.monthTo;
		student.yearTo = $scope.yearTo;
		// student.publicationType = publicationType;
		student.publicationType = $scope.publicationType;
		// student.otherQualification = angular.element(document.querySelector('#otherQualification')).val();
		// student.otherOthers = angular.element(document.querySelector('#otherOthers')).val();
		// student.otherYear = angular.element(document.querySelector('#otherYear')).val();
		student.qualification = $scope.qualification;
		// student.otherQualification = $scope.otherQualification;
		// student.otherOthers = $scope.otherOthers;
		student.otherYear = $scope.otherYear;
		console.log('student =', student);

		// student.url = $location.url();
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
	 * @function name:	setGraduationYear = function(graduationYear)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string graduationYear
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setGraduationYear = function(graduationYear)
	{
		console.log('graduationYear =', graduationYear);
		$scope.graduationYear = graduationYear;
	};

	/**
	 * @function name:	setMonthFrom = function(monthFrom)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setMonthFrom = function(monthFrom)
	{
		console.log('monthFrom =', monthFrom);
		$scope.monthFrom = monthFrom;
	};


	/**
	 * @function name:	setMonthFrom = function(monthFrom)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setMonthTo = function(monthTo)
	{
		console.log('monthTo =', monthTo);
		$scope.monthTo = monthTo;
	};



	/**
	 * @function name:	setYearFrom = function(yearFrom)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setYearFrom = function(yearFrom)
	{
		console.log('yearFrom =', yearFrom);
		$scope.yearFrom = yearFrom;
	};


	/**
	 * @function name:	setYearFrom = function(yearFrom)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setYearTo = function(yearTo)
	{
		console.log('yearTo =', yearTo);
		$scope.yearTo = yearTo;
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
	$scope.setPublicationType = function(publicationType)
	{
		console.log('publicationType =', publicationType);
		$scope.publicationType = publicationType;
	};



	/**
	 * @function name:	setYearFrom = function(yearFrom)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setQualification = function(qualification)
	{
		console.log('qualification =', qualification);
		$scope.qualification = qualification;
	};


	/**
	 * @function name:	setOtherYear = function(yearFrom)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setOtherYear = function(otherYear)
	{
		console.log('otherYear =', otherYear);
		$scope.otherYear = otherYear;
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
		// $scope.userType = userType;
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
			// $scope.userType = false;
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
