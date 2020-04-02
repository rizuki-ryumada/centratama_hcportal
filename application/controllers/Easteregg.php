<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Easteregg extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Divisi_model');
        $this->load->model('Employe_model');
        // is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Report';
        $data['divisi'] = $this->Divisi_model->getDivisi();
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/easteregg_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('reportjobs/index', $data);
        $this->load->view('templates/easteregg_footer');
    }

    public function databyDiv()
    {
        $div = $this->input->post('div_id');
        $data = $this->Employe_model->getByDiv($div);
        echo json_encode($data);
    }

    public function getAllEmp()
    {
        $data = $this->Employe_model->getAllEmp();
        echo json_encode($data);
    }
    
    public function getAllEmpTest()
    {
        // $emp = $this->input->post();
        $return = $this->Employe_model->getDataEmp();
        $field = json_encode($return);

        $this->db->insert_batch('report', $return);

        // var_dump($data);
    }

    public function getreport()
    {
        // POST data
        // $postData = $this->input->post();

        // Get data
        // $data = $this->Employe_model->getReport($postData);

        // echo json_encode($data);

        $list = $this->Employe_model->get_report();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $employe) {
            $no++;
            $row = array();
            $row[]= $employe->division;
            $row[]= $employe->nama_departemen;
            $row[]= $employe->position_name;
            $row[]= $employe->emp_name;

            $data[] = $row;
        }

        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Employe_model->count_all(),
            'recordsFiltered' => $this->Employe_model->count_filtered(),
            'data' => $data
        ];

        echo json_encode($output);
    }
}

/* End of file Reportjobs.php */