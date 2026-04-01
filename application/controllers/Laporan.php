<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('menu_model', 'menu');
		$this->load->model('laporan_model', 'laporan');
	}

	public function index()
	{
		$year  = $this->input->get('tahun', true);
		$month = $this->input->get('bulan', true);

		if (!$year) {
			$year = date('Y');
		}

		$data['title']          = 'Laporan';
		$data['page']           = 'laporan/index';
		$data['summary']        = $this->laporan->getSummary();
		$data['posts_by_month'] = $this->laporan->getPostsByMonth($year);
		$data['posts']          = $this->laporan->getAllPosts($year, $month);
		$data['years']          = $this->laporan->getAvailableYears();
		$data['selected_year']  = $year;
		$data['selected_month'] = $month;
		$data['bulan_list']     = $this->laporan->getBulanList();

		$this->load->view('back/layouts/main', $data);
	}

	public function print_report()
	{
		$year  = $this->input->get('tahun', true);
		$month = $this->input->get('bulan', true);

		if (!$year) {
			$year = date('Y');
		}

		$data['title']          = 'Cetak Laporan';
		$data['summary']        = $this->laporan->getSummary();
		$data['posts_by_month'] = $this->laporan->getPostsByMonth($year);
		$data['posts']          = $this->laporan->getAllPosts($year, $month);
		$data['selected_year']  = $year;
		$data['selected_month'] = $month;
		$data['bulan_list']     = $this->laporan->getBulanList();

		$this->load->view('back/pages/laporan/print', $data);
	}

}

/* End of file Laporan.php */
