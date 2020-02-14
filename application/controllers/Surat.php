<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {
    
    public function __construct()
	{
        parent::__construct();
		$this->load->model('M_nomor');
		is_logged_in();
    }
    
    public function index()
    {
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['title'] = 'Tampil Surat';
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar');
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('nomor/index', $data);
        $this->load->view('templates/report_footer');
	}
	
	public function buatnomor()
	{
		$data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
		$data['title'] = 'Buat Nomor';
		$data['entity'] = $this->M_nomor->getEntity();
		$data['no'] = $this->M_nomor->getAll();
		

		$this->form_validation->set_rules('no', '<b>No</b>', 'required');
		$this->form_validation->set_rules('perihal', '<b>Perihal</b>', 'required');
		if ($this->form_validation->run() == false) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar');
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('nomor/buatnomor', $data);
            $this->load->view('templates/report_footer');
		} else {
			$data = [
				'no_surat' => $this->input->post('no'),
				'perihal' => $this->input->post('perihal'),
				'pic' => $this->input->post('pic'),
				'jenis_surat' => $this->input->post('jenis'),
				'note' => $this->input->post('note'),
				'tahun' => date('Y')
			];
			
			$this->db->insert('surat_keluar', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Success Added</div>');
			redirect('surat/buatnomor','refresh');
		}
	}

    public function ajax_no()
    {
        $list = $this->M_nomor->getListDataTables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $noSur) {
            $no++;
            $row = array();
            $row[] = $noSur->no_surat;
            $row[] = $noSur->perihal;
            $row[] = $noSur->pic;
            $row[] = date("d F Y", strtotime($noSur->tanggal));
            $row[] = $noSur->note;
            $row[] = $noSur->jns_surat;

            $data[]= $row;
        } 
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_nomor->count_all(),
            "recordsFiltered" => $this->M_nomor->count_filtered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }

	public function getSub()
	{
		$jenis = $this->input->post('jenis', true);
		$data = $this->M_nomor->getSubjenis($jenis);
		echo json_encode($data);
	}

	public function lihatNomor()
	{
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
		$jenis = $this->input->post('jenis');
		$hasil = $this->M_nomor->getNoUrut($jenis);
		
		$entity = $this->input->post('entity', true);
		$sub = $this->input->post('sub', true);
		$nourut = substr($hasil,0,3);

		$array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
		$bulan = $array_bulan[date('n')];

		$tahun = date('Y');
		
		$data = [
				'entity' => $entity,
				'sub' => $sub,
				'bulan' => $bulan,
				'tahun' => $tahun,
				'no' => $nourut
		];
		echo json_encode($data);
	}

	public function simpan()
	{
		$data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
		$data = [
			'no_surat' => $this->input->post('no'),
			'perihal' => $this->input->post('perihal'),
			'pic' => $this->input->post('pic'),
			'jenis_surat' => $this->input->post('jenis'),
			'note' => $this->input->post('note'),
			'tahun' => date('Y')
		];

		$this->db->insert('surat_keluar', $data);
		redirect('surat/buatnomor','refresh');
	}


	public function suratByjns()
	{
		$id = intval($this->input->get('q'));
		if ($id == 'all') {
			$query = $this->M_nomor->getAll();
			foreach ($query as $all){
				echo "<tr>";
				echo "<td>" . $all['no_surat'] . "</td>";
				echo "<td>" . $all['perihal'] . "</td>";
				echo "<td>" . $all['pic'] . "</td>";
				echo "<td>" . date("d F Y", strtotime($all['tanggal'])) . "</td>";
				echo "<td>" . $all['note'] . "</td>";
				echo "<td>" . $all['jenis_surat'] . "</td>";
				echo "</tr>";
			}
			
		} else {
			$sql = $this->M_nomor->getJenisbyId($id);
		foreach ($sql as $row)
		{
			echo "<tr>";
			echo "<td>" . $row['no_surat'] . "</td>";
			echo "<td>" . $row['perihal'] . "</td>";
			echo "<td>" . $row['pic'] . "</td>";
			echo "<td>" . date('d F y', strtotime($row['tanggal'])) . "</td>";
			echo "<td>" . $row['note'] . "</td>";
			echo "<td>" . $row['jenis_surat'] . "</td>";
			echo "</tr>";
		}
	}
		
	}
}

/* End of file Nomor.php */
