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

// header('Access-Control-Allow-Origin: *');

use Phalcon\Mvc\Micro,
	Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

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
	$app->get('/api/test', function () use ($app) {
		$request = new Phalcon\Http\Request();
		$header = $request->getHeaders();
		echo print_r($header);
		echo 'test test';
	});


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
	$app->post('/api/practictioner', function () use ($app) {
	// $app->options('/api/practictioner', function () use ($app) {
		$request = new Phalcon\Http\Request();
		// echo $request->getHeaders();
		$header = $request->getHeaders();
		// echo print_r($header);
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);
		// $url = $post->url;
		// return $post;
		$arr = Practictioner::addPractictioner($post, $app);

		header("Cache-Control: private, max-age=10800, pre-check=10800");
		header("Pragma: private");
		header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));

		// header('Content-type: '.$IKnowMime );
		header("Content-Transfer-Encoding: binary");
		// header('Content-Length: '.filesize(FONT_FOLDER.$f));
		// header('Content-Disposition: attachment; filename="'.$f.'";');
		header('Access-Control-Allow-Origin: *');
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
