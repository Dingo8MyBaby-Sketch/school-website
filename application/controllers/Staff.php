<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

	var $table = 'staff';
	var $id = 'id';
	var $select = ['*'];
	var $column_order = ['', 'name', 'position', 'email', 'photo'];
	var $column_search = ['name', 'position', 'email'];
	
	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('menu_model', 'menu');
		$this->load->model('my_model', 'my');
		$this->load->model('staff_model', 'staff');
	}
	
	public function index()
	{
		$data['title'] 	 = 'Data Staff';
		$data['page'] 		 = 'staff/index';
		$data['datatable'] = 'staff/index-datatable';
		
		$this->load->view('back/layouts/main', $data);
	}

	public function ajax_list()
	{
		$list = $this->my->get_datatables();
		$data = [];
		$no = 1;
		foreach($list as $li){
			$row = [];
			$row[] = $no++;
			$row[] = $li->name;
			$row[] = $li->position;
			$row[] = $li->email;

			if($li->photo){
				$row[] = '<a href="' . base_url('img/staff/' . $li->photo).'" target="_blank"><img src="'.base_url('img/staff/' . $li->photo) . '" class="img-responsive" style="max-height:150px; max-width:400px;"/></a>';
			}else{
				$row[] = '(No photo)';
			}

			$row[] = 
			'<a class="btn btn-sm btn-warning text-white" href="'.base_url("staff/edit/$li->id").'" 
			title="Edit">
			<i class="fa fa-pencil-alt"></i></a>

			<a class="btn btn-sm btn-danger" href="#" 
			title="Delete" onclick="delete_staff('."'".$li->id."'".')">
			<i class="fa fa-trash"></i></a>';
			$data[] = $row;
		}

		$output = [
			'draw'            => $_POST['draw'],
			'recordsTotal'    => $this->my->count_all(),
			'recordsFiltered' => $this->my->count_filtered(),
			'data'            => $data
		];

		echo json_encode($output);
	}

	public function add()
	{
		if(!$_POST){
			$input = (object) $this->staff->getDefaultValues();
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('name', 'Nama','required',[
			'required' => 'Nama staff tidak boleh kosong!'
			]
		);
		$this->form_validation->set_rules('position', 'Posisi','required',[
			'required' => 'Posisi tidak boleh kosong!'
			]
		);

		if($this->form_validation->run() == false){
			$data['title'] 		= 'Tambah Staff';
			$data['page']			= 'staff/form';
			$data['form_action'] = base_url("staff/add");
			$data['input'] 		= $input;
			$this->load->view('back/layouts/main', $data);
		}else{
			
			$data = [
				'name' => $this->input->post('name', true),
				'position' => $this->input->post('position', true),
				'email' => $this->input->post('email', true),
				'phone' => $this->input->post('phone', true),
				'bio' => $this->input->post('bio'),
			];

			if(!empty($_FILES['photo']['name'])){
				$imageName = url_title($data['name'], '-', true) . '-' . date('YmdHis');
				$upload = $this->staff->uploadImage($imageName);
				if($upload){
					$data['photo'] = $upload;
				}
			}
			
			$this->staff->insert($data);
			$this->session->set_flashdata('success', 'Staff Berhasil Ditambahkan.');

			redirect(base_url('staff'));
		}
	}

	public function edit($id)
	{
		if(!$_POST){
			$input = (object) $this->staff->getDataById($id);
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('name', 'Nama','required',[
			'required' => 'Nama staff tidak boleh kosong!'
			]
		);
		$this->form_validation->set_rules('position', 'Posisi','required',[
			'required' => 'Posisi tidak boleh kosong!'
			]
		);

		if($this->form_validation->run() == false){
			$data['title']			= 'Ubah Staff';
			$data['page']			= 'staff/form';
			$data['input']			= $input;
			$data['form_action']	= base_url('staff/edit/' . $id);
			
			$this->load->view('back/layouts/main', $data);
		}else{
			$data = [
				'name' => $this->input->post('name', true),
				'position' => $this->input->post('position', true),
				'email' => $this->input->post('email', true),
				'phone' => $this->input->post('phone', true),
				'bio' => $this->input->post('bio'),
			];

			if(!empty($_FILES['photo']['name'])){
				$imageName = url_title($data['name'], '-', true) . '-' . date('YmdHis');
				$upload = $this->staff->uploadImage($imageName);

				if($upload){
					$staff = $this->staff->getDataById($id);

					if(file_exists('img/staff/' . $staff->photo) && $staff->photo){
						unlink('img/staff/' . $staff->photo);
					}
					
					$data['photo'] = $upload;
				}else{
					redirect(base_url("staff/edit/$id"));
				}
			}

			$this->staff->update($id, $data);
			$this->session->set_flashdata('success', 'Staff Berhasil Diupdate.');

			redirect(base_url('staff'));
		}
	}

	public function delete()
	{
		$id = $this->input->post('id', true);
		$staff = $this->staff->getDataById($id);

		if(file_exists('img/staff/' . $staff->photo) && $staff->photo){
			unlink('img/staff/' . $staff->photo);
		}

		$this->staff->delete($id);
		echo json_encode(["status" => TRUE]);
	}

}

/* End of file Staff.php */
