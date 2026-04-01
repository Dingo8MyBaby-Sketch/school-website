<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {

	public function getDataById($id)
	{
		return $this->db->get_where('staff', ['id' => $id])->row();
	}

	public function getAllStaff()
	{
		return $this->db->order_by('created_at', 'DESC')->get('staff')->result();
	}

	public function insert($data)
	{
		$this->db->insert('staff', $data);
	}

	public function update($id, $data)
	{
		$this->db->update('staff', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('staff');
	}

	public function getDefaultValues()
	{
		return [
			'name'        	=> '',
			'position'      => '',
			'email'         => '',
			'phone'         => '',
			'bio'           => '',
			'photo'         => '',
		];
	}

	public function totalStaff()
	{
		$this->db->from('staff');
		return $this->db->count_all_results();
	}
	
	public function uploadImage($imageName){
		$config = [
			'upload_path'     => './img/staff',
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

/* End of file Staff_model.php */
