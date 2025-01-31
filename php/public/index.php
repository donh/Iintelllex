<?php
/**
 * @file name:		php/public/index.php
 * @description:	This file sets default Phalcon settings.
 * @related issues: ITL-003
 * @param:			void
 * @return:			void
 * @author:			Don Hsieh
 * @since:			03/30/2015
 * @last modified:	03/30/2015
 * @called by:		URL /
 */
error_reporting(E_ALL);

// header("Cache-Control: private, max-age=10800, pre-check=10800");
// header("Pragma: private");
// header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
// header("Content-Transfer-Encoding: binary");
// header('Access-Control-Allow-Origin: *');

// header('Access-Control-Allow-Origin: *');

use Phalcon\Mvc\Micro,
	Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter,
	// below may remove
	Phalcon\Mvc\Micro\Collection as MicroCollection,
	Phalcon\DI\FactoryDefault,
	Phalcon\Config\Adapter\Ini as IniConfig;

try {

	/**
	* Define some useful constants
	*/
	define('BASE_DIR', dirname(__DIR__));
	define('APP_DIR', BASE_DIR . '/app');

	/**
	 * Read the configuration
	 */
	$config = include __DIR__ . "/../app/config/config.php";

	/**
	 * Read auto-loader
	 */
	include __DIR__ . "/../app/config/loader.php";

	/**
	 * Read services
	 */
	include __DIR__ . "/../app/config/services.php";

	/**
	 * Handle the request
	 */
	// $application = new \Phalcon\Mvc\Application($di);
	// echo $application->handle()->getContent();
	$app = new Micro($di);

	/**
	 * @api name:		$app->post('/api/pin')
	 * @description:	This API adds pin click event to "click" table.
	 * @related issues:	ITL-003
	 * @param:			POST ($user->email)
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/30/2015
	 * @last modified:	03/30/2015
	 * @called by:		$scope.reset = function (user)
	 *					  in wdApp.controller('ResetController') in php/public/js/app.js
	 */
	// $app->get('/api/test', function () use ($app) {
	// 	$request = new Phalcon\Http\Request();
	// 	$header = $request->getHeaders();
	// 	echo print_r($header);
	// 	echo 'test test';
	// });


	/**
	 * @api name:		$app->post('/api/login')
	 * @description:	This API adds a record to "user" table.
	 * @related issues:	ITL-003
	 * @param:			JSON $postdata
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/18/2015
	 * @last modified:	04/18/2015
	 * @called by:		$http.post('http://intelllex.com:3000/api/login', user)
	 *					  in $scope.login = function (user)
	 *					  in itApp.controller('LoginController') in php/public/js/app.js
	 */
	$app->post('/api/login', function () use ($app) {
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);
		$email = $post->email;
		$password = $post->password;
		$arr = User::login($email, $password, $app);

		$arr['emailSession3'] = $app->session->get('email');

		$user = $arr['data'];
		$app->session->set('email', $user['email']);
		$app->session->set('firstName', $user['firstName']);
		$app->session->set('lastName', $user['lastName']);
		$app->session->set('user', $user['user']);
		
		// $arr['session'] = print_r($_SESSION);
		$arr['session'] = $_SESSION;

		// header("Cache-Control: private, max-age=10800, pre-check=10800");
		// header("Pragma: private");
		// header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
		// header("Content-Transfer-Encoding: binary");
		header('Access-Control-Allow-Origin: *');

		return $arr;
	});


	/**
	 * @api name:		$app->post('/api/user')
	 * @description:	This API adds a record to "user" table.
	 * @related issues:	ITL-003
	 * @param:			JSON $postdata
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			04/09/2015
	 * @last modified:	04/15/2015
	 * @called by:		$http.post('http://intelllex.com:3000/api/user', user)
	 *					  in $scope.signup = function (user)
	 *					  in itApp.controller('AppController') in php/public/js/app.js
	 */
	$app->post('/api/edit', function () use ($app) {
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);

		// $user = $app->session->get('user');
		// $post->email = $user['email'];
		// $post->email = print_r($user);
		// $post->email = $app->session->get('email');

		// $arr = User::addUser($post, $app);
		$arr = User::editUser($post, $app);
		$arr['emailSession3'] = $app->session->get('email');
		// $email = $_SESSION["email"];
		// $firstName = $_SESSION["user_fn"];
		// $lastName = $_SESSION["user_ln"];
		// $arr['email'] = $email;
		// $arr['firstName'] = $firstName;
		// $arr['lastName'] = $lastName;
		// $arr['session'] = $_SESSION;
		header('Access-Control-Allow-Origin: *');
		return $arr;
	});


	/**
	 * @api name:		$app->post('/api/loginstatus')
	 * @description:	This API checks user's login status.
	 * @related issues:	ITL-003
	 * @param:			void
	 * @return:			array $arr
	 * @author:			Don Hsieh
	 * @since:			04/18/2015
	 * @last modified:	04/18/2015
	 * @called by:		$scope.checkLoginStatus = function ()
	 *					  in wdApp.controller('AppController') in php/public/js/app.js
	 */
	$app->get('/api/loginstatus', function () use ($app) {
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);
		$user = $app->session->get('user');
		if (!isset($user)) {
			$arr = array('status' => 'NOT-LOGIN');
		} else {
			// unset($user['dressIds']);
			$arr = array(
				'status' => 'LOGIN',
				'user' => $user
			);
		}
		return $arr;
	});



	/**
	 * @api name:		$app->post('/api/practictioner')
	 * @description:	This API adds a record to "practictioner" table.
	 * @related issues:	ITL-003
	 * @param:			JSON $postdata
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/30/2015
	 * @last modified:	03/31/2015
	 * @called by:		$http.post('http://intelllex.com:3000/api/practictioner', practictioner)
	 *					  in $scope.editPractictioner = function (practictioner)
	 *					  in itApp.controller('AppController') in php/public/js/app.js
	 */
	$app->post('/api/practictioner', function () use ($app) {
	// $app->options('/api/practictioner', function () use ($app) {
		// $request = new Phalcon\Http\Request();
		// // echo $request->getHeaders();
		// $header = $request->getHeaders();
		// echo print_r($header);
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);
		// $url = $post->url;
		// return $post;
		$arr = Practictioner::addPractictioner($post, $app);

		// header("Cache-Control: private, max-age=10800, pre-check=10800");
		// header("Pragma: private");
		// header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));

		// // header('Content-type: '.$IKnowMime );
		// header("Content-Transfer-Encoding: binary");
		// // header('Content-Length: '.filesize(FONT_FOLDER.$f));
		// // header('Content-Disposition: attachment; filename="'.$f.'";');
		// header('Access-Control-Allow-Origin: *');
		// header('Access-Control-Allow-Origin: http://intelllex.com/');
		// header('Access-Control-Allow-Origin: http://intelllex.com/profile_edit');
		// header('Access-Control-Allow-Origin: http://intelllex.com:3000');
		// header('Access-Control-Allow-Origin: localhost');
		// header('Access-Control-Allow-Origin: intelllex.com/profile_edit');
		// header('Access-Control-Allow-Origin: http://localhost');
		// $response = $app->response;
		// $status_header = 'HTTP/1.1 ' . $status . ' ' . $description;
		// // $response->setRawHeader($status_header);
		// // $response->setStatusCode($status, $description);
		// $response->setContentType($content_type, 'UTF-8');
		// $response->setHeader('Access-Control-Allow-Origin', '*');
		// $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
		// $response->setHeader("Access-Control-Allow-Headers: Authorization");
		// $response->setHeader('Content-type: ' . $content_type);
		// $response->sendHeaders();

		// $arr = Practictioner::addPractictioner($post, $app);
		return $arr;
	});


	/**
	 * @api name:		$app->post('/api/student')
	 * @description:	This API adds a record to "student" table.
	 * @related issues:	ITL-003
	 * @param:			JSON $postdata
	 * @return:			void
	 * @author:			Don Hsieh
	 * @since:			03/31/2015
	 * @last modified:	03/31/2015
	 * @called by:		$http.post('http://intelllex.com:3000/api/student', student)
	 *					  in $scope.editStudent = function (student)
	 *					  in itApp.controller('AppController') in php/public/js/app.js
	 */
	$app->post('/api/student', function () use ($app) {
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);
		$arr = Student::addStudent($post, $app);
		return $arr;
	});


	/**
	 * @api name:		$app->after()
	 * @description:	This API encapsulates response in JSON format.
	 * @related issues:	ITL-003
	 * @param:			void
	 * @return:			JSON $json
	 * @author:			Don Hsieh
	 * @since:			03/30/2015
	 * @last modified:	03/30/2015
	 * @called by:		all functions
	 *					 in php/public/index.php
	 */
	$app->after(function() use ($app) {
		//This is executed after the route was executed
		// echo json_encode($app->getReturnedValue());
		try {
			$json = json_encode($app->getReturnedValue());
		} catch (Exception $e) {
			$json = json_encode(array(
				'error' => array(
					'msg' => $e->getMessage(),
					'code' => $e->getCode(),
					'json_last_error' => var_dump(json_last_error())
				),
			));
		}
		echo $json;
	});

	$app->notFound(function () use ($app) {
		$app->response->setStatusCode(404, "Not Found")->sendHeaders();
		echo 'This is crazy, but this page was not found!';
	});

	$app->handle();

} catch (\Exception $e) {
	echo $e->getMessage();
	echo nl2br(htmlentities($e->getTraceAsString()));
	$json = json_encode(array(
		'error' => array(
			'msg' => $e->getMessage(),
			'code' => $e->getCode(),
			'json_last_error' => var_dump(json_last_error())
		),
	));
	echo $json;
}
