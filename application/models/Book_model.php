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
			$query = $this->db->query(
			'SELECT 
				b.id,
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
			$title = $this->db->escape($this->title);
			$author_id = $this->db->escape($this->author_id);
			$number_of_pages = $this->db->escape($this->number_of_pages);
			$type_id = $this->db->escape($this->type_id);

			//Check for Duplicated Title
			$checkname = $this->db->query('Select * From '.$this->table.' Where title='.$title);
			if ($checkname->num_rows() > 0) {
				return array(
					'error' => true,
					'errorMsg' => 'Duplicated Title Name'
				);
			}

			//Define the query
			$query = $this->db->query(
				'INSERT INTO '.$this->table.' (`title`,`author_id`,`date_published`,`number_of_pages`,`type_id`)
				VALUES 
				('.$title.',
				'.$author_id.',
				CURRENT_TIMESTAMP,
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

		public function update(){
			//Escaping params
			$id = $this->db->escape($this->id);
			$title = $this->db->escape($this->title);
			$author_id = $this->db->escape($this->author_id);
			$author_name = $this->db->escape($this->author_name);
			$date_published = $this->db->escape($this->date_published);
			$number_of_pages = $this->db->escape($this->number_of_pages);
			$type_id = $this->db->escape($this->type_id);
			$type_name = $this->db->escape($this->type_name);

			//Define the Query
			$query = $this->db->query('
				UPDATE '.$this->table.'
				SET
					`title` =  '.$title.',
					`author_id` = '.$author_id.',
					`number_of_pages` = '.$number_of_pages.',
					`type_id` = '.$type_id.'
				WHERE
					`id` = '.$id);

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

		public function findOne($id){
			$id = $this->db->escape($id);
			$query = $this->db->query(
				'SELECT 
					b.id,
					b.title , 
					b.author_id,
					a.name as author,  
					b.date_published,
					b.number_of_pages,
					b.type_id,
					t.name as type
				FROM '.$this->table.' b 
				LEFT JOIN author a 
					ON b.author_id = a.author_id
				LEFT JOIN type_of_book t
					ON t.type_id = b.type_id 
				WHERE id='.$id.'
				ORDER BY b.date_published
				LIMIT 1');

			if (($query->num_rows()) > 0) {
				extract($query->result_array()[0]);
				$this->id = $id;
				$this->title = $title;
				$this->author_id = $author_id;
				$this->author_name = $author;
				$this->date_published = $date_published;
				$this->number_of_pages = $number_of_pages;
				$this->type_id = $type_id;
				$this->type_name = $type;

				return array(
					'id' => $this->id,
					'title' => $this->title,
					'author_id' => $this->author_id,
					'author_name' => $this->author_name,
					'date_published' => $this->date_published,
					'number_of_pages' => $this->number_of_pages,
					'type_id' => $this->type_id,
					'type_name' => $this->type_name
				);
			}
			else{
				return false;
			}
		}
	}
?>