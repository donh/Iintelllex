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

}
