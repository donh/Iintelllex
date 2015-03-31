<?php

class Practictioner extends \Phalcon\Mvc\Model
{

	/**
	 *
	 * @var integer
	 */
	public $id;

	/**
	 *
	 * @var string
	 */
	public $userId;

	/**
	 *
	 * @var string
	 */
	public $jurisdiction;

	/**
	 *
	 * @var integer
	 */
	public $admissionYear;

	/**
	 *
	 * @var string
	 */
	public $area;

	/**
	 *
	 * @var string
	 */
	public $industry;

	/**
	 *
	 * @var string
	 */
	public $awardName;

	/**
	 *
	 * @var integer
	 */
	public $awardYear;

	/**
	 *
	 * @var string
	 */
	public $publicationName;

	/**
	 *
	 * @var string
	 */
	public $publicationType;

	/**
	 *
	 * @var string
	 */
	public $publicationUrl;

	/**
	 *
	 * @var string
	 */
	public $publicationCitation;

	/**
	 *
	 * @var string
	 */
	public $createdAt;

	/**
	 *
	 * @var string
	 */
	public $updatedAt;

	/**
	 * Independent Column Mapping.
	 */
	public function columnMap()
	{
		return array(
			'id' => 'id', 
			'userId' => 'userId', 
			'jurisdiction' => 'jurisdiction', 
			'admissionYear' => 'admissionYear', 
			'area' => 'area', 
			'industry' => 'industry', 
			'awardName' => 'awardName', 
			'awardYear' => 'awardYear', 
			'publicationName' => 'publicationName', 
			'publicationType' => 'publicationType', 
			'publicationUrl' => 'publicationUrl', 
			'publicationCitation' => 'publicationCitation', 
			'createdAt' => 'createdAt', 
			'updatedAt' => 'updatedAt'
		);
	}


	/**
	 * @function name:	public static function addUser($post, $app)
	 * @description:	This function creates an user account by content of $post.
	 * @related issues: ITL-003
	 * @param:			object $post
	 * @param:			object $app
	 * @return:			JSON $json
	 * @author:			Don Hsieh
	 * @since:			03/30/2015
	 * @last modified:	03/30/2015
	 * @called by:		$app->post('/api/signup')
	 *					 in /var/www/wd/php/public/index.php
	 */
	public static function addPractictioner($post, $app)
	{
		$messages = array();
		if (!$post) $messages['error'] = 'Please enter your jurisdiction.';
		
		$user = array();
		if (isset($post->jurisdiction)) $user['jurisdiction'] = $post->jurisdiction;
		else $messages['error'] = 'Please enter your jurisdiction.';
		if (isset($post->admissionYear)) $user['admissionYear'] = $post->admissionYear;
		else $messages['error'] = 'Please enter your year of admission.';
		if (isset($post->area)) $user['area'] = $post->area;
		else $messages['error'] = 'Please enter your areas.';
		if (isset($post->industry)) $user['industry'] = $post->industry;
		else $messages['error'] = 'Please enter your year of industries.';

		if (isset($post->awardName)) $user['awardName'] = $post->awardName;
		if (isset($post->awardYear)) $user['awardYear'] = $post->awardYear;
		if (isset($post->publicationName)) $user['publicationName'] = $post->publicationName;
		if (isset($post->publicationType)) $user['publicationType'] = $post->publicationType;
		if (isset($post->publicationUrl)) $user['publicationUrl'] = $post->publicationUrl;
		if (isset($post->publicationCitation)) $user['publicationCitation'] = $post->publicationCitation;

		if (isset($messages['error'])) {
			$arr = array(
				'status' => 'INVALID-INPUT',
				'messages' => $messages,
				'data' => $post
			);
			return $arr;
		}

		// $now = User::getNow();
		$now = Practictioner::getNow();
		$user['createdAt'] = $now;
		$user['updatedAt'] = $now;
		// Getting a request instance
		// $request = new \Phalcon\Http\Request();
		// $ipAddress = $request->getClientAddress();
		// $ip = $ipAddress . ';' . $now;
		// $arrIp = json_decode($row->ip);
		// if (is_array($arrIp)) array_unshift($arrIp, $ip);
		// else $arrIp = [$ip];
		// $jsonIp = json_encode($arrIp);
		// $user['ip'] = $jsonIp;

		// $user['agent'] = $request->getUserAgent();
		// $user['lang'] = $request->getBestLanguage();
		$row = new Practictioner();
		// $result = $row->update($user, array(
		$result = $row->save($user, array(
			'jurisdiction', 'admissionYear', 'area', 'industry',
			'awardName', 'awardYear', 'publicationName', 'publicationType',
			'publicationUrl', 'publicationCitation', 'createdAt', 'updatedAt'
		));;
		
		if (!$result) {
			$arr = array();
			foreach ($row->getMessages() as $message) {
				$arr[] = $message;
			}
			$messages['error'] = implode('&nbsp;&nbsp;&nbsp;', $arr);
			$arr = array(
				'status' => 'SAVE-FAILED',
				'messages' => $messages,
				'editContent' => $row,
				'result' => $result,
				'data' => $post
			);
			return $arr;
		} else {
			$messages['success'] = 'Your profile has been updated.';
			$arr = array(
				'status' => 'EDIT-DONE',
				'messages' => $messages,
				'editContent' => $row,
				'user' => $user,
				'result' => $result,
				'data' => $post
			);
			return $arr;
		}
	}



	/**
	 * @function name:	public static function getNow()
	 * @description:	This function returns time of now in format of 'Y-m-d H:i:s' in time zone 'Asia/Taipei'.
	 * @related issues: ITL-003
	 * @param:			void
	 * @return:			string $now
	 * @author:			Don Hsieh
	 * @since:			03/30/2015
	 * @last modified:	03/30/2015
	 * @called by:		public static function addUser($post, $app)
	 *					public static function editUser($post, $app)
	 *					public static function forgot($post, $app)
	 *					public static function resetPassword($post, $app)
	 *					 in php/app/models/User.php
	 *					public static function addSubscriber($post, $app)
	 *					 in php/app/models/Subscriber.php
	 */
	// private static function getNow()
	public static function getNow()
	{
		// date_default_timezone_set($timezone);
		date_default_timezone_set('Asia/Taipei');
		$now = date('Y-m-d H:i:s');
		return $now;
	}

}
