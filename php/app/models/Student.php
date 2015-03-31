<?php

class Student extends \Phalcon\Mvc\Model
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
	public $institution;

	/**
	 *
	 * @var integer
	 */
	public $graduationYear;

	/**
	 *
	 * @var string
	 */
	public $company;

	/**
	 *
	 * @var string
	 */
	public $monthFrom;

	/**
	 *
	 * @var integer
	 */
	public $yearFrom;

	/**
	 *
	 * @var string
	 */
	public $monthTo;

	/**
	 *
	 * @var integer
	 */
	public $yearTo;

	/**
	 *
	 * @var string
	 */
	public $supervisor;

	/**
	 *
	 * @var string
	 */
	public $competitionName;

	/**
	 *
	 * @var string
	 */
	public $competitionResult;

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
	public $qualification;

	/**
	 *
	 * @var integer
	 */
	public $qualificationYear;

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
			'institution' => 'institution', 
			'graduationYear' => 'graduationYear', 
			'company' => 'company', 
			'monthFrom' => 'monthFrom', 
			'yearFrom' => 'yearFrom', 
			'monthTo' => 'monthTo', 
			'yearTo' => 'yearTo', 
			'supervisor' => 'supervisor', 
			'competitionName' => 'competitionName', 
			'competitionResult' => 'competitionResult', 
			'publicationName' => 'publicationName', 
			'publicationType' => 'publicationType', 
			'publicationUrl' => 'publicationUrl', 
			'publicationCitation' => 'publicationCitation', 
			'qualification' => 'qualification', 
			'qualificationYear' => 'qualificationYear', 
			'createdAt' => 'createdAt', 
			'updatedAt' => 'updatedAt'
		);
	}


	/**
	 * @function name:	public static function addStudent($post, $app)
	 * @description:	This function creates an user account by content of $post.
	 * @related issues: ITL-003
	 * @param:			object $post
	 * @param:			object $app
	 * @return:			JSON $json
	 * @author:			Don Hsieh
	 * @since:			03/31/2015
	 * @last modified:	03/31/2015
	 * @called by:		$app->post('/api/student')
	 *					 in php/public/index.php
	 */
	public static function addStudent($post, $app)
	{
		$messages = array();
		if (!$post) $messages['error'] = 'Please enter your institution.';
		
		$user = array();
		if (isset($post->institution)) $user['institution'] = $post->institution;
		else $messages['error'] = 'Please enter your institution.';
		if (isset($post->graduationYear)) $user['graduationYear'] = $post->graduationYear;
		else $messages['error'] = 'Please enter your graduation year.';
		if (isset($post->degree)) $user['degree'] = $post->degree;
		else $messages['error'] = 'Please enter your degree.';

		if (isset($post->company)) $user['company'] = $post->company;
		if (isset($post->monthFrom)) $user['monthFrom'] = $post->monthFrom;
		if (isset($post->yearFrom)) $user['yearFrom'] = $post->yearFrom;
		if (isset($post->monthFrom)) $user['monthFrom'] = $post->monthFrom;
		if (isset($post->monthTo)) $user['monthTo'] = $post->monthTo;
		if (isset($post->yearTo)) $user['yearTo'] = $post->yearTo;
		if (isset($post->supervisor)) $user['supervisor'] = $post->supervisor;
		if (isset($post->competitionName)) $user['competitionName'] = $post->competitionName;
		if (isset($post->competitionResult)) $user['competitionResult'] = $post->competitionResult;
		if (isset($post->publicationName)) $user['publicationName'] = $post->publicationName;
		if (isset($post->publicationType)) $user['publicationType'] = $post->publicationType;
		if (isset($post->publicationUrl)) $user['publicationUrl'] = $post->publicationUrl;
		if (isset($post->publicationCitation)) $user['publicationCitation'] = $post->publicationCitation;
		if (isset($post->qualification)) $user['qualification'] = $post->qualification;
		if (isset($post->qualificationYear)) $user['qualificationYear'] = $post->qualificationYear;

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
		$row = new Student();
		// $result = $row->update($user, array(
		$result = $row->save($user, array(
			'institution', 'graduationYear', 'company', 'monthFrom', 'yearFrom', 'monthTo',
			'yearTo', 'supervisor', 'competitionName', 'competitionResult',
			'publicationName', 'publicationType', 'publicationUrl', 'publicationCitation',
			'qualification', 'qualificationYear', 'createdAt', 'updatedAt'
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

}
