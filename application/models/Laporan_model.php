<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	public function getSummary()
	{
		$summary = [];

		$this->db->from('posts');
		$summary['total_berita'] = $this->db->count_all_results();

		$this->db->from('posts');
		$this->db->where('is_active', 'Y');
		$summary['berita_aktif'] = $this->db->count_all_results();

		$this->db->from('posts');
		$this->db->where('is_active', 'N');
		$summary['berita_nonaktif'] = $this->db->count_all_results();

		$this->db->from('facilities');
		$summary['total_fasilitas'] = $this->db->count_all_results();

		$this->db->from('banners');
		$summary['total_banner'] = $this->db->count_all_results();

		return $summary;
	}

	public function getPostsByMonth($year = null)
	{
		if (!$year) {
			$year = date('Y');
		}

		$query = $this->db->query(
			"SELECT COUNT(id) as jumlah, MONTH(date) as bulan, MONTHNAME(date) as nama_bulan
			 FROM posts
			 WHERE YEAR(date) = ?
			 GROUP BY MONTH(date)
			 ORDER BY MONTH(date) ASC",
			[$year]
		);

		return $query->result();
	}

	public function getAllPosts($year = null, $month = null)
	{
		$this->db->select('id, title, is_active, date');
		$this->db->from('posts');

		if ($year) {
			$this->db->where('YEAR(date)', $year);
		}

		if ($month) {
			$this->db->where('MONTH(date)', $month);
		}

		$this->db->order_by('date', 'desc');
		return $this->db->get()->result();
	}

	public function getAvailableYears()
	{
		$query = $this->db->query(
			"SELECT DISTINCT YEAR(date) as tahun FROM posts ORDER BY tahun DESC"
		);
		return $query->result();
	}

	public function getBulanList()
	{
		return [
			1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
			4  => 'April',    5  => 'Mei',       6  => 'Juni',
			7  => 'Juli',     8  => 'Agustus',   9  => 'September',
			10 => 'Oktober',  11 => 'November',  12 => 'Desember'
		];
	}

}

/* End of file Laporan_model.php */
