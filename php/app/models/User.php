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

}
