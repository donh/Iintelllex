<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class Edit extends \Phalcon\Mvc\Model
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
	public $email;

	/**
	 *
	 * @var string
	 */
	public $type;

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
			'email' => 'email', 
			'type' => 'type', 
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
	 * @last modified:	04/12/2015
	 * @called by:		$app->post('/api/student')
	 *					 in php/public/index.php
	 */
	public static function addUser($post, $app)
	{
		$messages = array();
		if (!$post) $messages['error'] = 'Please enter your email.';
		
		$user = array();
		// if (isset($post->username)) {
		// 	$username = $post->username;
		// 	if (strpos($username, ' ') !== FALSE) {
		// 		$messages['error'] = 'Username should contain no spaces.';
		// 	} else {
		// 		$user['username'] = $username;
		// 		$user['account'] = strtolower($username);
		// 	}
		// } else $messages['error'] = 'Please enter your username.';
		// $row = User::findFirstByAccount($user['account']);
		// if ($row) {
		// 	$messages['error'] = 'Username already taken.';
		// }

		if (isset($post->email)) {
			$email = strtolower($post->email);
			$regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
			$result = preg_match($regex, $email);
			if (isset($result)) {
				$user['email'] = $email;
			} else {
				$messages['error'] = 'Please enter valid email.';
			}
		} else $messages['error'] = 'Please enter your email.';
		// temp
		// $row = User::findFirstByEmail($email);
		// if ($row) {
		// 	$messages['error'] = 'Email already registered.';
		// }

		// if (isset($post->password) && isset($post->password_confirmation)) {
		// 	$password = $post->password;
		// 	$password_confirmation = $post->password_confirmation;
		// 	if (strcmp($password, $password_confirmation) !== 0) {
		// 		$messages['error'] = 'Please enter matched password.';
		// 	} else if (strlen($password) < 6) {
		// 		$messages['error'] = 'Please enter valid password.';
		// 	// } else $user['password'] = $app->security->hash($password);
		// 	} else $user['password'] = $password;
		// } else $messages['error'] = 'Please enter your password.';

		if (isset($post->userType)) {
			$type = $post->userType;
			$user['type'] = $type;
		} else $messages['error'] = 'Please select your user type.';
		if (isset($post->firstName)) $user['firstName'] = $post->firstName;
		else $messages['firstName'] = 'Please enter your first name.';
		if (isset($post->lastName)) $user['lastName'] = $post->lastName;
		else $messages['lastName'] = 'Please enter your last name.';
		
			// 'ip' => 'ip', 
			// 'ips' => 'ips', 
		
		if (isset($messages['error'])) {
			$arr = array(
				'status' => 'INVALID-INPUT',
				'messages' => $messages,
				'data' => $post
			);
			return $arr;
		}
		
		$user['publications'] = '';
		if (isset($post->publications)) $user['publications'] = json_encode($post->publications);

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
		// $row = new User();
		$row = new Edit();
		if ($type == 'student') {
			$user['institution'] = '';
			$user['graduationYear'] = '';
			$user['degree'] = '';
			$user['works'] = '';
			$user['competitions'] = '';
			$user['others'] = '';
			if (isset($post->institution)) $user['institution'] = $post->institution;
			if (isset($post->graduationYear)) $user['graduationYear'] = $post->graduationYear;
			if (isset($post->degree)) $user['degree'] = $post->degree;
			if (isset($post->works)) $user['works'] = json_encode($post->works);
			if (isset($post->competitions)) $user['competitions'] = json_encode($post->competitions);
			if (isset($post->others)) $user['others'] = json_encode($post->others);
			// $result = $row->update($user, array(
			$result = $row->save($user, array(
				'username', 'account', 'email', 'password', 'type', 'publications',
				'firstName', 'lastName', 'createdAt', 'updatedAt',
				'institution', 'graduationYear', 'degree', 'works', 'competitions', 'others'
			));;
		} else if ($type == 'practictioner') {
			$user['admissions'] = '';
			$user['area'] = '';
			$user['industry'] = '';
			$user['awards'] = '';
			if (isset($post->admissions)) $user['admissions'] = json_encode($post->admissions);
			if (isset($post->area)) $user['area'] = $post->area;
			if (isset($post->industry)) $user['industry'] = $post->industry;
			if (isset($post->awards)) $user['awards'] = json_encode($post->awards);
			$result = $row->save($user, array(
				'username', 'account', 'email', 'password', 'type', 'publications',
				'firstName', 'lastName', 'createdAt', 'updatedAt',
				'admissions', 'area', 'industry', 'awards'
			));;
		}

		if (!$result) {
			$arr = array();
			foreach ($row->getMessages() as $message) {
				$arr[] = $message;
			}
			$messages['error'] = implode('&nbsp;&nbsp;&nbsp;', $arr);
			$arr = array(
				'status' => 'SAVE-FAILED',
				'messages' => $messages,
				'rowContent' => $row,
				'result' => $result,
				'data' => $post
			);
			return $arr;
		} else {
			$messages['success'] = 'Your profile has been updated.';
			// $messages['success'] = 'Registration of ' . $username . ' successful!';
			$arr = array(
				'status' => 'EDIT-DONE',
				'messages' => $messages,
				// 'editContent' => $row,
				// 'user' => $user,
				// 'result' => $result,
				// 'data' => $post
			);
			return $arr;
		}
	}

}
