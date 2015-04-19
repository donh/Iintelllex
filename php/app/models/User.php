<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class User extends \Phalcon\Mvc\Model
{

	/**
	 *
	 * @var string
	 */
	public $email;

	/**
	 *
	 * @var string
	 */
	public $pw;

	/**
	 *
	 * @var string
	 */
	public $first_name;

	/**
	 *
	 * @var string
	 */
	public $last_name;

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
			'email' => 'email', 
			'pw' => 'pw', 
			'first_name' => 'first_name', 
			'last_name' => 'last_name', 
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
	 * @function name:	public static function login($username, $password, $app)
	 * @description:	This function logs in user and updates user's info.
	 * @related issues:	ITL-003
	 * @param:			string $email
	 * @param:			string $password
	 * @param:			object $app
	 * @return:			array $arr
	 * @author:			Don Hsieh
	 * @since:			04/18/2015
	 * @last modified:	04/18/2015
	 * @called by:		$app->post('/api/login')
	 *					 in php/public/index.php
	 */
	public static function login($email, $password, $app)
	{
		$row = User::findFirstByEmail($email);
		if ($row) {
			// if ($this->security->checkHash($password, $row->password)) {
			// if ($app->security->checkHash($password, $row->password)) {
			if (password_verify($password, $row->pw)) {
				$user = array(
					'email' => $row->email,
					'firstName' => $row->first_name,
					'lastName' => $row->last_name
				);

				// if ($app->session->has('user')) {
				// 	$app->session->destroy();
				// }
				// $app->session->set('user', $user);

				// $app->session->set('email', $row->email);
				// $app->session->set('firstName', $row->first_name);
				// $app->session->set('lastName', $row->last_name);

				$arr = array(
					'status' => 'LOGIN',
					'data' => $user
				);

				$now = User::getNow();
				$user = array(
					'email' => $row->email,
					'updatedAt' => $now,
				);

				if (isset($row->createdAt)) {
					$result = $row->update($user, array(
						'email', 'updatedAt'
					));
				} else {
					$user['createdAt'] = $now;
					$result = $row->update($user, array(
						'email', 'createdAt', 'updatedAt'
					));
				}
			} else $arr = array('status' => 'Invalid Password');
		} else $arr = array('status' => 'Invalid Email');
		return $arr;
	}


	/**
	 * @function name:	public static function editUser($post, $app)
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
	public static function editUser($post, $app)
	{
		$messages = array();
		if (!$post) $messages['error'] = 'Please select your user type.';
		
		$user = array();
		$email = '';
		// $email = $app->session->get('email');

		if (isset($post->email)) {
		// if (isset($email)) {
			$email = $post->email;
			// $email = strtolower($post->email);
			// $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
			// $result = preg_match($regex, $email);
			// if (isset($result)) {
			// 	$user['email'] = $email;
			// } else {
			// 	$messages['error'] = 'Please enter valid email.';
			// }
		} else $messages['error'] = 'Please enter your email.';
		// } else $messages['error'] = 'Please log in first.';

		$row = User::findFirstByEmail($email);
		if ($row) {
			// $user['email'] = $email;
			// $messages['error'] = 'Email already registered.';
		} else $messages['error'] = 'Email not found.';

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
		// if (isset($post->firstName)) $user['firstName'] = $post->firstName;
		// if (isset($post->firstName)) $user['first_name'] = $post->firstName;
		// else $messages['error'] = 'Please enter your first name.';
		// if (isset($post->lastName)) $user['lastName'] = $post->lastName;
		// if (isset($post->lastName)) $user['last_name'] = $post->lastName;
		// else $messages['error'] = 'Please enter your last name.';
		
		if (isset($messages['error'])) {
			$arr = array(
				'status' => 'INVALID-INPUT',
				'messages' => $messages,
				// 'email' => $email,
				// 'emailSession' => $app->session->get('email'),
				// 'firstName' => $app->session->get('firstName'),
				// 'lastName' => $app->session->get('lastName'),
				// 'rowContent' => $row,
				// 'data' => $post
			);
			return $arr;
		}

		$user['works'] = '';
		if (isset($post->works)) $user['works'] = json_encode($post->works);

		$user['publications'] = '';
		if (isset($post->publications)) $user['publications'] = json_encode($post->publications);

		$now = User::getNow();
		// $now = Practitioner::getNow();
		// $user['createdAt'] = $now;
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
		// $row = new Edit();
		if ($type == 'student') {
			$user['institution'] = '';
			$user['graduationYear'] = '';
			$user['degree'] = '';
			$user['competitions'] = '';
			$user['others'] = '';
			if (isset($post->institution)) $user['institution'] = $post->institution;
			if (isset($post->graduationYear)) $user['graduationYear'] = $post->graduationYear;
			if (isset($post->degree)) $user['degree'] = $post->degree;
			if (isset($post->competitions)) $user['competitions'] = json_encode($post->competitions);
			if (isset($post->others)) $user['others'] = json_encode($post->others);
			// $result = $row->update($user, array(
			// $result = $row->save($user, array(
			$result = $row->update($user, array(
				// 'email', 'type', 'publications', 'first_name', 'last_name', 'updatedAt',
				'email', 'type', 'works', 'publications', 'updatedAt',
				'institution', 'graduationYear', 'degree', 'competitions', 'others'
			));;
		} else if ($type == 'practitioner') {
			$user['admissions'] = '';
			$user['area'] = '';
			$user['industry'] = '';
			// $user['awards'] = '';
			if (isset($post->admissions)) $user['admissions'] = json_encode($post->admissions);
			if (isset($post->area)) $user['area'] = $post->area;
			if (isset($post->industry)) $user['industry'] = $post->industry;
			// if (isset($post->awards)) $user['awards'] = json_encode($post->awards);
			// $result = $row->save($user, array(
			$result = $row->update($user, array(
				// 'username', 'account', 'email', 'password', 'type', 'publications',
				// 'firstName', 'lastName', 'createdAt', 'updatedAt',
				// 'email', 'type', 'publications', 'updatedAt',
				'type', 'works', 'publications', 'updatedAt',
				// 'admissions', 'area', 'industry', 'awards'
				'admissions', 'area', 'industry'
			));;
		}

		if (!$result) {
			$arr = array();
			foreach ($row->getMessages() as $message) {
				$arr[] = $message;
			}
			$messages['error'] = 'SAVE FAILED' . implode('&nbsp;&nbsp;&nbsp;', $arr);
			$arr = array(
				'status' => 'SAVE-FAILED',
				'messages' => $messages,
				// 'email' => $email,
				// 'rowContent' => $row,
				// 'updateContent' => $user,
				// 'result' => $result,
				// 'data' => $post
			);
			return $arr;
		} else {
			$messages['success'] = 'Your profile has been updated.';
			$arr = array(
				'status' => 'EDIT-DONE',
				'messages' => $messages,
			);
			return $arr;
		}
	}


	/**
	 * @function name:	public static function getNow()
	 * @description:	This function returns time of now in format of 'Y-m-d H:i:s' in time zone 'Asia/Taipei'.
	 * @related issues:	ITL-003
	 * @param:			void
	 * @return:			string $now
	 * @author:			Don Hsieh
	 * @since:			04/18/2015
	 * @last modified:	04/18/2015
	 * @called by:		public static function login($email, $password, $app)
	 *					 in php/app/models/User.php
	 */
	public static function getNow()
	{
		date_default_timezone_set('Asia/Taipei');
		$now = date('Y-m-d H:i:s');
		return $now;
	}

}
