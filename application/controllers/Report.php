<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller { // need to be separated because the user access level

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jobpro_model');
        is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(){
        $nik = $this->session->userdata('nik'); //get nik
        $my_position = $this->Jobpro_model->getDetail('position_id', 'employe', array('nik' => $nik))['position_id']; //ambil my_position
        $role_id = $this->Jobpro_model->getDetail('role_id', 'employe', array('nik' => $nik))['role_id']; //ambil role_id

        if($role_id == 1){ // cek role_id apakah punya hak akses admin
            $task = $this->Jobpro_model->getAllAndOrder('id_posisi', 'job_approval');
            $data['dept'] = $this->Jobpro_model->getAllAndOrder('nama_departemen', 'departemen');
            $data['divisi'] = $this->Jobpro_model->getAllAndOrder('division', 'divisi');
        } else {
            $task1 = $this->Jobpro_model->getJoin2tables('*', 'job_approval', array('table' => 'position', 'index' => 'position.id = job_approval.id_posisi', 'position' => 'left'), "(id_approver1=".$my_position." AND status_approval=0) OR (id_approver1=".$my_position." AND status_approval=2) OR (id_approver1=".$my_position." AND status_approval=3) OR (id_approver1=".$my_position." AND status_approval=4)"); //cari approval di my position
            $task2 = $this->Jobpro_model->getJoin2tables('*', 'job_approval', array('table' => 'position', 'index' => 'position.id = job_approval.id_posisi', 'position' => 'left'), "(id_approver2=".$my_position." AND status_approval=0) OR (id_approver2=".$my_position." AND status_approval=1) OR (id_approver2=".$my_position." AND status_approval=3) OR (id_approver2=".$my_position." AND status_approval=4)");
            $task = array_merge($task1, $task2);

            $my_div = $this->Jobpro_model->getDetail('div_id', 'position', array('id' => $my_position)); //ambil my_position
            $data['dept'] = $this->Jobpro_model->getDetails('nama_departemen', 'departemen', $my_div); //ambil departemen sesuai divisinya
        }

        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['hirarki_org'] = $this->Jobpro_model->getDetail('hirarki_org', 'position', array('id' => $data['user']['position_id']))['hirarki_org'];
        $data['approval_data'] = $this->getApprovalDetails($task);
        
        

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('jobs/report_v', $data);
        $this->load->view('templates/report_footer');
    }

    public function getApprovalDetails($my_task){ // Copied from Jobs Controller
        // print_r($my_task);
        //lengkapi data my_task
        $tugas = array(); $x = 0;
        foreach($my_task as $key => $value){
            //cari employe dengan id posisi
            $temp_employe = $this->Jobpro_model->getDetails("nik, emp_name", "employe", array('position_id' => $value['id_posisi']));
            if(!empty($temp_employe)){
                foreach($temp_employe as $v){
                    $temp_tugas = array_merge($v, $value);
                    $tugas[$x] = array_merge($temp_tugas, $this->getPositionDetails($value['id_posisi']));
                    $x++;
                }
            }else{
                $tugas[$x] = array_merge($value, $this->getPositionDetails($value['id_posisi']));
                $tugas[$x]['emp_name'] = " ";
                $tugas[$x]['nik'] = " ";
                $x++; //increment the identifier
            }
        }
        
        //lengkapi division, departement, nama position, nama employee nya
        // foreach($my_task as $key => $value){
            // $temp_employe = $this->Jobpro_model->getEmployeDetail("emp_name, position.div_id, position.dept_id, position_id", "employe", array('nik' => $value['nik']));
        //     $my_task[$key]['name'] = $temp_employe['emp_name'];
        //     foreach ($this->Jobpro_model->getDetail("position_name", "position", array('id' => $temp_employe['position_id'])) as $v){
        //         $my_task[$key]['posisi'] = $v;
        //     }
        //     foreach($this->Jobpro_model->getDetail("nama_departemen", "departemen", array('id' => $temp_employe['dept_id'])) as $v){
        //         $my_task[$key]['departement'] = $v;
        //     }
        //     foreach($this->Jobpro_model->getDetail("division", "divisi", array('id' => $temp_employe['div_id'])) as $v){
        //         $my_task[$key]['divisi'] = $v;
        //     }
        // }

        return $tugas;
    }

    function getPositionDetails($id_posisi){
        $temp_posisi = $this->Jobpro_model->getDetail("div_id, dept_id, id", "position", array('id' => $id_posisi));
        // print_r($temp_posisi);
        foreach ($this->Jobpro_model->getDetail("position_name", "position", array('id' => $temp_posisi['id'])) as $v){// tambahkan nama posisi
            $detail_posisi['posisi'] = $v;
        }
        foreach($this->Jobpro_model->getDetail("nama_departemen", "departemen", array('id' => $temp_posisi['dept_id'])) as $v){// tambahkan nama departemen
            $detail_posisi['departement'] = $v;
        }
        foreach($this->Jobpro_model->getDetail("id", "departemen", array('id' => $temp_posisi['dept_id'])) as $v){// tambahkan id departemen
            $detail_posisi['id_dept'] = $v;
        }
        foreach($this->Jobpro_model->getDetail("division", "divisi", array('id' => $temp_posisi['div_id'])) as $v){// tambahkan nama divisi
            $detail_posisi['divisi'] = $v;
        }
        foreach($this->Jobpro_model->getDetail("id", "divisi", array('id' => $temp_posisi['div_id'])) as $v){// tambahkan id divisi
            $detail_posisi['id_div'] = $v;
        }
        return $detail_posisi;
    }

    public function getHistoryApproval(){ //archived, need to change the job_approval database structure
        // print_r($this->input->post('divisi'));
        // print_r($this->input->post('departement'));
        // print_r($this->input->post('status'));
        // print_r($_POST['search']); //get search value from dataTables
        //output
        // Array
        // (
        //     [value] => ra
        //     [regex] => false
        // )

        
        // print_r($_POST['order']); //get order value from dataTables
        //output
        // Array
        // (
        //     [0] => Array
        //         (
        //             [column] => 1
        //             [dir] => asc
        //         )

        // )

        $approval_data = $this->Jobpro_model->getAll('job_approval');
        $approval_data = $this->getApprovalDetails($approval_data);

        $data = array();
        $no = $this->input->post('start'); // get zero number from post variable? WTF this is good.

        print_r($approval_data);

        foreach($approval_data as $v){
            $no++;
            $row = array();
            $row[]= $v['divisi'];
            $row[]= $v['departement'];
            $row[]= $v['posisi'];
            $row[]= $v['name'];
            $row[]= $v['status_approval'];
            $row[]= $v['divisi'];

            $data[]=$row;
        }

        $output = [
            'draw' => $this->input->post('draw'),
            'recordsTotal' => '0',
            'recordsFiltered' => '0',
            'data' => $data
        ];
        // print_r($output);
    }

    public function getDepartement(){
        if(!empty($div = $this->input->post('divisi'))){
            //get id divisi
            $div = explode('-', $div);
            // print_r($id_div);
            // exit;
            // $divisi_id = $this->Jobpro_model->getDetail("id", "divisi", array('division' => $this->input->post('divisi')))['id'];
            //ambil data departemen dengan divisi itu
            foreach($this->Jobpro_model->getDetails('*', 'departemen', array('div_id' => $div[1])) as $k => $v){
                $data[$k]=$v;
            }
        } else {
            foreach($this->Jobpro_model->getDetails('*', 'departemen', array()) as $k => $v){
                $data[$k]=$v;
            }
        }
        
        print_r(json_encode($data));

        //bawa balik ke ajax
    }

    public function setStatusApproval(){
        $id_posisi = $this->input->post('id');
        // $status_approval = $this->input->post('value');

        $data = [
            'status_approval' => $this->input->post('status_approval')
        ];
        $this->Jobpro_model->updateApproval($data, $id_posisi);
    }

    public function settings() {
        // cek role apa punya akses
        $nik = $this->session->userdata('nik'); //get nik
        $role_id = $this->Jobpro_model->getDetail('role_id', 'employe', array('nik' => $nik))['role_id']; //ambil role_id
        if($role_id != 1){
            $this->blocked();
        }

        // siapkan data
        $task = $this->Jobpro_model->getAllAndOrder('id_posisi', 'job_approval');
        $data['dept'] = $this->Jobpro_model->getAllAndOrder('nama_departemen', 'departemen');
        $data['divisi'] = $this->Jobpro_model->getAllAndOrder('division', 'divisi');

        $data['title'] = 'Report';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['hirarki_org'] = $this->Jobpro_model->getDetail('hirarki_org', 'position', array('id' => $data['user']['position_id']))['hirarki_org'];
        $data['approval_data'] = $this->getApprovalDetails($task);
        

        // print_r($data);
        
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('jobs/settings_v', $data);
        $this->load->view('templates/report_footer');
        // tampilkan
    }

    public function blocked() {
        show_404();
        exit;
    }

}
// TODO tambahin fitur export report table ke excel
