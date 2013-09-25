<?php
	class Issue extends CI_Model {
		/*
		* Issue Unique Identifier 
		* @var :int
		*/ 
		public $issue_id;
		/*
		* Publication Unique Record
		* @var :int
		*/ 
		public $publication_id;
		/*
		* Publisher Assigned Number
		* @var :int
		*/ 
		public $issue_number;
		/*
		* Publication Unique Record
		* @var :string
		*/ 
		public $issue_date_publication;
		/*
		* Path to the file containing the cover image
		* @var :string
		*/ 
		public $issue_cover;
	}
?>