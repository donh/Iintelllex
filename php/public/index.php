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

use Phalcon\Mvc\Micro,
	Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter,

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
	$app->post('/api/practictioner', function () use ($app) {
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);
		$url = $post->url;
		$tags = '';
		$scroll = '';
		$pinCount = 0;
		$dressIds = '';
		$designerKey = '';
		$collectionKey = '';

		$dressId = $post->dressId;
		$img = $post->img;
		$url = $post->url;
		$position = $post->position;
		$pin = $post->pin;
		$scroll = $post->scroll;

		$request = new \Phalcon\Http\Request();
		$lang = $request->getBestLanguage();
		if (isset($lang) && is_string($lang) && strlen($lang) > 0) {	// exclude Googlebot
			Click::addClick($dressId, $img, $url, $position, $pin, $scroll, $app);
		}
		return $dressId;
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
