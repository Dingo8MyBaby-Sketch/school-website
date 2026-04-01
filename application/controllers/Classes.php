<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {

	var $table = 'classes';
	var $id = 'id';
	var $select = ['*'];
	var $column_order = ['', 'name', 'grade', 'teacher_id', 'photo'];
	var $column_search = ['name', 'grade', 'description'];
	
	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('menu_model', 'menu');
		$this->load->model('my_model', 'my');
		$this->load->model('classes_model', 'classes');
		$this->load->model('staff_model', 'staff');
	}
	
	public function index()
	{
		$data['title'] 	 = 'Data Kelas';
		$data['page'] 		 = 'classes/index';
		$data['datatable'] = 'classes/index-datatable';
		
		$this->load->view('back/layouts/main', $data);
	}

	public function ajax_list()
	{
		$list = $this->my->get_datatables();
		$data = [];
		$no = 1;
		foreach($list as $li){
			// Get teacher name
			$teacher_name = '-';
			if($li->teacher_id){
				$teacher = $this->staff->getDataById($li->teacher_id);
				if($teacher){
					$teacher_name = $teacher->name;
				}
			}

			$row = [];
			$row[] = $no++;
			$row[] = $li->name;
			$row[] = $li->grade;
			$row[] = $teacher_name;

			if($li->photo){
				$row[] = '<a href="' . base_url('img/classes/' . $li->photo).'" target="_blank"><img src="'.base_url('img/classes/' . $li->photo) . '" class="img-responsive" style="max-height:150px; max-width:400px;"/></a>';
			}else{
				$row[] = '(No photo)';
			}

			$row[] = 
			'<a class="btn btn-sm btn-warning text-white" href="'.base_url("classes/edit/$li->id").'" 
			title="Edit">
			<i class="fa fa-pencil-alt"></i></a>

			<a class="btn btn-sm btn-danger" href="#" 
			title="Delete" onclick="delete_class('."'".$li->id."'".')">
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
			$input = (object) $this->classes->getDefaultValues();
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('name', 'Nama Kelas','required',[
			'required' => 'Nama kelas tidak boleh kosong!'
			]
		);
		$this->form_validation->set_rules('grade', 'Tingkat','required',[
			'required' => 'Tingkat tidak boleh kosong!'
			]
		);

		if($this->form_validation->run() == false){
			$data['title'] 		= 'Tambah Kelas';
			$data['page']			= 'classes/form';
			$data['form_action'] = base_url("classes/add");
			$data['input'] 		= $input;
			$data['staff_list'] = $this->staff->getAllStaff();
			$this->load->view('back/layouts/main', $data);
		}else{
			
			$data = [
				'name' => $this->input->post('name', true),
				'grade' => $this->input->post('grade', true),
				'description' => $this->input->post('description'),
				'schedule' => $this->input->post('schedule'),
				'teacher_id' => $this->input->post('teacher_id', true),
			];

			if(!empty($_FILES['photo']['name'])){
				$imageName = url_title($data['name'], '-', true) . '-' . date('YmdHis');
				$upload = $this->classes->uploadImage($imageName);
				if($upload){
					$data['photo'] = $upload;
				}
			}
			
			$this->classes->insert($data);
			$this->session->set_flashdata('success', 'Kelas Berhasil Ditambahkan.');

			redirect(base_url('classes'));
		}
	}

	public function edit($id)
	{
		if(!$_POST){
			$input = (object) $this->classes->getDataById($id);
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('name', 'Nama Kelas','required',[
			'required' => 'Nama kelas tidak boleh kosong!'
			]
		);
		$this->form_validation->set_rules('grade', 'Tingkat','required',[
			'required' => 'Tingkat tidak boleh kosong!'
			]
		);

		if($this->form_validation->run() == false){
			$data['title']			= 'Ubah Kelas';
			$data['page']			= 'classes/form';
			$data['input']			= $input;
			$data['form_action']	= base_url('classes/edit/' . $id);
			$data['staff_list'] = $this->staff->getAllStaff();
			
			$this->load->view('back/layouts/main', $data);
		}else{
			$data = [
				'name' => $this->input->post('name', true),
				'grade' => $this->input->post('grade', true),
				'description' => $this->input->post('description'),
				'schedule' => $this->input->post('schedule'),
				'teacher_id' => $this->input->post('teacher_id', true),
			];

			if(!empty($_FILES['photo']['name'])){
				$imageName = url_title($data['name'], '-', true) . '-' . date('YmdHis');
				$upload = $this->classes->uploadImage($imageName);

				if($upload){
					$class = $this->classes->getDataById($id);

					if($class->photo && file_exists('img/classes/' . $class->photo)){
						unlink('img/classes/' . $class->photo);
					}
					
					$data['photo'] = $upload;
				}else{
					redirect(base_url("classes/edit/$id"));
				}
			}

			$this->classes->update($id, $data);
			$this->session->set_flashdata('success', 'Kelas Berhasil Diupdate.');

			redirect(base_url('classes'));
		}
	}

	public function delete()
	{
		$id = $this->input->post('id', true);
		$class = $this->classes->getDataById($id);

		if($class->photo && file_exists('img/classes/' . $class->photo)){
			unlink('img/classes/' . $class->photo);
		}

		$this->classes->delete($id);
		echo json_encode(["status" => TRUE]);
	}

}

/* End of file Classes.php */
