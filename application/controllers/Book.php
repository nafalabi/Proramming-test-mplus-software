<?php
class Book extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Book_model','BModel');
		$this->load->model('Author_model','AModel');
		$this->load->model('Type_of_book_model','TModel');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('form_validation');
	}

	public function index(){
		//Init Data
		$data['title']='List Books';
		$data['page']='list';
		$resultData = array('status'=>array(),'value'=>array());
		$booklist = $this->BModel->read();
		
		//Check if there are book
		if ($booklist !=false){
			$resultData['status']=true;
			//Looping for Data validation
			for ($i=0; $i < count($booklist) ; $i++) { 
				//Data Extract and validation
				extract($booklist[$i]);
				$temp = array(
					'title' => $title, 
					'author' => $author, 
					'date_published' => date('d M Y',strtotime($date_published)), 
					'number_of_pages' => $number_of_pages, 
					'type' => $type
				);
				//Push to Reserved data var
				array_push($resultData['value'], $temp);
			}
		}
		else{
			$resultData['status'] = false;
		}
		//Load template
		$data['main']=$this->load->view('templates/list.php',$resultData,true);
		//load main template
		$this->load->view('templates/main',$data);
	}

	public function create(){
		//Init Data
		$data['title']='Create New Book';
		$data['page']='create';
		$dataMain = array();
		$Models=$this->AModel->read();
		$Types=$this->TModel->read();

		//Check if there are authors in the db
		if($Models!=false){
			$dataMain['authors'] = $Models;
		}
		//Check if there are types in the db
		if ($Types!=false) {
			$dataMain['types'] = $Types;
		}


		//Set Form Validation Rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|max_length[100]');
		$this->form_validation->set_rules('author', 'Author', 'trim|required');
		$this->form_validation->set_rules('pages', 'Number of Page', 'trim|required|integer');
		$this->form_validation->set_rules('type', 'Type of Book', 'trim|required');

		//Statement if the Form Validation is not running yet Or there is an error
		if($this->form_validation->run() == FALSE){
			//Load template
			$data['main']=$this->load->view('templates/create',$dataMain,true);
			//Load main template
			$this->load->view('templates/main',$data);
		}
		//Statement If the Form is submitted and pass all of the validation
		else{
			//Asssigning the submitted data into new variables
			$title=$this->input->post('title');
			$author=$this->input->post('author');
			$newAuthor=$this->input->post('newAuthor');
			$date_published = time();
			$pages=$this->input->post('pages');
			$type=$this->input->post('type');
			$newType=$this->input->post('newType');
			$author_id = $author;
			$type_id = $type;


			if ($author=='new') {
				$authorObj = new $this->AModel;
				$authorObj->name = $newAuthor;
				$result = $authorObj->create();
				if ($result['error']) {
					$this->session->set_flashdata('warning',$result['errorMsg']);
					redirect(base_url().'index.php/book/create','refresh');
				}else {
					$author = $authorObj->author_id;
				}
			}

			if ($type=='new') {
				$typeObj = new $this->TModel;
				$typeObj->name = $newType;
				$result = $typeObj->create();
				if ($result['error']) {
					$this->session->set_flashdata('warning',$result['errorMsg']);
					redirect(base_url().'index.php/book/create','refresh');
				}else {
					$type = $typeObj->type_id;
				}
			}

			//Assigning the data from new variables to new Book object
			$Book = new $this->BModel;
			$Book->title = $title;
			$Book->author_id = $author;
			$Book->date_published = $date_published;
			$Book->number_of_pages = $pages;
			$Book->type_id = $type;
			//Run the create procedure and retrive the error message
			$result=$Book->create();

			if($result['error']){
				$this->session->set_flashdata('warning',$result['errorMsg']);
			}
			else {
				$this->session->set_flashdata('success', 'Book Created');
			}

			redirect(base_url().'index.php/book/create','refresh');
		}
	}

	public function test(){
		
	}
}