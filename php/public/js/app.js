'use strict';
// var itApp = angular.module('itApp', ['flow', 'ngRoute']);
// var itApp = angular.module('itApp', ['flow']);
// var itApp = angular.module('itApp');
var itApp = angular.module('itApp', ['ngRoute']);

/**
 * @config:			itApp.config(['$routeProvider', '$locationProvider'])
 * @description:	This config sets routing.
 * @related issues:	ITL-003
 * @param:			void
 * @return:			void
 * @author:			Don Hsieh
 * @since:			03/29/2015
 * @last modified: 	04/15/2015
 * @called by:		URL
 */
// http://viralpatel.net/blogs/angularjs-routing-and-views-tutorial-with-example/
// https://docs.angularjs.org/api/ngRoute/service/$route#example
// itApp.config(['flowFactoryProvider', '$routeProvider', '$locationProvider', function(flowFactoryProvider, $routeProvider, $locationProvider) {
// // itApp.config(['flowFactoryProvider', function(flowFactoryProvider) {
// 	flowFactoryProvider.defaults = {
// 			target: '',
// 			permanentErrors: [500, 501],
// 			maxChunkRetries: 1,
// 			chunkRetryInterval: 5000,
// 			simultaneousUploads: 1
// 		};
// 		flowFactoryProvider.on('catchAll', function (event) {
// 			console.log('catchAll', arguments);
// 		});
// 		// Can be used with different implementations of Flow.js
// 		// flowFactoryProvider.factory = fustyFlowFactory;
// 	}
// 	// $routeProvider
// 	// 	.when('/login', {
// 	// 		templateUrl: '/templates/login.html',
// 	// 		controller: 'LoginController',
// 	// 	})
// 	// 	.when('/signup', {
// 	// 		templateUrl: '/templates/signup.html',
// 	// 		controller: 'SignupController',
// 	// 	})
// 	// 	.otherwise({
// 	// 		redirectTo: '/'
// 	// 	});
// 	// 	$locationProvider.html5Mode(true);
// 	// }
// ]);



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
 * @controller:		LoginController
 * @description:	This controller opens dress page in a new window.
 * @related issues:	ITL-003
 * @param:			object $scope
 * @param:			object $routeParams
 * @param:			object $http
 * @param:			object $window
 * @param:			object $document
 * @param:			object $compile
 * @param:			object $location
 * @return:			void
 * @author:			Don Hsieh
 * @since:			04/17/2015
 * @last modified: 	04/17/2015
 * @called by:		<body ng-controller="AppController">
 *					 in php/public/index.html
 */
itApp.controller('LoginController', function ($scope, $routeParams, $http, $window, $document, $compile, $location) {

	/**
	 * @function name:	signup = function (user)
	 * @description:	This function submits user signup request.
	 * @related issues:	ITL-003
	 * @param:			object user
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/12/2015
	 * @last modified: 	04/15/2015
	 * @called by:		<form id="user-form" class="form-horizontal" role="form" ng-submit="signup(user)">
	 *					 in php/public/profile_edit.html
	 */
	$scope.login = function (user)
	{
		// var userType = $scope.userType;
		console.log('user =', user);
		// console.log('user =', user);

		$http.post('http://intelllex.com:3000/api/login', user)
			.success(function(data, status, headers, config) {
				console.log('user =', data);
				console.log('type =', user.type);
				// $scope.setMessages(data.messages);
				// if (data.messages.success == 'Your profile has been updated.') {
				if (data.status === 'LOGIN') {
				// if (data.status === 'LOGIN-DONE') {
					// console.log('EDIT-DONE');


					// if (user.type) {	// user has profile
					// 	$window.location = 'http://intelllex.com/index2.php';
					// } else {
					// 	$window.location = 'http://intelllex.com/profile_edit';
					// }
					
					
					// $window.location = 'http://intelllex.com/index2.php';
					// $location.path('/index2.php');
				} else {}
			})
			.error(function(data, status, headers, config) {
				$scope.status = status;
			});
	};

});


/**
 * @controller:		EditController
 * @description:	This controller opens dress page in a new window.
 * @related issues:	ITL-003
 * @param:			object $scope
 * @param:			object $routeParams
 * @param:			object $http
 * @param:			object $window
 * @param:			object $document
 * @param:			object $compile
 * @param:			object $location
 * @return:			void
 * @author:			Don Hsieh
 * @since:			03/27/2015
 * @last modified: 	04/07/2015
 * @called by:		<body ng-controller="AppController">
 *					 in php/public/index.html
 */
