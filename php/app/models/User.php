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
				if ($app->session->has('user')) {
					$app->session->destroy();
				}
				$app->session->set('user', $user);
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
