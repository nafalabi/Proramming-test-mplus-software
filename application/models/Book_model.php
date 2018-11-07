<?php
	class Book_model extends CI_Model {
		private $table = 'book';


		//Properties
		public $id;
		public $title;
		public $author_id;
		public $author_name;
		public $date_published;
		public $number_of_pages;
		public $type_id;
		public $type_name;


		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function read() {
			//Define the query
			$query = $this->db->query('SELECT 
				b.title , 
				a.name as author,  
				b.date_published,
				b.number_of_pages,
				t.name as type
			FROM '. $this->table .' b
			LEFT JOIN author a 
				ON b.author_id = a.author_id
			LEFT JOIN type_of_book t
				ON t.type_id = b.type_id
			ORDER BY
				b.date_published');


			if (($query->num_rows()) > 0) {
				return $query->result_array();
			}
			else{
				return false;
			}
		}

		public function create(){
			//Escaping params
			$id = $this->db->escape($id);
			$title = $this->db->escape($title);
			$author_id = $this->db->escape($author_id);
			$date_published = $this->db->escape($date_published);
			$number_of_pages = $this->db->escape($number_of_pages);
			$type_id = $this->db->escape($type_id);

			//Define the query
			$query = $this->db->query(
				'INSERT INTO '.$table.' (`title`,`author_id`,`date_published`,`number_of_pages`,`type_id)
				VALUES 
				('.$title.',
				'.$author_id.',
				'.$date_published.',
				'.$number_of_pages.',
				'.$type_id.')'
			);

			if(!$query){
				return array(
					'error' => true,
					'errorMsg' => $this->db->error()
				);
			}
			else {
				return array(
					'error' => false,
					'errorMsg' => null
				);
			}

		}
	}
?>