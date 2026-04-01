<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Staf extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('staff_model', 'staff');
		$this->load->model('identitas_model', 'identitas');
	}
	
	public function index()
	{
		$data['title']		= 'Staff';
		$data['brand']		= $this->identitas->getData();
		$data['page']		= 'staf/index';
		$data['staff'] = $this->staff->getAllStaff();

		$this->load->view('front/layouts/main', $data);
	}

}

/* End of file Staf.php */