itApp.controller('EditController', function ($scope, $routeParams, $http, $window, $document, $compile, $location) {
	$scope.$location = $location;
	$scope.$path = $location.$$path;
	$scope.messages = null;


	/**
	 * @function name:	checkLoginStatus = function ()
	 * @description:	This function checks user's login status.
	 * @related issues:	ITL-003
	 * @param:			void
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/18/2015
	 * @last modified: 	04/18/2015
	 * @called by:		$scope.login = function (credentials)
	 *					 in wdApp.controller('LoginController') in php/public/js/app.js
	 */
	$scope.checkLoginStatus = function ()
	{
		// $scope.loginPopupClose();
		// var arr = {};
		// arr.url = $location.url();

		// $http.get('/api/loginstatus')
		$http.get('http://intelllex.com:3000/api/loginstatus')
			.success(function(data, status, headers, config) {
				console.log('data =', data);
				var user = data.user;
				console.log('user =', user);
				$scope.setCurrentUser(user);
			})
			.error(function(data, status, headers, config) {
				$scope.status = status;
			});
	};

	/**
	 * @function name:	setCurrentUser = function (user)
	 * @description:	This function opens URL in a new window.
	 * @related issues:	WD-112
	 * @param:			object user
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			02/04/2015
	 * @last modified: 	02/13/2015
	 * @called by:		$scope.login = function (credentials)
	 *					 in wdApp.controller('LoginController') in php/public/js/app.js
	 *					function $scope.wdScroll(url, sessionStorage, limit, stop)
	 *					 in php/public/js/app.js
	 */
	$scope.setCurrentUser = function (user)
	{
		if (user) {
			if (!$scope.currentUser) {
				// var navbarAccount = angular.element(document.querySelector('#navbarAccount'));
				// if (navbarAccount.hasClass('hide')) {
				// 	navbarAccount.removeClass('hide');
				// } else {}
				// var navbarFavorites = angular.element(document.querySelector('#navbarFavorites'));
				// if (navbarFavorites.hasClass('hide')) {
				// 	navbarFavorites.removeClass('hide');
				// } else {}
				// var navbarEdit = angular.element(document.querySelector('#navbarEdit'));
				// if (navbarEdit.hasClass('hide')) {
				// 	navbarEdit.removeClass('hide');
				// } else {}
				// var navbarLogout = angular.element(document.querySelector('#navbarLogout'));
				// if (navbarLogout.hasClass('hide')) {
				// 	navbarLogout.removeClass('hide');
				// } else {}
				$scope.currentUser = user;
			}
		}
	};

	// $scope.checkLoginStatus();



	var years = [];
	for (var i=1990 ; i<=2020; i++) {
		years.push(i);
	}
	$scope.years = years;

	$scope.userTypes = ['practitioner', 'student'];
	$scope.userType = 'practitioner';
	// $scope.userType = 'student';

	// $scope.months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	$scope.months = [
		{
			name: 'Jan',
			value: '01',
		},
		{
			name: 'Feb',
			value: '02',
		},
		{
			name: 'Mar',
			value: '03',
		},
		{
			name: 'Apr',
			value: '04',
		},
		{
			name: 'May',
			value: '05',
		},
		{
			name: 'Jun',
			value: '06',
		},
		{
			name: 'Jul',
			value: '07',
		},
		{
			name: 'Aug',
			value: '08',
		},
		{
			name: 'Sep',
			value: '09',
		},
		{
			name: 'Oct',
			value: '10',
		},
		{
			name: 'Nov',
			value: '11',
		},
		{
			name: 'Dec',
			value: '12',
		}
	];
	$scope.types = ['Journal', 'Online Article'];
	$scope.qualifications = ['CFA Level 1', 'CFA Level 2', 'CFA Level 3', 'CPA', 'MBBS', 'Others'];

	$scope.user = {
		// username: '',
		// firstName: '',
		// lastName: '',
		// password: '',
		// password_confirmation: '',
		email: ''
	};
	
	$scope.student = {
		institution: '',
		graduationYear: '',
		degree: '',
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
		qualificationYear: '',
	};

	$scope.publicationType = 'Type';
	$scope.qualification = 'Qualification';

	$scope.jurisdictions = ['Australia', 'Canada', 'Europe', 'Hong Kong', 'India', 'Malaysia', 'New Zealand', 'Singapore', 'United Kingdom', 'Others'];

	$scope.practitioner = {
		jurisdiction: '',
		otherJurisdiction: '',
		admissionYear: '',
		area: '',
		industry: '',
		awardName: '',
		yearAwarded: '',
		publicationName: '',
		publicationType: '',
		publicationUrl: '',
		publicationCitation: '',
	};

	$scope.rowLimit = 3;
	$scope.works = [{company: '', monthFrom: '', yearFrom: '', monthTo: '', yearTo: '', supervisor: ''}];
	$scope.competitions = [{competitionName: '', competitionResult: ''}];
	$scope.admissions = [{jurisdiction: '', otherJurisdiction: '', admissionYear: ''}];
	// $scope.awards = [{awardName: '', awardYear: ''}];
	$scope.publications = [{publicationName: '', type: '', publicationUrl: '', publicationCitation: ''}];
	$scope.others = [{qualificationName: '', otherQualification: '', qualificationYear: ''}];

	/**
	 * @function name:	$scope.addDiv = function(userType)
	 * @description:	This function adds rows for button "+".
	 * @related issues:	ITL-003
	 * @param:			string div
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/10/2015
	 * @last modified: 	04/11/2015
	 * @called by:		<button ng-click="addDiv('work')" ng-show="works.length < rowLimit">
	 *					<button ng-click="addDiv('competition')" ng-show="competitions.length < rowLimit">
	 *					 in php/public/profile_edit.html
	 */
	$scope.addDiv = function(div)
	{
		// console.log('div =', div);
		if (div === 'work') {
			if ($scope.works.length < $scope.rowLimit) {
				$scope.works.push({company: '', monthFrom: '', yearFrom: '', monthTo: '', yearTo: '', supervisor: ''});
				// console.log('$scope.works =', $scope.works);
			} else {}
		} else if (div === 'competition') {
			if ($scope.competitions.length < $scope.rowLimit) {
				$scope.competitions.push({competitionName: '', competitionResult: ''});
				// console.log('$scope.works =', $scope.works);
			} else {}
		} else if (div === 'admission') {
			if ($scope.admissions.length < $scope.rowLimit) {
				$scope.admissions.push({jurisdiction: '', otherJurisdiction: '', admissionYear: ''});
				// console.log('$scope.works =', $scope.works);
			} else {}
		// } else if (div === 'award') {
		// 	if ($scope.awards.length < $scope.rowLimit) {
		// 		$scope.awards.push({awardName: '', awardYear: ''});
		// 	} else {}
		} else if (div === 'publication') {
			if ($scope.publications.length < $scope.rowLimit) {
				$scope.publications.push({publicationName: '', type: '', publicationUrl: '', publicationCitation: ''});
			} else {}
		} else if (div === 'qualification') {
			if ($scope.others.length < $scope.rowLimit) {
				$scope.others.push({qualificationName: '', otherQualification: '', qualificationYear: ''});
			} else {}
		}
	};


	/**
	 * @function name:	edit = function (user)
	 * @description:	This function submits user signup request.
	 * @related issues:	ITL-003
	 * @param:			object user
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/12/2015
	 * @last modified: 	04/15/2015
	 * @called by:		<form id="user-form" class="form-horizontal" role="form" ng-submit="signup(user)">
	 *					 in php/public/profile_edit.html
	 */
	// $scope.signup = function (user, $flow)
	// $scope.signup = function (user)
	$scope.edit = function (user)
	{
		var userType = $scope.userType;
		// console.log('userType =', userType);
		user.userType = userType;
		if (userType === 'student') {
			user.institution = $scope.student.institution;
			user.graduationYear = $scope.student.graduationYear;
			user.degree = $scope.student.degree;
			// user.works = $scope.works;
			user.competitions = $scope.competitions;
			user.others = $scope.others;
		} else if (userType === 'practitioner') {
			user.admissions = $scope.admissions;
			user.area = $scope.practitioner.area;
			user.industry = $scope.practitioner.industry;
			// user.awards = $scope.awards;
		}
		user.works = $scope.works;
		user.publications = $scope.publications;

		if (user.qualification === 'Others' && user.otherQualification.length > 0) {
			user.qualification = user.otherQualification;
		}
		// console.log('user =', user);

		$http.post('http://intelllex.com:3000/api/edit', user)
		// $http.post('http://intelllex.com:3000/api/login', user)
			.success(function(data, status, headers, config) {
				console.log('data =', data);
				// console.log('data.session =', data.session);
				// console.log('data.email =', data.email);
				// console.log('data.firstName =', data.firstName);
				// console.log('data.lastName =', data.lastName);
				// console.log('data.status =', data.status);
				$scope.setMessages(data.messages);
				// if (data.messages.success == 'Your profile has been updated.') {
				if (data.status === 'EDIT-DONE') {
					// console.log('EDIT-DONE');
					// $window.location = '/index2.php';
					$window.location = 'http://intelllex.com/index2.php';
					// $location.path('/index2.php');
				} else {}
			})
			.error(function(data, status, headers, config) {
				$scope.status = status;
			});
	};


	/**
	 * @function name:	setMessages = function (messages)
	 * @description:	This function opens URL in a new window.
	 * @related issues:	ITL-003
	 * @param:			object messages
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/31/2015
	 * @last modified: 	03/31/2015
	 * @called by:		itApp.controller('EditController')
	 *					 in php/public/js/app.js
	 */
	$scope.setMessages = function (messages)
	{
		if (messages) {
			var messageBox = angular.element(document.querySelector('#messageBox'));
			if (messageBox.hasClass('hide')) {
				messageBox.removeClass('hide');
			} else {}
			$scope.messages = messages;
		} else $scope.messages = null;
	};
});
