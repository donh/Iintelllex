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

}
