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
 * @return:			void
 * @author:			Don Hsieh
 * @since:			03/27/2015
 * @last modified: 	04/07/2015
 * @called by:		<body ng-controller="AppController">
 *					 in php/public/index.html
 */
itApp.controller('AppController', function ($scope, $routeParams, $http, $window, $document, $compile, $location) {
	$scope.$location = $location;
	$scope.$path = $location.$$path;
	$scope.messages = null;
	// $scope.userType = false;
	// $scope.studentShow = true;
	// $scope.practictionerShow = false;

	
	// $scope.studentShow = false;
	// $scope.practictionerShow = true;

	var years = [];
	for (var i=1990 ; i<=2020; i++) {
		years.push(i);
	}
	$scope.years = years;

	// $scope.userTypes = ['student', 'practictioner'];
	$scope.userTypes = ['practictioner', 'student'];
	$scope.userType = 'practictioner';
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
		username: '',
		firstName: '',
		lastName: '',
		password: '',
		password_confirmation: '',
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

	// $scope.graduationYear = 'Year';
	// $scope.monthFrom = 'Month';
	// $scope.monthTo = 'Month';
	// $scope.yearFrom = 'Year';
	// $scope.yearTo = 'Year';
	$scope.publicationType = 'Type';
	$scope.qualification = 'Qualification';
	// $scope.qualificationYear = 'Year';
	// $scope.yearAwarded = 'Year';

	$scope.jurisdictions = ['Australia', 'Canada', 'Europe', 'Hong Kong', 'India', 'Malaysia', 'New Zealand', 'Singapore', 'United Kingdom', 'Others'];

	$scope.practictioner = {
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

	/**
	 * @function name:	$scope.setUserType = function(userType)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string userType
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/27/2015
	 * @last modified: 	04/07/2015
	 * @called by:		<a ng-click="setUserType(type)" role="menuitem">{{type}}</a>
	 *					 in php/public/profile_edit.html
	 */
	// $scope.setUserType = function(userType)
	// {
	// 	$scope.userType = userType;
	// 	$scope.studentShow = false;
	// 	$scope.practictionerShow = false;
	// 	console.log('userType =', userType);
	// 	if (userType === 'student') {
	// 		$scope.studentShow = !$scope.studentShow;
	// 		$scope.PractictionerShow = false;
	// 	} else if (userType === 'practictioner') {
	// 		$scope.practictionerShow = !$scope.practictionerShow;
	// 		$scope.studentShow = false;
	// 	} else {
	// 	}
	// };

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
	 * @function name:	signup = function (user)
	 * @description:	This function submits user signup request.
	 * @related issues:	ITL-003
	 * @param:			object user
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/12/2015
	 * @last modified: 	04/12/2015
	 * @called by:		<form id="user-form" class="form-horizontal" role="form" ng-submit="signup(user)">
	 *					 in php/public/profile_edit.html
	 */
	// $scope.signup = function (user, $flow)
	$scope.signup = function (user)
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
		} else if (userType === 'practictioner') {
			user.admissions = $scope.admissions;
			user.area = $scope.practictioner.area;
			user.industry = $scope.practictioner.industry;
			// user.awards = $scope.awards;
		}
		user.works = $scope.works;
		user.publications = $scope.publications;

		if (user.qualification === 'Others' && user.otherQualification.length > 0) {
			user.qualification = user.otherQualification;
		}
		// console.log('user =', user);

		$http.post('http://intelllex.com:3000/api/user', user)
			.success(function(data, status, headers, config) {
				// console.log('data =', data);
				// console.log('data.status =', data.status);
				$scope.setMessages(data.messages);
				// if (data.messages.success == 'Your profile has been updated.') {
				if (data.status === 'EDIT-DONE') {
					// console.log('EDIT-DONE');
					$window.location = '/index2.php';
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