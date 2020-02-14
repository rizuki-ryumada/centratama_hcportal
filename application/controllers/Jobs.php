<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jobpro_model');
        $this->load->model('Divisi_model');
        $this->load->model('Dept_model');
        is_logged_in();
    }

    public function report()
    {
        $data['title'] = 'Report';
        $data['divisi'] = $this->Divisi_model->getDivisi();
        $data['dept'] = $this->Dept_model->getAll();
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $this->load->view('templates/report_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('reportjobs/index', $data);
        $this->load->view('templates/report_footer');
    }

    public function index()
    {
        $nik = $this->session->userdata('nik');
        $data['my'] = $this->Jobpro_model->getMyProfile($nik);
        $data['mydiv'] = $this->Jobpro_model->getMyDivisi($nik);
        $data['mydept'] = $this->Jobpro_model->getMyDept($nik);
        $data['posisi'] = $this->Jobpro_model->getPosisi($nik);
		$data['staff'] = $this->Jobpro_model->getStaff($data['posisi']['position_id']);
        $data['tujuanjabatan'] = $this->Jobpro_model->getProfileJabatan($data['posisi']['position_id']);
        $data['pos'] = $this->Jobpro_model->getAllPosition();
        $data['title'] = 'Job Profile';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
		$statusApproval = $this->db->get_where('job_approval', ['nik' => $nik, 'id_posisi' => $data['posisi']['position_id']])->row_array();
		if ($statusApproval) {
			$data['approval'] = $statusApproval;
			$this->load->view('templates/user_header', $data);
			$this->load->view('templates/user_sidebar', $data);
			$this->load->view('templates/user_topbar', $data);
			$this->load->view('jobs/save_jobs', $data);
			$this->load->view('templates/user_footer');
		} else {
			$this->load->view('templates/user_header', $data);
			$this->load->view('templates/user_sidebar', $data);
			$this->load->view('templates/user_topbar', $data);
			$this->load->view('jobs/index', $data);
			$this->load->view('templates/jobs_footer');
		}
    }

    public function insatasan()
    {
        $data= [
            'id_atasan1' => $this->input->post('position')
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('position', $data);

        $datajabatan = [
            'id_posisi' => $this->session->userdata('position_id')
        ];
        $this->db->insert('profile_jabatan', $datajabatan);
        
        redirect('jobs','refresh');
    }
    
    //tujuan jabatan
    public function edittujuanjbtn($id)
    {
        $data['title'] = 'Ubah Tujuan Jabatan';
        $data['tujab'] = $this->Jobpro_model->getTujabById($id);
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();

        $this->form_validation->set_rules('tujuan_jabatan', 'Form', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('jobs/edittujab', $data);
            $this->load->view('templates/jobs_footer');
        } else {
            $this->Jobpro_model->updateTuJab();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your Profile Has Been Updated ! </div>');
            redirect('user/jobprofile');
        }
    }

    public function uptuj()
    {
        $id = $this->input->post('id_posisi');
        $tujuan = $this->input->post('tujuan_jabatan');
        $this->Jobpro_model->UpTuj($id,$tujuan);
        redirect('jobs','refresh');
    }

    public function edittujuan()
    {
        $data = [
            'tujuan_jabatan' => $this->input->post('tujuan')
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('profile_jabatan', $data);
    }

    public function addTanggungJawab()
    {
        $nik = $this->session->userdata('nik');
        $this->db->select('position_id');
        $this->db->from('employe');
        $this->db->where('nik', $nik);
        $pos = $this->db->get()->row_array();
        
        $data = [
            'keterangan' => $this->input->post('tanggung_jawab'),
            'list_aktivitas' => $this->input->post('aktivitas'),
            'list_pengukuran' => $this->input->post('pengukuran'),
            'id_posisi' => $pos['position_id']
        ];

        $this->db->insert('tanggung_jawab', $data);
        $this->session->set_flashdata('flash', 'Added');
        redirect('jobs');
    }

    public function editTanggungJawab()
    {
        $data = [
            'keterangan' => $this->input->post('tanggung_jawab'),
            'list_aktivitas' => $this->input->post('aktivitas'),
            'list_pengukuran' => $this->input->post('pengukuran')
        ];

        $this->db->where('id_tgjwb', $this->input->post('idtgjwb'));
        $this->db->update('tanggung_jawab', $data);
        $this->session->set_flashdata('flash', 'Update');
        redirect('jobs');
    }
    
    public function getTjByID()
    {
        echo json_encode($this->Jobpro_model->getTjById($_POST['id']));
    }

    public function hapusTanggungJawab($id)
    {
        $this->db->where('id_tgjwb', $id);
        $this->db->delete('tanggung_jawab');
        $this->session->set_flashdata('flash', 'Deleted');
        redirect('jobs', 'refresh');
    }

    // -----ruang lingkup
    public function addruanglingkup()
    {
        $id = $this->input->post('id');
        $ruling = $this->input->post('ruangl');
        if (!$ruling) {
            $array = [
                'r_lingkup' => '<b>-</b>',
                'id_posisi' => $id
            ];
            $this->db->insert('ruang_lingkup', $array);
            $this->session->set_flashdata('flash', 'Inserted');
            redirect('jobs/#hal6');
        }else {
            $array = [
                'r_lingkup' => $this->input->post('ruangl'),
                'id_posisi' => $id
            ];
            $this->db->insert('ruang_lingkup', $array);
            $this->session->set_flashdata('flash', 'Inserted');
            redirect('jobs/#hal6');
        }
    }
    public function editruanglingkup()
    {
        $ruang = $this->input->post('ruang');
        if ($ruang) {
            $this->db->set('r_lingkup', $ruang);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('ruang_lingkup');
            echo 'Success';
        }else{
            $ruang = '<b>-</b>';
            $this->db->set('r_lingkup', $ruang);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('ruang_lingkup');
            echo $ruang;
        }
    }

    //wewenang
    public function addwen()
    {
        $pos = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data = [
            'kewenangan' => $this->input->post('wewenang'),
            'wen_sendiri' => $this->input->post('wen_sendiri'),
            'wen_atasan1' => $this->input->post('wen_atasan1'),
            'wen_atasan2' => $this->input->post('wen_atasan2'),
            'id_posisi' => $pos['position_id']
        ];
        $this->db->insert('wewenang', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data Berhasil Ditambah! </div>');
        redirect('jobs', 'refresh');
    }

    public function aksiwewenang()
    {
        $aksi = $this->input->post('action');
        $data = array(
            'id' => $this->input->post('id'),
            'kewenangan' => $this->input->post('kewenangan'),
            'wen_sendiri' => $this->input->post('wen_sendiri'),
            'wen_atasan1' => $this->input->post('wen_atasan1'),
            'wen_atasan2' => $this->input->post('wen_atasan2')
        );
        if ($aksi == 'edit') {
            $tableV='';
            if (isset($data['kewenangan'])) {
                $tableV .= "`kewenangan` = '".$data['kewenangan']."'";
            } elseif (isset($data['wen_sendiri'])) {
                $tableV .= "`wen_sendiri` = '".$data['wen_sendiri']."'";
            } elseif (isset($data['wen_atasan1'])) {
                $tableV .= "`wen_atasan1` = '".$data['wen_atasan1']."'";
            } elseif (isset($data['wen_atasan2'])) {
                $tableV .= "`wen_atasan2` = '".$data['wen_atasan2']."'";
            }
            if($tableV && $data['id']){
                $this->db->query("UPDATE `wewenang` SET $tableV WHERE id='".$data['id']."' ");
            }
        }
        if ($aksi == 'delete') {
            $this->db->where('id', $data['id']);
            $this->db->delete('wewenang');
        }
        echo json_encode($aksi);
    }

    // aksihubungan
    public function addHubungan()
    {
        $id = $this->input->post('id');
        $internal = $this->input->post('internal');
        $eksternal = $this->input->post('eksternal');

        
        if (!$internal && !$eksternal) {
            $array = [
                'hubungan_int' => '<b>-</b>',
                'hubungan_eks' => '<b>-</b>',
                'id_posisi' => $id
            ];
            $this->db->insert('hub_kerja', $array);
            $this->session->set_flashdata('flash', 'Update');
            redirect('jobs/#hal5');
        }elseif ($internal && !$eksternal) {
            $array = [
                'hubungan_int' => $internal,
                'hubungan_eks' => '<b>-</b>',
                'id_posisi' => $id
            ];
            $this->db->insert('hub_kerja', $array);
            $this->session->set_flashdata('flash', 'Update');
            redirect('jobs/#hal5');
        }elseif (!$internal && $eksternal) {
            $array = [
                'hubungan_int' => '<b>-</b>',
                'hubungan_eks' => $eksternal,
                'id_posisi' => $id
            ];
            $this->db->insert('hub_kerja', $array);
            $this->session->set_flashdata('flash', 'Update');
            redirect('jobs/#hal5');
        }
    }

    public function edithub()
    {
        $data = [
            'id' => $this->input->post('id'),
            'hubInt' => $this->input->post('hubInt'),
            'hubEks' => $this->input->post('hubEks'),
            'tipe' => $this->input->post('tipe')
        ];

        if ($data['tipe'] == 'internal') {
            $this->db->set('hubungan_int', $data['hubInt']);
            $this->db->where('id', $data['id']);
            $this->db->update('hub_kerja');
            echo 'success';
        }
        if ($data['tipe'] == 'eksternal') {
            $this->db->set('hubungan_eks', $data['hubEks']);
            $this->db->where('id', $data['id']);
            $this->db->update('hub_kerja');
            echo 'success';
        }
    }

    //aksitantangan
    public function addtantangan()
    {
        $data = [
            'text' => $this->input->post('tantangan'),
            'id_posisi' => $this->input->post('id')
        ];
        $this->db->insert('tantangan', $data);
        redirect('jobs','refresh');
    }

    public function edittantangan()
    {
        $data = [
            'text' => $this->input->post('tantangan')
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('tantangan', $data);
    }

    // kualifikasi aksi
    public function addkualifikasi()
    {
        $data = [
            'id_posisi' => $this->input->post('id'),
            'pendidikan' => $this->input->post('pend'),
            'pengalaman' => $this->input->post('pengalmn'),
            'pengetahuan' => $this->input->post('pengtahu'),
            'kompetensi' => $this->input->post('kptnsi')
        ];
        $this->db->insert('kualifikasi', $data);
        redirect('jobs','refresh');
    }

    public function getKualifikasiById()
    {
        echo json_encode($this->Jobpro_model->getKualifikasiById($_POST['id']));
    }

    public function updateKualifikasi()
    {
        $id = $this->input->post('id_posisi');
        $data = [
            'pendidikan' => $this->input->post('pendidikan'),
            'pengalaman' => $this->input->post('pengalaman'),
            'pengetahuan' => $this->input->post('pengetahuan'),
            'kompetensi' => $this->input->post('kompetensi')
        ];


        $this->db->where('id_posisi', $id);
        $this->db->update('kualifikasi', $data);
        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data Berhasil Diubah! </div>');
        // redirect('jobs');
    }

    //jenjang karir aksi
    public function addjenjangkarir()
    {
        $data = [
            'id_posisi' => $this->input->post('id'),
            'text' => $this->input->post('jenkar')
        ];
        $this->db->insert('jenjang_kar', $data);
        redirect('jobs','refresh');
    }
    public function editjenjang()
    {
        $data = [
            'text' => $this->input->post('jenkar')
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('jenjang_kar', $data);
    }
	public function updateStaff()
	{
		$data = [
			'manager' => $this->input->post('mgr'),
			'supervisor' => $this->input->post('spvr'),
			'staff' => $this->input->post('staf')
		];
		$this->db->where('id_posisi', $this->input->post('id_posisi'));
		$this->db->update('jumlah_staff', $data);
		echo 'staff updated';
	}
	public function setApprove()
	{
		$data = [
			'nik' => $this->input->post('nik'),
			'id_posisi' => $this->input->post('id_posisi'),
			'atasan1' => $this->input->post('atasan1'),
			'atasan2' => $this->input->post('atasan2'),
			'tanggal_pengajuan' => time(),
			'status_approval' => 'Dikirim',
			'is_active' => 1
		];
		$this->db->insert('job_approval', $data);
		print_r($data);
	}
}

/* End of file Jobs.php */
