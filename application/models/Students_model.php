<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model {

	public function getDataById($id)
	{
		return $this->db->get_where('students', ['id' => $id])->row();
	}

	public function getAllStudents()
	{
		$this->db->select('students.*, classes.name as class_name, classes.grade');
		$this->db->from('students');
		$this->db->join('classes', 'classes.id = students.class_id', 'left');
		$this->db->order_by('students.student_id', 'ASC');
		return $this->db->get()->result();
	}

	public function insert($data)
	{
		$this->db->insert('students', $data);
	}

	public function update($id, $data)
	{
		$this->db->update('students', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('students');
	}

	public function getDefaultValues()
	{
		return [
			'student_id'    => '',
			'name'        	=> '',
			'class_id'      => '',
			'email'         => '',
			'phone'         => '',
			'address'       => '',
			'photo'         => '',
		];
	}

	public function totalStudents()
	{
		$this->db->from('students');
		return $this->db->count_all_results();
	}
	
	public function uploadImage($imageName){
		$config = [
			'upload_path'     => './img/students',
			'file_name'       => $imageName,
			'allowed_types'   => 'jpg|jpeg|png|JPG|PNG',
			'max_size'        => 3000,
			'max_width'       => 0,
			'max_height'      => 0,
			'overwrite'       => TRUE,
			'file_ext_tolower'=> TRUE
		];
	
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload('photo')){
			return $this->upload->data('file_name');
		}else{
			$this->session->set_flashdata('image_error', 'Jenis file yang diupload tidak diizinkan atau file terlalu besar.');
			return false;
		}
	}

}

/* End of file Students_model.php */
