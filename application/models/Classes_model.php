<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes_model extends CI_Model {

	public function getDataById($id)
	{
		return $this->db->get_where('classes', ['id' => $id])->row();
	}

	public function getAllClasses()
	{
		$this->db->select('classes.*, staff.name as teacher_name');
		$this->db->from('classes');
		$this->db->join('staff', 'staff.id = classes.teacher_id', 'left');
		$this->db->order_by('classes.grade', 'ASC');
		$this->db->order_by('classes.name', 'ASC');
		return $this->db->get()->result();
	}

	public function insert($data)
	{
		$this->db->insert('classes', $data);
	}

	public function update($id, $data)
	{
		$this->db->update('classes', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('classes');
	}

	public function getDefaultValues()
	{
		return [
			'name'          => '',
			'grade'         => '',
			'description'   => '',
			'schedule'      => '',
			'teacher_id'    => '',
			'photo'         => '',
		];
	}

	public function totalClasses()
	{
		$this->db->from('classes');
		return $this->db->count_all_results();
	}
	
	public function uploadImage($imageName){
		$config = [
			'upload_path'     => './img/classes',
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

/* End of file Classes_model.php */
