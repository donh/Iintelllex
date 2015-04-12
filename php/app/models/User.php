<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class User extends \Phalcon\Mvc\Model
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
	public $account;

	/**
	 *
	 * @var string
	 */
	public $type;

	/**
	 *
	 * @var string
	 */
	public $ip;

	/**
	 *
	 * @var string
	 */
	public $ips;

	/**
	 *
	 * @var string
	 */
	public $username;

	/**
	 *
	 * @var string
	 */
	public $firstName;

	/**
	 *
	 * @var string
	 */
	public $lastName;

	/**
	 *
	 * @var string
	 */
	public $email;

	/**
	 *
	 * @var string
	 */
	public $publications;

	/**
	 *
	 * @var string
	 */
	public $admissions;

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
	public $awards;

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
	public $degree;

	/**
	 *
	 * @var string
	 */
	public $works;

	/**
	 *
	 * @var string
	 */
	public $competitions;

	/**
	 *
	 * @var string
	 */
	public $others;

	/**
	 *
	 * @var string
	 */
	public $password;

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
	 * Validations and business logic
	 */
	public function validation()
	{

		$this->validate(
			new Email(
				array(
					'field'	=> 'email',
					'required' => true,
				)
			)
		);
		if ($this->validationHasFailed() == true) {
			return false;
		}
	}

	/**
	 * Independent Column Mapping.
	 */
	public function columnMap()
	{
		return array(
			'id' => 'id', 
			'account' => 'account', 
			'type' => 'type', 
			'ip' => 'ip', 
			'ips' => 'ips', 
			'username' => 'username', 
			'firstName' => 'firstName', 
			'lastName' => 'lastName', 
			'email' => 'email', 
			'publications' => 'publications', 
			'admissions' => 'admissions', 
			'area' => 'area', 
			'industry' => 'industry', 
			'awards' => 'awards', 
			'institution' => 'institution', 
			'graduationYear' => 'graduationYear', 
			'degree' => 'degree', 
			'works' => 'works', 
			'competitions' => 'competitions', 
			'others' => 'others', 
			'password' => 'password', 
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
	public static function addUser($post, $app)
	{
		$messages = array();
		if (!$post) $messages['error'] = 'Please enter your username.';
		
		$user = array();
		if (isset($post->username)) {
			$user['username'] = $post->username;
			$user['account'] = strtolower($post->username);
		} else $messages['error'] = 'Please enter your institution.';
		if (isset($post->type)) $user['type'] = $post->type;
		else $messages['error'] = 'Please select your user type.';
		if (isset($post->firstName)) $user['firstName'] = $post->firstName;
		else $messages['firstName'] = 'Please enter your first name.';
		if (isset($post->lastName)) $user['lastName'] = $post->lastName;
		else $messages['lastName'] = 'Please enter your last name.';
		if (isset($post->email)) $user['email'] = $post->email;
		else $messages['email'] = 'Please enter your email.';

			// 'ip' => 'ip', 
			// 'ips' => 'ips', 
		//password shall match
		


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
			'institution', 'graduationYear', 'degree', 'company', 'monthFrom', 'yearFrom', 'monthTo',
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
