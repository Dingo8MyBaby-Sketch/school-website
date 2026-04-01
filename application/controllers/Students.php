<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

	var $table = 'students';
	var $id = 'id';
	var $select = ['*'];
	var $column_order = ['', 'student_id', 'name', 'class_id', 'email', 'photo'];
	var $column_search = ['student_id', 'name', 'email'];
	
	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('menu_model', 'menu');
		$this->load->model('my_model', 'my');
		$this->load->model('students_model', 'students');
		$this->load->model('classes_model', 'classes');
	}
	
	public function index()
	{
		$data['title'] 	 = 'Data Siswa';
		$data['page'] 		 = 'students/index';
		$data['datatable'] = 'students/index-datatable';
		
		$this->load->view('back/layouts/main', $data);
	}

	public function ajax_list()
	{
		$list = $this->my->get_datatables();
		$data = [];
		$no = 1;
		foreach($list as $li){
			// Get class name
			$class_name = '-';
			if($li->class_id){
				$class = $this->classes->getDataById($li->class_id);
				if($class){
					$class_name = $class->name . ' (' . $class->grade . ')';
				}
			}

			$row = [];
			$row[] = $no++;
			$row[] = $li->student_id;
			$row[] = $li->name;
			$row[] = $class_name;
			$row[] = $li->email;

			if($li->photo){
				$row[] = '<a href="' . base_url('img/students/' . $li->photo).'" target="_blank"><img src="'.base_url('img/students/' . $li->photo) . '" class="img-responsive" style="max-height:150px; max-width:400px;"/></a>';
			}else{
				$row[] = '(No photo)';
			}

			$row[] = 
			'<a class="btn btn-sm btn-warning text-white" href="'.base_url("students/edit/$li->id").'" 
			title="Edit">
			<i class="fa fa-pencil-alt"></i></a>

			<a class="btn btn-sm btn-danger" href="#" 
			title="Delete" onclick="delete_student('."'".$li->id."'".')">
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
			$input = (object) $this->students->getDefaultValues();
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('student_id', 'NIS','required',[
			'required' => 'NIS tidak boleh kosong!'
			]
		);
		$this->form_validation->set_rules('name', 'Nama Siswa','required',[
			'required' => 'Nama siswa tidak boleh kosong!'
			]
		);

		if($this->form_validation->run() == false){
			$data['title'] 		= 'Tambah Siswa';
			$data['page']			= 'students/form';
			$data['form_action'] = base_url("students/add");
			$data['input'] 		= $input;
			$data['classes_list'] = $this->classes->getAllClasses();
			$this->load->view('back/layouts/main', $data);
		}else{
			
			$data = [
				'student_id' => $this->input->post('student_id', true),
				'name' => $this->input->post('name', true),
				'class_id' => $this->input->post('class_id', true),
				'email' => $this->input->post('email', true),
				'phone' => $this->input->post('phone', true),
				'address' => $this->input->post('address'),
			];

			if(!empty($_FILES['photo']['name'])){
				$imageName = url_title($data['name'], '-', true) . '-' . date('YmdHis');
				$upload = $this->students->uploadImage($imageName);
				if($upload){
					$data['photo'] = $upload;
				}
			}
			
			$this->students->insert($data);
			$this->session->set_flashdata('success', 'Siswa Berhasil Ditambahkan.');

			redirect(base_url('students'));
		}
	}

	public function edit($id)
	{
		if(!$_POST){
			$input = (object) $this->students->getDataById($id);
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('student_id', 'NIS','required',[
			'required' => 'NIS tidak boleh kosong!'
			]
		);
		$this->form_validation->set_rules('name', 'Nama Siswa','required',[
			'required' => 'Nama siswa tidak boleh kosong!'
			]
		);

		if($this->form_validation->run() == false){
			$data['title']			= 'Ubah Siswa';
			$data['page']			= 'students/form';
			$data['input']			= $input;
			$data['form_action']	= base_url('students/edit/' . $id);
			$data['classes_list'] = $this->classes->getAllClasses();
			
			$this->load->view('back/layouts/main', $data);
		}else{
			$data = [
				'student_id' => $this->input->post('student_id', true),
				'name' => $this->input->post('name', true),
				'class_id' => $this->input->post('class_id', true),
				'email' => $this->input->post('email', true),
				'phone' => $this->input->post('phone', true),
				'address' => $this->input->post('address'),
			];

			if(!empty($_FILES['photo']['name'])){
				$imageName = url_title($data['name'], '-', true) . '-' . date('YmdHis');
				$upload = $this->students->uploadImage($imageName);

				if($upload){
					$student = $this->students->getDataById($id);

					if($student->photo && file_exists('img/students/' . $student->photo)){
						unlink('img/students/' . $student->photo);
					}
					
					$data['photo'] = $upload;
				}else{
					redirect(base_url("students/edit/$id"));
				}
			}

			$this->students->update($id, $data);
			$this->session->set_flashdata('success', 'Siswa Berhasil Diupdate.');

			redirect(base_url('students'));
		}
	}

	public function delete()
	{
		$id = $this->input->post('id', true);
		$student = $this->students->getDataById($id);

		if($student->photo && file_exists('img/students/' . $student->photo)){
			unlink('img/students/' . $student->photo);
		}

		$this->students->delete($id);
		echo json_encode(["status" => TRUE]);
	}

}

/* End of file Students.php */
