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
        date_default_timezone_set('Asia/Jakarta');
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

    public function index(){
        $nik = $this->session->userdata('nik');
        $data['posisi'] = $this->Jobpro_model->getPosisi($nik);

        // if(empty($this->Jobpro_model->getProfileJabatan($data['posisi']['position_id']))){
        //     $profile_jabatan = array(
        //         'id_posisi'      => $data['posisi']['position_id'],
        //         'tujuan_jabatan' => "<i>tujuan jabatan anda belum diisi</i>"
        //     );

        //     $this->db->insert('profile_jabatan', $profile_jabatan);
        // }

        // if(empty($this->Jobpro_model->getDetail('*', 'ruang_lingkup', array('id_posisi' => $data['posisi']['position_id'])))){
        //     $this->db->insert('ruang_lingkup', array(
        //         'id_posisi' => $data['posisi']['position_id'],
        //         'r_lingkup' => "<i>Ruang Lingkup Jabatan belum diisi</i>"
        //     ));
        // }

        $job_approval = $this->db->query("SELECT * FROM job_approval WHERE nik = '$nik'");//cek apa sudah ada job_approvalnya
        if(empty($job_approval->result())){
            $data = [
                'nik' => $this->session->userdata('nik'),
                'id_posisi' => $data['posisi']['position_id'],
                'approver1' => $data['posisi']['id_approver1'],
                'approver2' => $data['posisi']['id_approver2'],
                'diperbarui' => time(),
                'status_approval' => 0,
                'is_edit' => 1,
                'pesan_revisi' => "null"
            ];
            $this->db->insert('job_approval', $data);
        }else{
            //do nothing
        }

        if(empty($this->Jobpro_model->getDetail('*', 'jumlah_staff', array('id_posisi' => $data['posisi']['position_id'])))){ //cek apa jumlah staff sudah ada
            $this->Jobpro_model->insert('jumlah_staff', array(
                'id_posisi' => $data['posisi']['position_id'],
                'manager' => 0,
                'supervisor' => 0,
                'staff' => 0
            ));
        }

        //get back this variable, it is gone after I using the if.. else.. above
        $nik = $this->session->userdata('nik');
        $data['posisi'] = $this->Jobpro_model->getPosisi($nik);
        $data['title'] = 'My Task';
        $data['my'] = $this->Jobpro_model->getMyProfile($nik);
        $data['mydiv'] = $this->Jobpro_model->getMyDivisi($nik);
        $data['mydept'] = $this->Jobpro_model->getMyDept($nik);
        $data['staff'] = $this->Jobpro_model->getStaff($data['posisi']['position_id']);
        $data['tujuanjabatan'] = $this->Jobpro_model->getProfileJabatan($data['posisi']['position_id']);
        $data['pos'] = $this->Jobpro_model->getAllPosition();
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        //ambil informasi approver 1 dan 2
        $data['approver'][0] =  $this->Jobpro_model->getPositionDetail($data['posisi']['id_approver1']);
        $data['approver'][1] =  $this->Jobpro_model->getPositionDetail($data['posisi']['id_approver2']);

        $data['approval'] = $this->db->get_where('job_approval', ['nik' => $nik, 'id_posisi' => $data['posisi']['position_id']])->row_array(); //get status approval

        //ambil data my task dengan id_position dan status
        //$this->Jobpro_model->getMyTask(id_posisi, 'kolom_approver_di_database, status approval);
        $my_task = $this->Jobpro_model->getMyTask($data['posisi']['position_id'], 'approver1', '1');
        $my_task = array_merge($my_task, $this->Jobpro_model->getMyTask($data['posisi']['position_id'], 'approver2', '2'));
        
        $data['my_task'] = $this->getApprovalDetails($my_task); //get Approval Details
        
        $this->load->view('templates/user_header', $data);
		$this->load->view('templates/user_sidebar', $data);
		$this->load->view('templates/user_topbar', $data);
		$this->load->view('jobs/indexjp', $data);
        $this->load->view('templates/indexjp_footer');
    }

    public function myJp(){
        $nik = $this->session->userdata('nik');
        $data['my'] = $this->Jobpro_model->getMyProfile($nik);
        $data['mydiv'] = $this->Jobpro_model->getMyDivisi($nik);
        $data['mydept'] = $this->Jobpro_model->getMyDept($nik);
        $data['posisi'] = $this->Jobpro_model->getPosisi($nik);
        $data['staff'] = $this->Jobpro_model->getStaff($data['posisi']['position_id']);
        $data['pos'] = $this->Jobpro_model->getAllPosition();
        $data['title'] = 'My Task';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        
        $statusApproval = $this->db->get_where('job_approval', ['nik' => $nik, 'id_posisi' => $data['posisi']['position_id']])->row_array(); //get status approval
        
        //cek jika atasan 1 bukan CEO dan 0
        if($data['my']['posnameatasan1'] != 1 && $data['my']['posnameatasan1'] != 0){
            // Olah data orgchart
            $org_data = $this->olahDataChart($data['my']['position_id']);
        } elseif($data['my']['posnameatasan1'] != 0 && $data['posisi']['div_id'] == 1){
            $org_data = $this->olahDataChart($data['my']['position_id']);
        } else {
            //siapkan data null
            $org_data[0] = json_encode(null);
            $org_data[1] = json_encode(null);
            $org_data[2] = json_encode(null);
            $org_data[3] = 0;
            $org_data[4] = 0;
        }

        $data['orgchart_data'] = $org_data[0]; //masukkan data orgchart yang sudah diolah ke JSON
        $data['orgchart_data_assistant1'] = $org_data[1];
        $data['orgchart_data_assistant2'] = $org_data[2];
        $data['assistant_atasan1'] = $org_data[3];
        $data['atasan'] = $org_data[4];
        
        $approval = $this->db->get_where('job_approval', ['nik' => $nik, 'id_posisi' => $data['posisi']['position_id']])->row_array(); //get status approval
        
        if ($approval['is_edit'] == 0) {
            $data['approval'] = $approval;
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('jobs/myjp_view', $data);
            $this->load->view('templates/jobs_footer_view');
        } else {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('jobs/myjp', $data);
            $this->load->view('templates/jobs_footer_editor');
        }
    }

    public function taskJp(){
        // prepare the data
        $nik = $this->input->get('task');
        $data['status'] = $this->input->get('status');
        $data['my'] = $this->Jobpro_model->getMyProfile($nik);
        $data['mydiv'] = $this->Jobpro_model->getMyDivisi($nik);
        $data['mydept'] = $this->Jobpro_model->getMyDept($nik);
        $data['posisi'] = $this->Jobpro_model->getPosisi($nik);
		$data['staff'] = $this->Jobpro_model->getStaff($data['posisi']['position_id']);
        $data['tujuanjabatan'] = $this->Jobpro_model->getProfileJabatan($data['posisi']['position_id']);
        $data['pos'] = $this->Jobpro_model->getAllPosition();
        $data['title'] = 'My Task';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['emp_name'] = $this->Jobpro_model->getDetail("emp_name", "employe", array('nik' => $nik));
        $statusApproval = $this->db->get_where('job_approval', ['nik' => $nik, 'id_posisi' => $data['posisi']['position_id']])->row_array(); //get status approval
        
        //cek jika atasan 1 bukan CEO dan 0
        if($data['my']['posnameatasan1'] != 1 && $data['my']['posnameatasan1'] != 0){
            // Olah data orgchart
            $org_data = $this->olahDataChart($data['my']['position_id']);
        } elseif($data['my']['posnameatasan1'] != 0 && $data['posisi']['div_id'] == 1){
            $org_data = $this->olahDataChart($data['my']['position_id']);
        } else {
            //siapkan data null
            $org_data[0] = json_encode(null);
            $org_data[1] = json_encode(null);
            $org_data[2] = json_encode(null);
            $org_data[3] = 0;
            $org_data[4] = 0;
        }

        $data['orgchart_data'] = $org_data[0]; //masukkan data orgchart yang sudah diolah ke JSON
        $data['orgchart_data_assistant1'] = $org_data[1];
        $data['orgchart_data_assistant2'] = $org_data[2];
        $data['assistant_atasan1'] = $org_data[3];
        $data['atasan'] = $org_data[4];

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('jobs/taskjp', $data);
        $this->load->view('templates/jobs_footer_editor');
    }

    public function reportJp(){
        $my_nik = $this->session->userdata('nik'); //get my nik
        $nik = $this->input->get('task');// get another nik

        $my_position_id = $this->Jobpro_model->getDetail('position_id', 'employe', array('nik' => $my_nik))['position_id']; //ambil position_id
        $role_id = $this->Jobpro_model->getDetail('role_id', 'employe', array('nik' => $my_nik))['role_id']; //ambil role_id
        
        // if($role_id != 1){ // cek role_id apakah punya hak akses
        //     redirect('auth/blocked','refresh'); //jika tidak punya hak akses tampilkan pesan error
        //     exit;
        // }
        //ambil position id
        $position_id = $this->Jobpro_model->getDetail('position_id', 'employe', array('nik' => $nik))['position_id']; //ambil position id
        // error_reporting(0); //sembunyiin pesan error
        
        if($role_id != 1){
            if(empty($this->db->query("SELECT * FROM job_approval WHERE (nik='".$nik."' AND approver1='".$my_position_id."') OR (nik='".$nik."' AND approver2='".$my_position_id."')")->result())){ //cek kalo dia punya akses terhadap karyawan tersebut
                redirect('auth/blocked','refresh'); //jika tidak punya hak akses tampilkan pesan error
                exit;
            } else {
                //nothing
            };      
        } else {
            //nothing
        }
            
        // prepare the data
        $data['status'] = $this->input->get('status');
        $data['my'] = $this->Jobpro_model->getMyProfile($nik);
        $data['mydiv'] = $this->Jobpro_model->getMyDivisi($nik);
        $data['mydept'] = $this->Jobpro_model->getMyDept($nik);
        $data['posisi'] = $this->Jobpro_model->getPosisi($nik);
		$data['staff'] = $this->Jobpro_model->getStaff($data['posisi']['position_id']);
        $data['tujuanjabatan'] = $this->Jobpro_model->getProfileJabatan($data['posisi']['position_id']);
        $data['pos'] = $this->Jobpro_model->getAllPosition();
        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['emp_name'] = $this->Jobpro_model->getDetail("emp_name", "employe", array('nik' => $nik));
        $data['statusApproval'] = $this->db->get_where('job_approval', ['nik' => $nik, 'id_posisi' => $data['posisi']['position_id']])->row_array(); //get status approval
                //cek jika atasan 1 bukan CEO dan 0
        if($data['my']['posnameatasan1'] != 1 && $data['my']['posnameatasan1'] != 0){
            // Olah data orgchart
            $org_data = $this->olahDataChart($data['my']['position_id']);
        } elseif($data['my']['posnameatasan1'] != 0 && $data['posisi']['div_id'] == 1){
            $org_data = $this->olahDataChart($data['my']['position_id']);
        } else {
            //siapkan data null
            $org_data[0] = json_encode(null);
            $org_data[1] = json_encode(null);
            $org_data[2] = json_encode(null);
            $org_data[3] = 0;
            $org_data[4] = 0;
        }

        $data['orgchart_data'] = $org_data[0]; //masukkan data orgchart yang sudah diolah ke JSON
        $data['orgchart_data_assistant1'] = $org_data[1];
        $data['orgchart_data_assistant2'] = $org_data[2];
        $data['assistant_atasan1'] = $org_data[3];
        $data['atasan'] = $org_data[4];

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('jobs/reportjp_v', $data);
        $this->load->view('templates/jobs_footer_editor');
    }

    public function taskAction(){
        $pesan_revisi = $this->input->post('pesan_revisi');
        $nik = $this->input->post('nik');
        $status_sebelum = $this->input->post('status_sebelum');
        $status_approval = $this->input->post('status_approval');

        // output
        /*
            null
            CG000619
            1
            true
        */
        $approver2 = $this->Jobpro_model->getDetail('approver2', 'job_approval', array('nik' => $nik));
        
        //cek apa punya approver2
        if(!empty($approver2['approver2'])){
            //cek status_approval
            if($status_approval == "true"){ //jika disetujui
                if($status_sebelum == 1){ //atasan 1
                    $data = [
                        'diperbarui' => time(),
                        'status_approval' => '2',
                        'is_edit' => 0,
                        'pesan_revisi' => $pesan_revisi
                    ];
                    $this->Jobpro_model->updateApproval($data,$nik);

                } elseif($status_sebelum == 2){ //atasan 2, selesaikan task
                    $data = [
                        'diperbarui' => time(),
                        'status_approval' => '4',
                        'is_edit' => 0,
                        'pesan_revisi' => $pesan_revisi
                    ];
                    $this->Jobpro_model->updateApproval($data,$nik);

                } else {
                    show_404(); //error
                }
            } elseif($status_approval == "false") {
                $data = [
                    'diperbarui' => time(),
                    'status_approval' => '3',
                    'is_edit' => 1,
                    'pesan_revisi' => $pesan_revisi
                ];
                $this->Jobpro_model->updateApproval($data,$nik);
            } else {
                show_404(); //error
            }
        }else{
            //cek status_approval
            if($status_approval == "true"){ //jika disetujui
                $data = [
                    'diperbarui' => time(),
                    'status_approval' => '4',
                    'is_edit' => 0,
                    'pesan_revisi' => $pesan_revisi
                ];
                $this->Jobpro_model->updateApproval($data,$nik);
            } elseif($status_approval == "false") {
                $data = [
                    'diperbarui' => time(),
                    'status_approval' => '3',
                    'is_edit' => 1,
                    'pesan_revisi' => $pesan_revisi
                ];
                $this->Jobpro_model->updateApproval($data,$nik);
            } else {
                show_404(); //error
            }
        }

        header('location: ' . base_url('jobs'));
        exit;
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
            $this->load->view('templates/jobs_footer_editor');
        } else {
            $this->Jobpro_model->updateTuJab();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your Profile Has Been Updated ! </div>');
            redirect('user/jobprofile');
        }
    }

    public function uptuj()
    {
        $id = $this->input->post('id');
        $tujuan = $this->input->post('tujuan');

        $this->Jobpro_model->insert('profile_jabatan', array('id_posisi' => $id, 'tujuan_jabatan' => $tujuan));
        // redirect('jobs','refresh');
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
        $data = [
            'keterangan' => $this->input->post('tanggung_jawab'),
            'list_aktivitas' => $this->input->post('aktivitas'),
            'list_pengukuran' => $this->input->post('pengukuran'),
            'id_posisi' => $this->input->post('id_posisi')
        ];
        $this->Jobpro_model->insert('tanggung_jawab', $data);
        // $this->session->set_flashdata('flash', 'Added');
        // redirect('jobs');
    }

    public function editTanggungJawab()
    {
        $data = [
            'keterangan' => $this->input->post('tanggung_jawab'),
            'list_aktivitas' => $this->input->post('aktivitas'),
            'list_pengukuran' => $this->input->post('pengukuran')
        ];
        $where = array(
            'db' => 'id_tgjwb',
            'server' => $this->input->post('idtgjwb')
        );
        $this->Jobpro_model->update('tanggung_jawab', $where, $data);
        // $this->session->set_flashdata('flash', 'Update');
        // redirect('jobs');
    }
    
    public function getTjByID()
    {
        echo json_encode($this->Jobpro_model->getTjById($_POST['id']));
    }

    public function hapusTanggungJawab($id)
    {
        // $this->db->where('id_tgjwb', $id);
        // $this->db->delete('tanggung_jawab');
        $this->Jobpro_model->delete('tanggung_jawab', array('index' => 'id_tgjwb', 'data' => $id));
        // $this->session->set_flashdata('flash', 'Deleted');
        // redirect('jobs', 'refresh');
    }

    // -----ruang lingkup
    public function addruanglingkup()
    {
        $id = $this->input->post('id');
        $ruang1 = $this->input->post('ruangl');

        $this->Jobpro_model->insert('ruang_lingkup', array('id_posisi' => $id, 'r_lingkup' => $ruang1));
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
        $data = [
            'kewenangan' => $this->input->post('wewenang'),
            'wen_sendiri' => $this->input->post('wen_sendiri'),
            'wen_atasan1' => $this->input->post('wen_atasan1'),
            'wen_atasan2' => $this->input->post('wen_atasan2'),
            'id_posisi' => $this->input->post('id')
        ];
        $this->Jobpro_model->insert('wewenang', $data);
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
            $this->Jobpro_model->insert('hub_kerja', $array);
        } elseif ($internal && $eksternal){
            $array = [
                'hubungan_int' => $internal,
                'hubungan_eks' => $eksternal,
                'id_posisi' => $id
            ];
            $this->Jobpro_model->insert('hub_kerja', $array);
        } elseif($internal && !$eksternal) {
            $array = [
                'hubungan_int' => $internal,
                'hubungan_eks' => '<b>-</b>',
                'id_posisi' => $id
            ];
            $this->Jobpro_model->insert('hub_kerja', $array);
        }elseif (!$internal && $eksternal) {
            $array = [
                'hubungan_int' => '<b>-</b>',
                'hubungan_eks' => $eksternal,
                'id_posisi' => $id
            ];
            $this->Jobpro_model->insert('hub_kerja', $array);
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
        $this->Jobpro_model->insert('tantangan', $data);
        // redirect('jobs','refresh');
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
            'id_posisi' => $this->input->post('id_posisi'),
            'pendidikan' => $this->input->post('pendidikan'),
            'pengalaman' => $this->input->post('pengalaman'),
            'pengetahuan' => $this->input->post('pengetahuan'),
            'kompetensi' => $this->input->post('kompetensi')
        ];  
        $this->Jobpro_model->insert('kualifikasi', $data);
        // redirect('jobs','refresh');
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
        $this->Jobpro_model->insert('jenjang_kar', $data);
    }
    public function editjenjang()
    {
        $data = [
            'text' => $this->input->post('jenkar')
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('jenjang_kar', $data);
    }
	public function updateStaff(){
        
		$data = [
			'manager' => $this->input->post('mgr'),
			'supervisor' => $this->input->post('spvr'),
			'staff' => $this->input->post('staf')
		];
		$this->db->where('id_posisi', $this->input->post('id_posisi'));
		$this->db->update('jumlah_staff', $data);
		echo 'staff updated';
	}
	public function setApprove() //Submit to atasan
	{
        $data = [
			'diperbarui' => time(),
            'status_approval' => '1',
            'is_edit' => 0
        ];

        $this->Jobpro_model->updateApproval($data,$this->input->post('nik'));
    }
    
    public function getApprovalDetails($my_task){
        //lengkapi division, departement, nama position, nama employee nya
        foreach($my_task as $key => $value){
            $temp_employe = $this->Jobpro_model->getEmployeDetail("emp_name, position.div_id, position.dept_id, position_id", "employe", array('nik' => $value['nik']));
            $my_task[$key]['name'] = $temp_employe['emp_name'];
            foreach ($this->Jobpro_model->getDetail("position_name", "position", array('id' => $temp_employe['position_id'])) as $v){
                $my_task[$key]['posisi'] = $v;
            }
            foreach($this->Jobpro_model->getDetail("nama_departemen", "departemen", array('id' => $temp_employe['dept_id'])) as $v){
                $my_task[$key]['departement'] = $v;
            }
            foreach($this->Jobpro_model->getDetail("division", "divisi", array('id' => $temp_employe['div_id'])) as $v){
                $my_task[$key]['divisi'] = $v;
            }
        }

        return $my_task;
    }

    //this function to generate job_approval starter data
    // public function startTheJobApprovalSystem(){
    //     foreach($this->Jobpro_model->getDetails('nik', 'employe', array()) as $k => $v){ //ambil semua nik
    //         $nik=$v['nik'];// pindahkan ke variabel
    //         // print_r($nik);

    //         $data['posisi'] = $this->Jobpro_model->getPosisi($nik); //cari data posisi

    //         $job_approval = $this->db->query("SELECT * FROM job_approval WHERE nik = '$nik'");//cek apa sudah ada job_approvalnya
    //         if(empty($job_approval->result())){
    //             $data['title'] = 'Job Profile';
    //             $data = [
    //                 'nik' => $nik,
    //                 'id_posisi' => $data['posisi']['position_id'],
    //                 'approver1' => $data['posisi']['id_approver1'],
    //                 'approver2' => $data['posisi']['id_approver2'],
    //                 'diperbarui' => time(),
    //                 'status_approval' => 0,
    //                 'is_edit' => 1,
    //                 'pesan_revisi' => "null"
    //             ];
    //             $this->db->insert('job_approval', $data);
    //         }else{
    //             //do nothing
    //         }
    //     }        
    // }

    //function buat mengolah data chart olahDataChart(id_position)
    public function olahDataChart($my_positionId) {
        // MENGOLAH DATA Master Position menjadi orgchart data ===========================================================
        //sebelumnya ingat ada beberapa hal yang harus diperhatikan
        // 1. posisi Asistant dan bukan assistant berbeda perlakuannya juga berbeda
        // 2. kode ini digunakan untuk mengolah data dari database menjadi JSON

        $my_pos_detail = $this->Jobpro_model->getPositionDetail($my_positionId); //ambil informasi detail posisi saya //200 //bukan assistant
        if(empty($my_pos_detail)){
            $my_pos_detail = $this->Jobpro_model->getPositionDetailAssistant($my_positionId);
        }
        // print_r($my_pos_detail);
        //output $my_pos_detail
        // Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 [assistant] => 0 ) 


        $x = 0; $y = 0; $atasan = 0; //untuk penanda looping
        if(!empty($my_pos_detail)){//if data exist
            $my_atasan[$x]['id_atasan1'] = $my_pos_detail['id_atasan1'];
            $id_atasan1 = $my_pos_detail['id_atasan1'];
            $id_atasan2 = $my_pos_detail['id_atasan2'];
            
            if($my_pos_detail['id_atasan2'] != 1 && $my_pos_detail['id_atasan2'] != 0 && $my_pos_detail['div_id'] != 1){//apakah atasan 2 nya bukan CEO atau dan dia punya atasan 2
                //cari posisi yang bukan assistant
                $whois_sama[0] = $this->Jobpro_model->getWhoisSama($id_atasan1); //200 dan 201 ambil data yang sama sama saya yang bukan assistant
                $whois_sama[1] = $this->Jobpro_model->getWhoisSama($id_atasan2); //200 dan 201 ambil data yang sama sama saya yang bukan assistant
                $my_atasan[0] = $this->Jobpro_model->getPositionDetail($id_atasan1); //ambil informasi daftar atasan saya yang bukan assistant
                $my_atasan[1] = $this->Jobpro_model->getPositionDetail($id_atasan2); //ambil informasi daftar atasan saya yang bukan assistant
                //cari posisi yang assistant
                if(!empty($whois_sama_assistant1[$y] = $this->Jobpro_model->getWhoisSamaAssistant($id_atasan1))){ //cari assistant atasan 1
                    $y++;
                    $assistant_atasan1 = 1; //tandai buat nanti nampilin orgchartnya horizontal di level ke 3
                } else {
                    $assistant_atasan1 = 0; //tandai buat nanti nampilin orgchartnya horizontal di level ke 3
                }
                if(!empty($whois_sama_assistant2[$y] = $this->Jobpro_model->getWhoisSamaAssistant($id_atasan2))){ //cari assistant atasan 2
                    $y++;
                } else {
                    //nothing
                }

                $atasan = 2; //penanda atasan
    
                //200 dan 201 ambil data yang sama sama saya yang assistant)
                // $my_atasan_assistant[$x] = $this->Jobpro_model->getPositionDetailAssistant($id_atasan1); //ambil informasi daftar atasan saya yang assistant ##NOT USED on ASSISTANT
                // $id_atasan1 = $my_atasan[$x]['id_atasan1'];
                // $x++;
            } elseif ($my_pos_detail['id_atasan2'] != 0 && $my_pos_detail['div_id'] == 1){

                //cari posisi yang bukan assistant
                // print('aku');
                
                $whois_sama[0] = $this->Jobpro_model->getWhoisSamaCEOffice($id_atasan1, '1'); //200 dan 201 ambil data yang sama sama saya yang bukan assistant
                $whois_sama[1] = $this->Jobpro_model->getWhoisSamaCEOffice($id_atasan2, '1'); //200 dan 201 ambil data yang sama sama saya yang bukan assistant
                $my_atasan[0] = $this->Jobpro_model->getPositionDetail($id_atasan1); //ambil informasi daftar atasan saya yang bukan assistant
                $my_atasan[1] = $this->Jobpro_model->getPositionDetail($id_atasan2); //ambil informasi daftar atasan saya yang bukan assistant
                //cari posisi yang assistant
                if(!empty($whois_sama_assistant1[$y] = $this->Jobpro_model->getWhoisSamaAssistant($id_atasan1))){ //cari assistant atasan 1
                    $y++;
                    $assistant_atasan1 = 1; //tandai buat nanti nampilin orgchartnya horizontal di level ke 3
                } else {
                    $assistant_atasan1 = 0; //tandai buat nanti nampilin orgchartnya horizontal di level ke 3
                }
                if(!empty($whois_sama_assistant2[$y] = $this->Jobpro_model->getWhoisSamaAssistant($id_atasan2))){ //cari assistant atasan 2
                    $y++;
                } else {
                    //nothing
                }

                $atasan = 2; //penanda atasan
    
                //200 dan 201 ambil data yang sama sama saya yang assistant)
                // $my_atasan_assistant[$x] = $this->Jobpro_model->getPositionDetailAssistant($id_atasan1); //ambil informasi daftar atasan saya yang assistant ##NOT USED on ASSISTANT
                // $id_atasan1 = $my_atasan[$x]['id_atasan1'];
                // $x++;
            } else {
                if($my_pos_detail['id_atasan1'] != 1 && $my_pos_detail['id_atasan1'] != 0 && $my_pos_detail['div_id'] != 1){ //apakah atasan 1nya bukan CEO atau dia punya atasan

                    //cari posisi yang bukan assistant
                    $whois_sama[0] = $this->Jobpro_model->getWhoisSama($id_atasan1); //200 dan 201 ambil data yang sama sama saya yang bukan assistant
                    $my_atasan[0] = $this->Jobpro_model->getPositionDetail($id_atasan1); //ambil informasi daftar atasan saya yang bukan assistant
                    //cari posisi yang assistant
                    if(!empty($whois_sama_assistant1[$y] = $this->Jobpro_model->getWhoisSamaAssistant($id_atasan1))){ //cari assistant atasan 1
                        $y++;
                    } else {
                        //nothing
                    }

                    $assistant_atasan1 = 0; //tandai buat nanti nampilin orgchartnya horizontal di level ke 3
                    $atasan = 1;//penanda atasan

                    //200 dan 201 ambil data yang sama sama saya yang assistant)
                    // $my_atasan_assistant[$x] = $this->Jobpro_model->getPositionDetailAssistant($id_atasan1); //ambil informasi daftar atasan saya yang assistant ##NOT USED on ASSISTANT
                    // $id_atasan1 = $my_atasan[$x]['id_atasan1'];
                    // $x++;
                } elseif($my_pos_detail['id_atasan1'] == 1 && $my_pos_detail['div_id'] == 1){

                    //cari posisi yang bukan assistant
                    $whois_sama[0] = $this->Jobpro_model->getWhoisSamaCEOffice($id_atasan1, '1'); //200 dan 201 ambil data yang sama sama saya yang bukan assistant
                    $my_atasan[0] = $this->Jobpro_model->getPositionDetail($id_atasan1); //ambil informasi daftar atasan saya yang bukan assistant
                    //cari posisi yang assistant
                    if(!empty($whois_sama_assistant1[$y] = $this->Jobpro_model->getWhoisSamaAssistant($id_atasan1))){ //cari assistant atasan 1
                        $y++;
                    } else {
                        //nothing
                    }

                    $assistant_atasan1 = 0; //tandai buat nanti nampilin orgchartnya horizontal di level ke 3
                    $atasan = 1;//penanda atasan

                    //200 dan 201 ambil data yang sama sama saya yang assistant)
                    // $my_atasan_assistant[$x] = $this->Jobpro_model->getPositionDetailAssistant($id_atasan1); //ambil informasi daftar atasan saya yang assistant ##NOT USED on ASSISTANT
                    // $id_atasan1 = $my_atasan[$x]['id_atasan1'];
                    // $x++;
                } else {
                    //nothing
                    $assistant_atasan1 = 0; //tandai buat nanti nampilin orgchartnya horizontal di level ke 3
                    $atasan = 0;//penanada atasan
                }
            }
            //cari id yang sama dengan $my_pos_detail di $whois_sama, lalu tambahin 'className': 'my-position' //jika my position bukan assistant
            foreach($whois_sama as $k => $v){
                foreach ($v as $key => $value){
                    if($my_pos_detail['id'] == $value['id']){
                        $whois_sama[$k][$key]['className'] = 'my-position';
                    }
                }
            }

            //reverse arraynya dulu
            $whois_sama = array_reverse($whois_sama);
            $my_atasan = array_reverse($my_atasan);

            // print_r($whois_sama);
            // print('<br>');
            // print('<br>');
            // print_r($my_atasan);

            // exit;
            //output $whois_sama
            // Array ( [0] => Array ( [0] => Array ( [id] => 182 [position_name] => Compensation & Benefit Dept. Head [dept_id] => 27 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
            //                        [1] => Array ( [id] => 190 [position_name] => General Affairs & GovRel Dept. Head [dept_id] => 28 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
            //                        [2] => Array ( [id] => 194 [position_name] => Employee Relation & Safety Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
            //                        [3] => Array ( [id] => 195 [position_name] => HCIS Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
            //                        [4] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 )
            //                     ) 
            //         [1] => Array ( [0] => Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 )
            //                        [1] => Array ( [id] => 201 [position_name] => Talent & Performance Management Specialist [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
            //                     )
            //     )
            //output $my_atasan
            // Array ( [0] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 )
            //         [1] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
            //     ) 

            //gabungkan array $whois_sama dengan $my_atasan
            $org_struktur = $my_atasan;
            foreach($my_atasan as $k => $v){
                $org_struktur[$k]['children'] = $whois_sama[$k];
            }

            // print_r($org_struktur);
            //output $org_struktur
            // Array ( [0] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 
            //         [children] => Array ( [0] => Array ( [id] => 182 [position_name] => Compensation & Benefit Dept. Head [dept_id] => 27 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 )
            //                               [1] => Array ( [id] => 190 [position_name] => General Affairs & GovRel Dept. Head [dept_id] => 28 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 )
            //                               [2] => Array ( [id] => 194 [position_name] => Employee Relation & Safety Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
            //                               [3] => Array ( [id] => 195 [position_name] => HCIS Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
            //                               [4] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 )
            //                             ) 
            //                     ) 
            //         [1] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 
            //         [children] => Array ( [0] => Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 )
            //                               [1] => Array ( [id] => 201 [position_name] => Talent & Performance Management Specialist [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
            //                             )
            //                     )
            //     ) 

            if($atasan == 2){ //gabungkan array[0] dengan [1]; kalo dia punya atasan 1 dan 2
                $i = 0;
                foreach($org_struktur[1]['children'] as $key => $value){
                    foreach($org_struktur[0]['children'] as $k => $v){
                        if($org_struktur[1]['id'] == $org_struktur[0]['children'][$k]['id']){
                            $org_struktur[0]['children'][$k]['children'][$i] = $value;
                            $i++;
                        }
                    }
                }
            } else {
                //nothing
            }

            // print_r($org_struktur);
            // exit;
            // Array ( [0] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 [assistant] => 0 [children] => Array ( [0] => Array ( [id] => 182 [position_name] => Compensation & Benefit Dept. Head [dept_id] => 27 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 [assistant] => 0 ) 
            //                                                                                                                                                                                            [1] => Array ( [id] => 190 [position_name] => General Affairs & Government Relation Dept. Head [dept_id] => 28 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 [assistant] => 0 ) 
            //                                                                                                                                                                                            [2] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 [assistant] => 0 [children] => Array ( [0] => Array ( [id] => 198 [position_name] => Learning & Development Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 [assistant] => 0 )
            //                                                                                                                                                                                                                                                                                                                                                                                         [1] => Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 [assistant] => 0 [className] => my-position ) 
            //                                                                                                                                                                                                                                                                                                                                                                                         [2] => Array ( [id] => 201 [position_name] => Talent & Performance Management Specialist [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 [assistant] => 0 ) 
            //                                                                                                                                                                                                                                                                                                                                                                                     )
            //                                                                                                                                                                                                         )
            //                                                                                                                                                                                         ) 
            //                         ) 
            //         [1] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 [assistant] => 0 [children] => Array ( [0] => Array ( [id] => 198 [position_name] => Learning & Development Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 [assistant] => 0 ) 
            //                                                                                                                                                                                                      [1] => Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 [assistant] => 0 [className] => my-position ) 
            //                                                                                                                                                                                                      [2] => Array ( [id] => 201 [position_name] => Talent & Performance Management Specialist [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 [assistant] => 0 )
            //                                                                                                                                                                                                    ) 
            //                      )
            //     ) 

            //ASSISTANT DATA
            //keluarkan semua assistant jadi di level teratas
            $org_assistant1 = array(); $x = 0; //initialize assistant atasan 1
            foreach($whois_sama_assistant1 as $k => $v){
                foreach($v as $key => $value){
                    $org_assistant1[$x] = $value; //tambah value ke org_struktur
                    foreach($this->Jobpro_model->getAtasanAssistant($value['id_atasan1']) as $kunci => $nilai){ //cari atasannya 

                        // array_push($org_assistant[$x], $nilai); //tambah nama posisi atasannya
                        $org_assistant1[$x]['atasan_assistant'] = $nilai; //tambah nama posisi atasannya
                    }

                    $x++;
                }
            }
            if(!empty($whois_sama_assistant2)){
                $org_assistant2 = array(); $x = 0; //initialize assistant atasan 2
                foreach($whois_sama_assistant2 as $k => $v){
                    foreach($v as $key => $value){
                        $org_assistant2[$x] = $value; //tambah value ke org_struktur
                        foreach($this->Jobpro_model->getAtasanAssistant($value['id_atasan1']) as $kunci => $nilai){ //cari atasannya 
                            // array_push($org_assistant[$x], $nilai); //tambah nama posisi atasannya
                            $org_assistant2[$x]['atasan_assistant'] = $nilai; //tambah nama posisi atasannya
                        }

                        $x++;
                    }
                }
            }else{
                $org_assistant2 = array();
            }

            //jika assistant adalah my-position tambahkan className my-position
            foreach($org_assistant1 as $k => $v){ //cek di assistan atasan 1
                if($my_pos_detail['id'] == $v['id']){
                    $org_assistant1[$k]['className'] = 'my-position';
                }
            }
            foreach($org_assistant2 as $k => $v){ //cek di assistan atasan 2
                if($my_pos_detail['id'] == $v['id']){
                    $org_assistant2[$k]['className'] = 'my-position';
                }
            }
            // Array ( [0] => Array ( [id] => 194 [position_name] => Employee Relation & Safety Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 [assistant] => 1 [atasan_assistant] => Human Capital Division Head ) 
            //         [1] => Array ( [id] => 195 [position_name] => HCIS Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 [assistant] => 1 [atasan_assistant] => Human Capital Division Head ) 
            //     ) 
            
            //simpan data assistant dalam bentuk JSON
            // $data['orgchart_data'] = json_encode($org_struktur[0]); //masukkan data orgchart yang sudah diolah ke JSON
            // $data['orgchart_data_assistant'] = json_encode($org_assistant);
            return array(json_encode($org_struktur[0]), json_encode($org_assistant1), json_encode($org_assistant2), $assistant_atasan1, $atasan);

        } else { //if orgchart data doesn't exist
            // $data['orgchart_data_assistant'] = json_encode("");
            // $data['orgchart_data'] = json_encode("");
            print_r('gaada bro');
            exit;
        }
        // End of Pengolahan data orgchart ==============================================================================
    }

    public function printJp(){
        //load the main library TCPDF (.application/library/tcpdf)
        //I have created a Library loader in that folder, just load using this code below
        $this->load->library('Pdf');

        // buat PDF baru
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

        //atur informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Job Profile');
        $pdf->SetAuthor('Centratama Group');
        $pdf->SetSubject('Document');
        $pdf->SetKeywords('Printed Document, Digital Document');

        //atur default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE. '001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        //atur font header dan footer
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        //atur default font monospaced
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //atur margin
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(15, 30, 15, true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // $pdf->SetHeaderMargin(30);
        // $pdf->SetTopMargin(20);
        // $pdf->setFooterMargin(20);

        //atur auto page break
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        //atur image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // --------------------------------------------------------------

        //atur default font subsetting mode
        $pdf->setFontSubsetting(true);

        //atur Font
        //dejavusans is a UTF-8 Unicode font if you only need to
        //print standard ASCII chars, you can use core fonts like
        //helvetica or times to reduce file size
        $pdf->setFont('dejavusans', '', 14, '', true);

        //Add a page
        //This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        //set text shadow effect
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196,196,196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        //atur content untuk diprint
        $date = date('d F Y', time());
        $html = '
            <style>
                table{
                    border-collapse: collapse;
                    width: 100%;
                }
                table, th, td{
                    border: 1px solid black;
                }
            </style>

            <table>
                <thead>
                    <tr>
                        <th style="text:">PROFIL JABATAN</th>
                        <th>Tanggal: ' . $date . '</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td></td>
                    </tr>
                    
                </tbody>
            </table>
        ';

        //print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // $pdf->Write(5, 'Tes 123 tes tes'); //write some text

        // --------------------------------------------------------------

        // tutup dan tampilkan dokumen PDF
        // This method has several options, check the source code documentation for more information.
        
        $pdf->SetDisplayMode('real', 'default');
        // $pdf->Output('Centratama-JP.pdf', 'I');

        $this->load->view('templates/print_preview.php');
        // print('hello');
        
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}

/* End of file Jobs.php */

/* Status Approval Infomation
0 = Belum diisi
1 = Direview Atasan 1
2 = Direview Atasan 2
3 = Revisi
4 = Selesai
*/


//Lab Area, you know I want to try if we can get all those hiearchy from my position to the last top hierachy, I'm still stuck here. here is my progress
//SHIFT+CTRL+END then CTRL+/ to remove comments

// $x = 0;
// $i = 0;
// //ambil semua data sampai pada id_atasan = 1
// while($i<1) {
//     $whois_sama[$x] = $this->Jobpro_model->getWhoisSama($id_atasan1); //200 dan 201
//     $my_atasan[$x] = $this->Jobpro_model->getPositionDetail($id_atasan1); //ambil informasi detail posisi saya
//     $id_atasan1 = $my_atasan[$x]['id_atasan1'];
//     if($id_atasan1 == 1){
//         $i++;
//     }else{
//         $x++;
//     }
// }

// $my_atasan_tertinggi = $this->Jobpro_model->getPositionDetail($id_atasan1); //ambil informasi detail posisi saya //200


// // print_r($whois_sama);
// // print('<br>');
// // print('<br>');
// // print_r($my_atasan);
// // print('<br>');
// // print('<br>');
// // print_r($my_atasan_tertinggi);
// // print('<br>');
// // print('<br>');
// // output $my_atasan
// // Array ( [0] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //         [1] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 )
// //       ) 

// //output $whois_sama
// // Array ( [0] => Array ( [0] => Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
// //                        [1] => Array ( [id] => 201 [position_name] => Talent & Performance Management Specialist [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
// //                        ) 
// //         [1] => Array ( [0] => Array ( [id] => 182 [position_name] => Compensation & Benefit Dept. Head [dept_id] => 27 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        [1] => Array ( [id] => 190 [position_name] => General Affairs & GovRel Dept. Head [dept_id] => 28 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        [2] => Array ( [id] => 194 [position_name] => Employee Relation & Safety Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        [3] => Array ( [id] => 195 [position_name] => HCIS Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        [4] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        ) 
// //     ) 
// //output my_atasan_tertinggi
// // Array ( [id] => 1 [position_name] => Chief Executive Officer [dept_id] => 1 [div_id] => 1 [id_atasan1] => 0 [id_atasan2] => 0 ) 

// //reverse arraynya dulu
// $whois_sama = array_reverse($whois_sama);
// $my_atasan = array_reverse($my_atasan);

// // print_r($whois_sama);
// // print('<br>');
// // print('<br>');
// // print_r($my_atasan);
// // print('<br>');
// // print('<br>');
// // print_r($my_atasan_tertinggi);

// //output $whois_sama
// // Array ( [0] => Array ( [0] => Array ( [id] => 182 [position_name] => Compensation & Benefit Dept. Head [dept_id] => 27 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        [1] => Array ( [id] => 190 [position_name] => General Affairs & GovRel Dept. Head [dept_id] => 28 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        [2] => Array ( [id] => 194 [position_name] => Employee Relation & Safety Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                        [3] => Array ( [id] => 195 [position_name] => HCIS Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 )
// //                        [4] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                     ) 
// //         [1] => Array ( [0] => Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
// //                        [1] => Array ( [id] => 201 [position_name] => Talent & Performance Management Specialist [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
// //                     ) 
// //     )

// //output $my_atasan
// // Array ( [0] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 ) 
// //         [1] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //     ) 

// //output my_atasan_tertinggi
// // Array ( [id] => 1 [position_name] => Chief Executive Officer [dept_id] => 1 [div_id] => 1 [id_atasan1] => 0 [id_atasan2] => 0 ) 

// //masukkin anak2 dari atasan
// $org_struktur = $my_atasan;
// foreach($my_atasan as $k => $v){
//     $org_struktur[$k]['children'] = $whois_sama[$k];
// }

// print_r($org_struktur);
// //output $org_struktur
// // Array ( [0] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 
// //                        [children] => Array ( [0] => Array ( [id] => 182 [position_name] => Compensation & Benefit Dept. Head [dept_id] => 27 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 )
// //                                              [1] => Array ( [id] => 190 [position_name] => General Affairs & GovRel Dept. Head [dept_id] => 28 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 )
// //                                              [2] => Array ( [id] => 194 [position_name] => Employee Relation & Safety Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                                              [3] => Array ( [id] => 195 [position_name] => HCIS Officer [dept_id] => 26 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                                              [4] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) 
// //                                              ) 
// //                     ) 
// //         [1] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 
// //                        [children] => Array ( [0] => Array ( [id] => 200 [position_name] => Recruitment Officer [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
// //                                              [1] => Array ( [id] => 201 [position_name] => Talent & Performance Management Specialist [dept_id] => 29 [div_id] => 6 [id_atasan1] => 199 [id_atasan2] => 196 ) 
// //                                              ) 
// //                     ) 
// //     ) 
// exit;

// $org_struktur = $my_atasan_tertinggi;

// //masukin atasan ke dalam jabatan tertinggi array
// foreach($whois_sama as $k => $v){
//     if($org_struktur['id'] == $my_atasan[$k]['id_atasan1']){
//         $org_children = $my_atasan[$k];
//     }
// } 

// //buat pointer
// $org_pointer = array();
// foreach($my_atasan as $k => $v){
//     $org_pointer[$k] = "children";
// }

// $in  = $org_pointer; // Array with incoming params
// $res = array();        // Array where we will write result
// $t   = &$res;          // Link to first level
// foreach ($in as $k) {  // Walk through source array
// if (empty($t[$k])) { // Check if current level has required key
//     $t[$k] = $my_atasan;  // If does not, create empty array there
//     $t = &$t[$k];      // And link to it now. So each time it is link to deepest level.
// }
// }
// unset($t); // Drop link to last (most deep) level
// print_r($res);
// die();



// // $org_struktur[$org_pointer] = $org_children;

// //buat pointer
// $org_pointer;
// // foreach($my_atasan as $v){

// // }
// $a = array("1","5","6");
// $b = array();
// $c =& $b;

// foreach ($a as $k) {
//     $c[$k] = array();
//     $c     =& $c[$k];
// }



// var_dump($org_struktur);
// // Array ( [id] => 1 [position_name] => Chief Executive Officer [dept_id] => 1 [div_id] => 1 [id_atasan1] => 0 [id_atasan2] => 0 
// //         [children] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 ) 
// //         )



// //penunjuk lokasi tingkatan org_struktur
// $org_pointer = "children";
// // print_r($org_struktur[$org_pointer]);

// // while($i<1){
// //     if($my_atasan)
// // }

// exit;
// // Array ( [id] => 1 
// // [position_name] => Chief Executive Officer 
// // [dept_id] => 1 
// // [div_id] => 1 
// // [id_atasan1] => 0 
// // [id_atasan2] => 0 
// // [0] => Array ( [id] => 196 [position_name] => Human Capital Division Head [dept_id] => 26 [div_id] => 6 [id_atasan1] => 1 [id_atasan2] => 0 ) 
// // [children] => 9 [1] => Array ( [id] => 199 [position_name] => Organization Development Dept. Head [dept_id] => 29 [div_id] => 6 [id_atasan1] => 196 [id_atasan2] => 1 ) ) 

// print_r($org_struktur);
// exit;

// while($i<1) {
//     $org_struktur['children'] = array_push($org_struktur, $my_atasan[$k]);


//     $whois_sama[$x] = $this->Jobpro_model->getWhoisSama($id_atasan1); //200 dan 201
//     $my_atasan[$x] = $this->Jobpro_model->getPositionDetail($id_atasan1); //ambil informasi detail posisi saya
//     $id_atasan1 = $my_atasan[$x]['id_atasan1'];
//     if($id_atasan1 == 1){
//         $i++;
//     }else{
//         $x++;
//     }
// }

// // var datasource = {
// // 	'id': '1',
// // 	'name': 'Lao Lao',
// // 	'title': 'general manager',
// // 	'children': [
// // 	  	{ 'id': '2', 'name': 'Bo Miao', 'title': 'department manager' },
// // 	  	{ 'id': '3', 'name': 'Su Miao', 'title': 'department manager',
// // 			'children': [
// // 				{ 'id': '4', 'name': 'Tie Hua', 'title': 'senior engineer' },
// // 				{ 'id': '5', 'name': 'Hei Hei', 'title': 'senior engineer',
// // 					'children': [
// // 						{ 'id': '6', 'name': 'Pang Pang', 'title': 'engineer' },
// // 						{ 'id': '7', 'name': 'Xiang Xiang', 'title': 'UE engineer' }
// // 					]
// // 				}
// // 			]
// // 	   	},
// // 	   	{ 'id': '8', 'name': 'Hong Miao', 'title': 'department manager' },
// // 	   	{ 'id': '9', 'name': 'Chun Miao', 'title': 'department manager' }
// // 	]
// // };

// // print_r($my_atasan);
// exit;
// // cari yang sama-sama memiliki atasan1 yang sama
// $whois_sama1 = $this->Jobpro_model->getWhoisSama($my_pos_detail['id_atasan1']); //200 dan 201
// // retrieve id yang sama-sama punya atasan2
// $my_atasan1 = $this->Jobpro_model->getPositionDetail($my_pos_detail['id_atasan1']); //ambil informasi detail posisi saya //199
// // ambil atasan2
// $whois_sama2 = $this->Jobpro_model->getWhoisSama($my_atasan1['id_atasan1']);
// // cari yang sama
// $my_atasan2 = $this->Jobpro_model->getPositionDetail($my_atasan1['id_atasan1']); //ambil informasi detail posisi saya

// //if $my_atasan2 == 1 thrn stop
// print_r($my_atasan2);
// exit;


// //ambil data diri
// //ambil data teman
// //ambil data diri
// //ambil data teman
// //ambil data diri
// //ambil data sampai id_atasan=1

// // $myJSON = json_encode($print); convert any array to JSON

// // print('<br>');
// // print_r($myJSON);
// // $myObj->name = "John";
// // $myObj->age = 30;
// // $myObj->city = "New York";

// // print('<br>');
// // print_r($myObj);
// // print_r($print);
// exit();

// // var datasource = {
// // 	'id': '1',
// // 	'name': 'Lao Lao',
// // 	'title': 'general manager',
// // 	'children': [
// // 	  	{ 'id': '2', 'name': 'Bo Miao', 'title': 'department manager' },
// // 	  	{ 'id': '3', 'name': 'Su Miao', 'title': 'department manager',
// // 			'children': [
// // 				{ 'id': '4', 'name': 'Tie Hua', 'title': 'senior engineer' },
// // 				{ 'id': '5', 'name': 'Hei Hei', 'title': 'senior engineer',
// // 					'children': [
// // 						{ 'id': '6', 'name': 'Pang Pang', 'title': 'engineer' },
// // 						{ 'id': '7', 'name': 'Xiang Xiang', 'title': 'UE engineer' }
// // 					]
// // 				}
// // 			]
// // 	   	},
// // 	   	{ 'id': '8', 'name': 'Hong Miao', 'title': 'department manager' },
// // 	   	{ 'id': '9', 'name': 'Chun Miao', 'title': 'department manager' }
// // 	]
// // };