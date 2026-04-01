<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('classes_model', 'classes');
		$this->load->model('identitas_model', 'identitas');
	}
	
	public function index()
	{
		$data['title']		= 'Kelas';
		$data['brand']		= $this->identitas->getData();
		$data['page']		= 'kelas/index';
		$data['classes'] = $this->classes->getAllClasses();

		$this->load->view('front/layouts/main', $data);
	}

}

/* End of file Kelas.php */
