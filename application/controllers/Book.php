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
		$this->load->database();
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
					'id' => $id,
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
			//Asssigning Posts data into new (reserved) variables
			$title=$this->input->post('title');
			$author=$this->input->post('author');
			$newAuthor=$this->input->post('newAuthor');
			$date_published = time();
			$pages=$this->input->post('pages');
			$type=$this->input->post('type');
			$newType=$this->input->post('newType');
			$author_id = $author;
			$type_id = $type;

			//Statement if new author inserted
			if ($author=='new') {
				//create new author object
				$authorObj = new $this->AModel;
				$authorObj->name = $newAuthor;
				$result = $authorObj->create();
				//if there is an error
				if ($result['error']) {
					$this->session->set_flashdata('warning',$result['errorMsg']);
					redirect(base_url().'index.php/book/create','refresh');
				}else {
					//Assign new ID of author to reserved variable
					$author = $authorObj->author_id;
				}
			}
			//Statement if new type of book inserted
			if ($type=='new') {
				//create new type of book object
				$typeObj = new $this->TModel;
				$typeObj->name = $newType;
				$result = $typeObj->create();
				//if there is an error
				if ($result['error']) {
					$this->session->set_flashdata('warning',$result['errorMsg']);
					redirect(base_url().'index.php/book/create','refresh');
				}else {
					//Assign new ID of type to reserved variable
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
			//if there is an error while creating
			if($result['error']){
				$this->session->set_flashdata('warning',$result['errorMsg']);
			}
			else {
				$this->session->set_flashdata('success', 'Book Created');
			}
			//refresh the page
			redirect(base_url().'index.php/book/');
		}
	}

	public function edit($id=null){
		//if ID is NOT defined
		if($id==null){
			$this->index();
		//if ID is defined
		}else{

			//Set Form Validation Rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|max_length[100]');
			$this->form_validation->set_rules('author', 'Author', 'trim|required');
			$this->form_validation->set_rules('pages', 'Number of Page', 'trim|required|integer');
			$this->form_validation->set_rules('type', 'Type of Book', 'trim|required');

			//Statement if the Form Validation is not running yet Or there is an error
			if($this->form_validation->run() == FALSE){
				//Init Data
				$data['title'] = 'Edit Data';
				$data['page'] = 'edit';
				$data['result'] = array();
				$data['author'] = array();
				$data['types'] = array();

				if(!intval($id)){
					$this->session->set_flashdata('warning','Edit error,  book ID is not valid.');
					redirect(base_url().'index.php/book/');
				}

				$Book = new $this->BModel;
				$result = $Book->findOne($id);
				if($result ==  false){
					$this->session->set_flashdata('warning','Edit error,  book not found.');
					redirect(base_url().'index.php/book/');
				}else {
					$data['result']=$result;
				}

				$Models=$this->AModel->read();
				$Types=$this->TModel->read();
				//Check if there are authors in the db
				if($Models!=false){
					$data['authors'] = $Models;
				}
				//Check if there are types in the db
				if ($Types!=false) {
					$data['types'] = $Types;
				}

				$data['main'] = $this->load->view('templates/edit',$data,true);
				$this->load->view('templates/main',$data);
			}
			//Statement If the Form is submitted and pass all of the validation
			else{
				//Asssigning Posts data into new (reserved) variables
				$id = $this->input->post('id');
				$title=$this->input->post('title');
				$author=$this->input->post('author');
				$newAuthor=$this->input->post('newAuthor');
				$pages=$this->input->post('pages');
				$type=$this->input->post('type');
				$newType=$this->input->post('newType');
				$author_id = $author;
				$type_id = $type;

				//Statement if new author inserted
				if ($author=='new') {
					//create new author object
					$authorObj = new $this->AModel;
					$authorObj->name = $newAuthor;
					$result = $authorObj->create();
					//if there is an error
					if ($result['error']) {
						$this->session->set_flashdata('warning',$result['errorMsg']);
						redirect(base_url().'index.php/book/','refresh');
					}else {
						//Assign new ID of author to reserved variable
						$author = $authorObj->author_id;
					}
				}
				//Statement if new type of book inserted
				if ($type=='new') {
					//create new type of book object
					$typeObj = new $this->TModel;
					$typeObj->name = $newType;
					$result = $typeObj->create();
					//if there is an error
					if ($result['error']) {
						$this->session->set_flashdata('warning',$result['errorMsg']);
						redirect(base_url().'index.php/book/','refresh');
					}else {
						//Assign new ID of type to reserved variable
						$type = $typeObj->type_id;
					}
				}

				//Assigning the data from new variables to new Book object
				$Book = new $this->BModel;
				$Book->id = $id;
				$Book->title = $title;
				$Book->author_id = $author;
				$Book->number_of_pages = $pages;
				$Book->type_id = $type;
				//Run the create procedure and retrive the error message
				$result=$Book->update();
				//if there is an error while creating
				if($result['error']){
					$this->session->set_flashdata('warning',$result['errorMsg']);
				}
				else {
					$this->session->set_flashdata('success', 'Book Edited');
				}
				//refresh the page
				redirect(base_url().'index.php/book/','refresh');
			}
		}
	}

	public function delete($id=null){
		//IF the ID is null OR not defined in the url
		if($id==null){
			$this->index();
		}
		//IF the ID is Defined in the url
		else{
			//Set Form Validation Rules
			$this->form_validation->set_rules('id', 'ID', 'trim|required|integer');
			$this->form_validation->set_rules('confirm', 'Confirmation', 'trim|required');
			//Statement if the Form Validation is not running yet Or there is an error
			if($this->form_validation->run() == FALSE){
				//Init Data
				$data['title'] = 'Delete Data';
				$data['page'] = 'delete';
				$data['result'] = array();
				//Check if the ID is integer
				if(!intval($id)){
					$this->session->set_flashdata('warning','Edit error,  book ID is not valid.');
					redirect(base_url().'index.php/book/');
				}
				//Check if the book is exist in the db
				$Book = new $this->BModel;
				$result = $Book->findOne($id);
				if($result == false){
					$this->session->set_flashdata('warning','Edit error,  book not found.');
					redirect(base_url().'index.php/book/');
				}else {
					$data['result']=$result;
				}

				$data['main']=$this->load->view('templates/delete',$data,true);
				$this->load->view('templates/main',$data);
			}
			//Statement If the Form is submitted and pass all of the validation
			else{
				$id = $this->input->post('id');
				$confirm = $this->input->post('confirm');

				if(is_string($confirm)){
					if($confirm!='CONFIRM'){
						$this->session->set_flashdata('warning','Confirmation word is not valid');
						redirect(base_url().'index.php/book/delete/'.$id);
					}
				}
				if(!is_numeric($id)){
					$this->session->set_flashdata('warning','Book ID is not valid');
					redirect(base_url().'index.php/book/delete/'.$id);
				}

				//Check if the book is exist in the db
				$Book = new $this->BModel;
				$findResult = $Book->findOne($id);
				if($findResult == false){
					$this->session->set_flashdata('warning','Delete error,  book not found.');
					redirect(base_url().'index.php/book/');
				}

				$delResult = $this->BModel->delete($findResult['id']);
				if($delResult['error'] == true){
					$this->session->set_flashdata('warning',$delResult['errorMsg']);
					redirect(base_url().'index.php/book/');
				}else{
					$this->session->set_flashdata('success', 'Book Deleted');
				}
				//refresh the page
				redirect(base_url().'index.php/book/');
			}
		}
	}
}