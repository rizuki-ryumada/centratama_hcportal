<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Employe_model');
        $this->load->model('Divisi_model');
        $this->load->model('Dept_model');
        is_logged_in();
        
    }
    

    public function employe()
    {
        $data['title'] = 'Master Employe';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['employe'] = $this->Employe_model->getAllEmp();
        $data['divisi'] = $this->Divisi_model->getAll();
        $data['nik'] = $this->Employe_model->getLastNik();
        
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

}

/* End of file Master.php */
