<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Employe_model');
        $this->load->model('Divisi_model');
        $this->load->model('Dept_model');
        $this->load->model('Master_m');
        is_logged_in();
        
    }

    public function employe()
    {
        $data['title'] = 'Master Employe';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['employe'] = $this->Employe_model->getAllEmp();
        $data['divisi'] = $this->Divisi_model->getAll();
        $data['nik'] = $this->Employe_model->getLastNik();
        $data['dept'] = $this->Dept_model->getAll();

        $data['divisi'] = $this->Master_m->getDetails('id, division', 'divisi', array());
        $data['entity'] = $this->Master_m->getDetails('*', 'entity', array());
        $data['role'] = $this->Master_m->getDetails('*', 'user_role', array());
        
        // $this->form_validation->set_rules('menu', '<b>Menu Name</b>', 'required');
        
        // if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('master/employe', $data);
            $this->load->view('templates/master_footer');
        // } else {
        //     $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
        //     $this->session->set_flashdata('message', '<div class="flash-data" data-flashdata="Added"></div>');
        //     redirect('menu');
        // }
    }

    public function divisi()
    {
        $data['title'] = 'Master Divisi';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['divisi'] = $this->Divisi_model->getAll();
        $data['div_head'] = $this->Divisi_model->getDivByOrg();

        $this->form_validation->set_rules('divisi', 'Division', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[8]|max_length[8]');
        
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/divisi', $data);
        $this->load->view('templates/master_footer');
    }

    public function getDivByID()
    {
        echo json_encode($this->Divisi_model->ajaxDIvById($this->input->post('id')));
    }

    public function edit_divisi()
    {
        $this->form_validation->set_rules('divisi', '<b>Divisi</b>', 'required', ['required' => 'Form nama %s Tidak Boleh Kosong.']);
        $this->form_validation->set_rules('div_head', '<b>Division Head</b>', 'trim|required', [
                                            'required' => 'Form %s tidak boleh kosong']);        
        if ($this->form_validation->run() == false) {
        $data = [
            'title' => 'Master Divisi',
            'user' => $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array(),
            'divisi' => $this->Divisi_model->getAll(),
            'div_head' => $this->Divisi_model->getDivByOrg()
        ];

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/divisi', $data);
        $this->load->view('templates/master_footer');
        } else {
            $this->Divisi_model->updateDiv();
            $this->session->set_flashdata('flash', 'Update');
            redirect('master/divisi','refresh');
        }
    }

    public function departemen()
    {
        $data = [
            'title' => 'Master Departemen',
            'user' => $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array(),
            'departemen' => $this->Dept_model->getAll(),
            'divisi' => $this->Divisi_model->getAll()
        ];

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/departemen', $data);
        $this->load->view('templates/master_footer');
    }

    public function getDepById()
    {
        echo json_encode($this->Dept_model->ajaxDeptById($this->input->post('id')));
    }

    public function edit_departemen()
    {
        $this->form_validation->set_rules('departemen', '<b>Nama departemen</b>', 'required', ['required' => 'Form %s Tidak Boleh Kosong.']);
        $this->form_validation->set_rules('dephead', '<b>Nik departemen head</b>', 'trim|required|min_length[8]|max_length[8]', [
                                            'required' => 'Form %s tidak boleh kosong', 
                                            'min_length' => 'Nik harus 8 karakter.',
                                            'max_length' => 'Nik harus 8 karakter.'
                                            ]);
        $this->form_validation->set_rules('div_id', '<b>Divisi</b>', 'required', ['required' => 'Form %s tidak boleh kosong']);

        
        if ($this->form_validation->run() == false) {
            
            $data = [
            'title' => 'Master Departemen',
            'user' => $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array(),
            'departemen' => $this->Dept_model->getAll(),
            'divisi' => $this->Divisi_model->getAll()
        ];

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/departemen', $data);
        $this->load->view('templates/master_footer');
        } else {
            $this->Dept_model->updateDept();
            $this->session->set_flashdata('flash', 'Update');
            redirect('master/departemen','refresh');
        }
        
    }

    public function tambahEmploye(){//fungsi untuk menambah employe
        // cek role surat dan is_active
        //ubah password ke bcrypt
        //simpan ke database

        $data = array(
            'nik' => $this->input->post('nik'),
            'emp_name' => $this->input->post('name'),
            'position_id' => $this->input->post('position'),
            'id_entity' => $this->input->post('entity'),
            'role_id' => $this->input->post('role'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT) // hashing password
        );

        // cek role surat dan is_active
        if($this->input->post('role_surat') == 'on'){
            $data['akses_surat_id'] = 1;
        } else {
            $data['akses_surat_id'] = 0;
        }
        if($this->input->post('is_active') == 'on'){
            $data['is_active'] = 1;
        } else {
            $data['is_active'] = 0;
        }

        $this->Master_m->insert('employe', $data);
        header('location: ' . base_url('master/employe'));
    }

    // $onik ~ original nik
    public function editEmploye(){ //fungsi untuk mengedit employe
        // jika nik tidak diubah
        $nik = $this->input->post('nik');
        $onik = $this->input->post('onik');
        $data = array(
            'emp_name' => $this->input->post('name'),
            'id_entity' => $this->input->post('entity'),
            'role_id' => $this->input->post('role'),
            'email' => $this->input->post('email')
        );
        //get origin data
        // $dataEmploye = $this->Master_m->getDetail('*', 'employe', array('nik' => $onik));
        
        //cek kalau password tidak kosong
        if(!empty($password = $this->input->post('password'))){ // hasing password dan simpan ke $dataEmploye
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        } else {
            // nothing
        }

        // cek role surat dan is_active
        if($this->input->post('role_surat') == 'on'){
            $data['akses_surat_id'] = 1;
        } else {
            $data['akses_surat_id'] = 0;
        }
        if($this->input->post('is_active') == 'on'){
            $data['is_active'] = 1;
        } else {
            $data['is_active'] = 0;
        }

        //cek jika posisi kosong atau tidak
        if(!empty($position_id = $this->input->post('position'))){
            $data['position_id'] = $position_id;
        } else {
            //nothing
        }

        //cek jika nik diubah atau tidak
        if($nik != $onik){
            $data['nik'] = $nik;
        } else {
            //nothing
        }

        $where = array(
            'db' => 'nik',
            'server' => $onik
        );

        $this->Master_m->update('employe', $where, $data);
        header('location: ' . base_url('master/employe'));
    }

    public function deleteEmploye(){
        $this->Master_m->delete('employe', array(
            'index' => 'nik',
            'data' => $this->input->get('nik')
        ));
    }

    public function getDeptAjax()
    {
        $val = $this->input->post('div_id');
        if ($val) {
            $data = $this->Dept_model->getDeptById($this->input->post('div_id'));
            echo json_encode($data);
        }else{
            $data = $this->Dept_model->getAll();
            echo json_encode($data);
        }
    }

    public function getEmployeDetailsAjax(){
        $nik = $this->input->post('nik');
        $employe = $this->Master_m->getJoin2tables(
                                                    'nik, emp_name, is_active, position_name, id_entity, role_id, akses_surat_id, dept_id, div_id, email', 
                                                    'employe',  
                                                    array('table' => 'position', 'index' => 'employe.position_id = position.id', 
                                                    'position' => 'left'), 
                                                    array('nik' => $nik)
                                                )[0];

        // $employe['divisi'] = $this->Master_m->getDetail('division', 'divisi', array('id' => $employe['div_id']))['division'];
        $employe['departemen'] = $this->Master_m->getDetail('nama_departemen', 'departemen', array('id' => $employe['dept_id']))['nama_departemen'];

        echo json_encode($employe);
    }

    public function getDepartement(){
        if(!empty($div = $this->input->post('divisi'))){
            //get id divisi
            $div = explode('-', $div);
            // print_r($id_div);
            // exit;
            // $divisi_id = $this->Jobpro_model->getDetail("id", "divisi", array('division' => $this->input->post('divisi')))['id'];
            //ambil data departemen dengan divisi itu
            foreach($this->Master_m->getDetails('*', 'departemen', array('div_id' => $div[1])) as $k => $v){
                $data[$k]=$v;
            }
        } else {
            foreach($this->Master_m->getDetails('*', 'departemen', array()) as $k => $v){
                $data[$k]=$v;
            }
        }
        print_r(json_encode($data));
        //bawa balik ke ajax
    }

    public function getPositionsAjax(){
        $div = explode('-', $this->input->post('div'));
        $dept = $this->input->post('dept');
        echo(json_encode($this->Master_m->getDetails('id, position_name', 'position', array('div_id' => $div[1], 'dept_id' => $dept))));
    }
}

/* End of file Master.php */
