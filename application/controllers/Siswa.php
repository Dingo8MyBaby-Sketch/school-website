<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('students_model', 'students');
		$this->load->model('identitas_model', 'identitas');
	}
	
	public function index()
	{
		$data['title']		= 'Siswa';
		$data['brand']		= $this->identitas->getData();
		$data['page']		= 'siswa/index';
		$data['students'] = $this->students->getAllStudents();

		$this->load->view('front/layouts/main', $data);
	}

}

/* End of file Siswa.php */
