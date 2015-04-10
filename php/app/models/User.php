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
	public $type;

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
			'username' => 'username', 
			'firstName' => 'firstName', 
			'lastName' => 'lastName', 
			'email' => 'email', 
			'ip' => 'ip', 
			'ips' => 'ips', 
			'type' => 'type', 
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
			'institution' => 'institution', 
			'graduationYear' => 'graduationYear', 
			'degree' => 'degree', 
			'company' => 'company', 
			'monthFrom' => 'monthFrom', 
			'yearFrom' => 'yearFrom', 
			'monthTo' => 'monthTo', 
			'yearTo' => 'yearTo', 
			'supervisor' => 'supervisor', 
			'competitionName' => 'competitionName', 
			'competitionResult' => 'competitionResult', 
			'qualification' => 'qualification', 
			'qualificationYear' => 'qualificationYear', 
			'password' => 'password', 
			'createdAt' => 'createdAt', 
			'updatedAt' => 'updatedAt'
		);
	}

}
