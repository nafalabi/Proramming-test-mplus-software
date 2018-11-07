<?php
class Book extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Book_model','BModel');
		$this->load->helper('url');
	}

	public function index(){
		//Init Data
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
		//Add last variable of Data
		$data['page']='list';
		$data['main']=$this->load->view('templates/list.php',$resultData,true);
		//sending data to view
		$this->load->view('templates/main.php',$data);
	}
}