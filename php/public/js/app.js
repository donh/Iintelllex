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
 * @last modified: 	03/29/2015
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
	$scope.userType = false;
	$scope.studentShow = true;
	$scope.practictionerShow = false;
	// $scope.studentShow = false;
	// $scope.practictionerShow = true;

	// $scope.lotteryModel = [
	// 	{
	// 		id: 1,
	// 		ProductName: '威力彩'
	// 	},
	// 	{
	// 		id: 2,
	// 		ProductName: '今彩539'
	// 	},
	// 	{
	// 		id: 3,
	// 		ProductName: '大樂透'
	// 	}
	// ];


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
	$scope.userTypes = ['student', 'practictioner'];
	$scope.userType = 'User Type';

	$scope.months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	$scope.types = ['Journal', 'Online Article'];
	$scope.qualifications = ['CFA Level 1', 'CFA Level 2', 'CFA Level 3', 'CPA', 'MBBS', 'Others'];
	
	$scope.student = {
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

	$scope.graduationYear = 'Year';
	$scope.monthFrom = 'Month';
	$scope.monthTo = 'Month';
	$scope.yearFrom = 'Year';
	$scope.yearTo = 'Year';
	$scope.publicationType = 'Type';
	$scope.qualification = 'Qualification';
	$scope.qualificationYear = 'Year';
	$scope.yearAwarded = 'Year';

	$scope.jurisdictions = ['Australia', 'Canada', 'Europe', 'Hong Kong', 'India', 'Malaysia', 'New Zealand', 'Singapore', 'United Kingdom', 'Others'];
	// $scope.jurisdiction = 'Jurisdiction';
	$scope.admissionYear = 'Year';

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
	$scope.setUserType = function(userType)
	{
		$scope.userType = userType;
		$scope.studentShow = false;
		$scope.practictionerShow = false;
		console.log('userType =', userType);
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
		}
	};

	$scope.rowLimit = 3;
	$scope.works = [{company: '', from: '', to: '', supervisor: ''}];
	$scope.competitions = [{competitionName: '', competitionResult: ''}];
	$scope.admissions = [{jurisdiction: '', otherJurisdiction: '', admissionYear: ''}];
	$scope.awards = [{awardName: '', awardYear: ''}];
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
		console.log('div =', div);
		// $scope.rowLimit = 3;
		// var div = angular.element(document.querySelector('#' + divId));
		// console.log('div =', div);
		// console.log('div[0] =', div[0]);
		if (div === 'work') {
			// $scope.works = [{company: '', from: '', to: '', supervisor: ''}];
			// console.log('$scope.works.length =', $scope.works.length);
			// console.log('$scope.works =', $scope.works);
			if ($scope.works.length < $scope.rowLimit) {
				$scope.works.push({company: '', from: '', to: '', supervisor: ''});
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
		} else if (div === 'award') {
			if ($scope.awards.length < $scope.rowLimit) {
				$scope.awards.push({awardName: '', awardYear: ''});
			} else {}
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
	 * @function name:	editStudent = function (student)
	 * @description:	This function submits user password reset request.
	 * @related issues:	ITL-003
	 * @param:			object student
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/07/2015
	 * @last modified: 	04/07/2015
	 * @called by:		<form ng-show="practictionerShow" ng-submit="editPractictioner(practictioner)">
	 *					 in php/public/profile_edit.html
	 */
	// $scope.signup = function (user, $flow)
	$scope.signup = function (user)
	{
		// var monthFrom = angular.element(document.querySelector('#monthFrom')).val();
		// console.log('monthFrom =', monthFrom);
		// var yearFrom = angular.element(document.querySelector('#yearFrom')).val();
		// console.log('yearFrom =', yearFrom);
		user.graduationYear = $scope.graduationYear;
		user.monthFrom = $scope.monthFrom;
		user.yearFrom = $scope.yearFrom;
		user.monthTo = $scope.monthTo;
		user.yearTo = $scope.yearTo;
		user.publicationType = $scope.publicationType;
		user.qualification = $scope.qualification;
		user.qualificationYear = $scope.qualificationYear;


		if (user.qualification === 'Others' && user.otherQualification.length > 0) {
			user.qualification = user.otherQualification;
		}
		console.log('user =', user);

		$http.post('http://intelllex.com:3000/api/user', user)
			.success(function(data, status, headers, config) {
				console.log('data =', data);
				$scope.setMessages(data.messages);
			})
			.error(function(data, status, headers, config) {
				$scope.status = status;
			});

	};


	/**
	 * @function name:	setJurisdiction = function(jurisdiction)
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
	$scope.setJurisdiction = function(jurisdiction)
	{
		console.log('jurisdiction =', jurisdiction);
		$scope.jurisdiction = jurisdiction;
	};


	/**
	 * @function name:	setAdmissionYear = function(admissionYear)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string admissionYear
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setAdmissionYear = function(admissionYear)
	{
		console.log('admissionYear =', admissionYear);
		$scope.admissionYear = admissionYear;
	};


	/**
	 * @function name:	setAdmissionYear = function(admissionYear)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-003
	 * @param:			string yearAwarded
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/29/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	$scope.setYearAwarded = function(yearAwarded)
	{
		// console.log('yearAwarded =', yearAwarded);
		$scope.yearAwarded = yearAwarded;
	};



	/**
	 * @function name:	editPractictioner = function (practictioner)
	 * @description:	This function submits edit request to "practictioner" table.
	 * @related issues:	ITL-003
	 * @param:			object practictioner
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/31/2015
	 * @called by:		<form ng-show="practictionerShow" ng-submit="editPractictioner(practictioner)">
	 *					 in php/public/profile_edit.html
	 */
	$scope.editPractictioner = function (practictioner)
	{
		practictioner.jurisdiction = $scope.jurisdiction;
		practictioner.admissionYear = $scope.admissionYear;
		practictioner.yearAwarded = $scope.yearAwarded;
		// practictioner.publicationType = publicationType;
		practictioner.publicationType = $scope.publicationType;

		if (practictioner.jurisdiction === 'Others' && practictioner.otherJurisdiction.length > 0) {
			practictioner.jurisdiction = practictioner.otherJurisdiction;
		}
		// console.log('practictioner =', practictioner);


		// practictioner = {
		// 	jurisdiction: 'Europe',
		// 	otherJurisdiction: 'otherother',
		// 	admissionYear: '1998',
		// 	area: 'Patent',
		// 	industry: 'IT',
		// 	awardName: 'Oscar',
		// 	yearAwarded: '1994',
		// 	publicationName: 'GPS',
		// 	publicationType: 'Online Article',
		// 	publicationUrl: 'url',
		// 	publicationCitation: 'citation',
		// };


		// practictioner.url = $location.url();
		// var headers = {
		// 	'Access-Control-Allow-Origin' : '*',
		// 	'Access-Control-Allow-Methods' : 'POST, GET, OPTIONS, PUT',
		// 	'Content-Type': 'application/json',
		// 	'Accept': 'application/json'
		// };

		// $http.post('/api/practictioner', practictioner)
		// $http.post('http://intelllex.com\\:3000/api/practictioner', practictioner)
		// $http.post('http://intelllex.com\:3000/api/practictioner', practictioner)
		$http.post('http://intelllex.com:3000/api/practictioner', practictioner)
		// $http.post('http://intelllex.com\\:3000/api/practictioner', {
		// $http.post('http://intelllex.com:3000/api/practictioner', {
		// 		headers: headers,
		// 		data: practictioner
		// 	})
			.success(function(data, status, headers, config) {
				console.log('data =', data);
				$scope.setMessages(data.messages);
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






	/**
	 * @function name:	editStudent = function (student)
	 * @description:	This function submits user password reset request.
	 * @related issues:	ITL-003
	 * @param:			object student
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/29/2015
	 * @last modified: 	03/31/2015
	 * @called by:		<form ng-show="practictionerShow" ng-submit="editPractictioner(practictioner)">
	 *					 in php/public/profile_edit.html
	 */
	// $scope.signup = function (user, $flow)
	$scope.editStudent = function (student)
	{
		// var monthFrom = angular.element(document.querySelector('#monthFrom')).val();
		// console.log('monthFrom =', monthFrom);
		// var yearFrom = angular.element(document.querySelector('#yearFrom')).val();
		// console.log('yearFrom =', yearFrom);
		student.graduationYear = $scope.graduationYear;
		student.monthFrom = $scope.monthFrom;
		student.yearFrom = $scope.yearFrom;
		student.monthTo = $scope.monthTo;
		student.yearTo = $scope.yearTo;
		student.publicationType = $scope.publicationType;
		student.qualification = $scope.qualification;
		student.qualificationYear = $scope.qualificationYear;


		// student = {
		// 	institution: 'NTU',
		// 	graduationYear: '1991',
		// 	degree: 'PhD',
		// 	company: 'Citi',
		// 	monthFrom: 'Feb',
		// 	yearFrom: '1993',
		// 	monthTo: 'Jul',
		// 	yearTo: '2008',
		// 	supervisor: 'Don',
		// 	competitionName: 'MUN',
		// 	competitionResult: 'BD',
		// 	publicationName: 'GPS',
		// 	publicationType: 'Online Article',
		// 	publicationUrl: 'url3',
		// 	publicationCitation: 'citation5',
		// 	qualification: 'Others',
		// 	otherQualification: 'CFA Level 5',
		// 	qualificationYear: '2014',
		// };

		if (student.qualification === 'Others' && student.otherQualification.length > 0) {
			student.qualification = student.otherQualification;
		}
		console.log('student =', student);

		$http.post('http://intelllex.com:3000/api/student', student)
			.success(function(data, status, headers, config) {
				console.log('data =', data);
				$scope.setMessages(data.messages);
			})
			.error(function(data, status, headers, config) {
				$scope.status = status;
			});

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
	 * @function name:	setQualificationYear = function(yearFrom)
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
	$scope.setQualificationYear = function(qualificationYear)
	{
		console.log('qualificationYear =', qualificationYear);
		$scope.qualificationYear = qualificationYear;
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
