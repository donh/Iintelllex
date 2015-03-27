'use strict';
var itApp = angular.module('itApp', ['ngRoute']);


/**
 * @controller:		AppController
 * @description:	This controller opens dress page in a new window.
 * @related issues:	ITL-002
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
 * @since:			12/29/2014
 * @last modified: 	03/05/2015
 * @called by:		<body ng-controller="AppController">
 *					 in php/public/index.html
 */
itApp.controller('AppController', function ($scope, $routeParams, $http, $window, $document, $compile, $location, AUTH_EVENTS, AuthService, Session) {
	$scope.isAuthorized = AuthService.isAuthorized;
	// console.log('$location.$$path =', $location.$$path);	// use $location.$$path
	$scope.$location = $location;
	$scope.$path = $location.$$path;
	$scope.needLoginPopup = false;
	$scope.loginDropdownShow = false;



	/**
	 * @function name:	getScrollContent = function(url, pinCount)
	 * @description:	This function gets content of infinite scroll.
	 * @related issues:	ITL-002
	 * @param:			string url
	 * @param:			integer pinCount:	counts of pins to show in a batch. Default 15.
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			02/03/2015
	 * @last modified: 	03/05/2015
	 * @called by:		itApp.controller('HomeController')
	 *					itApp.controller('FavoritesController')
	 *					 in php/public/js/app.js
	 */
	// $scope.getScrollContent = function(url, pinCount, $scope)
	$scope.getScrollContent = function(url, pinCount)
	{
		$scope.ajax = 'off';
		// $scope.pinCount = pinCount;
		// console.log('url =', url);
		// $('#load-more').hide();
		// $scope.btnLoadmoreShow = true;
		// $scope.btnLoadmoreShow = false;
		// sessionStorage.setItem('sessionScroll', 0);
		sessionStorage.setItem('noDataRemained', false);
		$scope.wdDressesInit('container');


		$scope.loadMore = function()
		{
			angular.element(document.querySelector('#load_more')).toggleClass('hide');
			$scope.wdScroll(url, sessionStorage, pinCount, true);
			// $scope.wdScroll(url, sessionStorage, $scope.pinCount, true);
		};
		// jQuery('#load_more').click(function() {
		// 	$('#loading_bar').show();
		// 	$('#load_more').hide();
		// 	$scope.wdScroll(url, sessionStorage, pinCount, true);
		// });
		var ajax = false;
		if (!ajax) {
			ajax = true;
			$scope.wdScroll(url, sessionStorage, pinCount, false);
			ajax = false;
		}
		$window.onscroll = function(ev) {
			// console.log('window.innerHeight =', window.innerHeight);
			// console.log('window.scrollY =', window.scrollY);
			// console.log('document.body.offsetHeight =', document.body.offsetHeight);
			// if (angular.element(document.querySelector('#load_more')).hasClass('hide')) {
			if (($window.innerHeight + $window.scrollY) >= document.body.offsetHeight) {
				// if (!ajax) {
				// if (!ajax && pinCount < 200) {	// not sure why set pinCount < 200
				if (!ajax && angular.element(document.querySelector('#load_more')).hasClass('hide')) {
					// console.log('sessionStorage =', sessionStorage);
					ajax = true;
					$scope.wdBottomLoadMore(url, sessionStorage, $scope);
					ajax = false;
				}
			}
			if ($scope.ajax === 'off') {
				$scope.ajax = 'on';
			}
		};
		// remove the paginator when we're done.
		// jQuery(document).ajaxError(function(e,xhr,opt) {
			// if (xhr.status == 404) jQuery('#load-more').remove();
		// });
	};

	
	/**
	 * @function name:	$scope.loginPopupClose = function()
	 * @description:	This function opens dress page in a new window.
	 * @related issues:	ITL-002
	 * @param:			void
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			12/18/2014
	 * @last modified: 	12/18/2014
	 * @called by:		<div id="fade" class="black_overlay" ng-show="pop" ng-click="loginPopupClose()">
	 *					 in php/public/templates/designer.html
	 */
	$scope.loginPopupClose = function()
	{
		// if (document.getElementById('light')) document.getElementById('light').style.display = 'none';
		// if (document.getElementById('fade')) document.getElementById('fade').style.display = 'none';
		$scope.needLoginPopup = false;
		$window.onscroll = null;
		$document.onmousewheel = null;
	};

});
