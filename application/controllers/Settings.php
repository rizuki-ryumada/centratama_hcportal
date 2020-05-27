<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Divisi_model');
        $this->load->model('Dept_model');
        is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
    }
    

    public function index()
    {
        
    }

    //TODO buat setting banner pengumuman dan banner tema
    function hcPortal() {
        $data = [
            'title' => 'HC Portal',
            'user' => $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array(),
            'divisi' => $this->Divisi_model->getAll(),
            'div_head' => $this->Divisi_model->getDivByOrg()
        ];
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('settings/hcportal_s_v', $data);
        $this->load->view('templates/settings_footer');
    }

}

/* End of file Settings.php */
