<?php
	class Type_of_book_model extends CI_Model {
		private $table = 'type_of_book';


		//Properties
		public $type_id;
		public $name;
		public $created_at;

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function read() {
			$query = $this->db->query(
				'SELECT * FROM '.$this->table.' ORDER BY created_at'
			);

			if($query->num_rows() > 0){
				return $query->result_array();
			}
			else{
				return false;
			}
		}

		public function create() {
			$name = $this->db->escape($this->name);

			//Check Duplicated Names
			$checkname = $this->db->query('Select * From '.$this->table.' Where name='.$name);
			if ($checkname->num_rows() > 0) {
				return array(
					'error' => true,
					'errorMsg' => 'Duplicated New Type Name'
				);
			}

			//Define Query for Inserting
			$query = $this->db->query(
				'INSERT INTO '.$this->table.' (`name`) 
				VALUES ('.$name.')'
			);

			//IF Query error
			if(!$query){
				return array(
					'error' => true,
					'errorMsg' => $this->db->error()
				);
			}
			else {
				$current = $this->db->query('Select * From '.$this->table.' Where name='.$name.' limit 1')->result_array();
				$this->type_id = $current[0]['type_id'];
				$this->created_at = $current[0]['created_at'];
				return array(
					'error' => false,
					'errorMsg' => null
				);
			}
		}
	}
?>