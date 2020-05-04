<?php

defined('BASEPATH') or exit('No direct script access allowed');




/**
 * undocumented class
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jobpro_model');
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();

        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
		$data['employe'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password1', 'New Password', 'trim|required|min_length[5]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'trim|required|min_length[5]|matches[new_password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('templates/user_footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['employe']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong Current Password ! </div>');
                // redirect('user/changepassword');
                redirect('user');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    New password cannot be the same as current password ! </div>');
                    redirect('user');
                } else {
                    // password ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('nik', $this->session->userdata('nik'));
                    $this->db->update('employe');
                    
                    $this->session->set_flashdata('message', '<div class="flash-data" data-flashdata="Changed"></div>');
                    redirect('user');
                }
            }
        }
        
        // $this->load->view('templates/user_header', $data);
        // $this->load->view('templates/user_sidebar', $data);
        // $this->load->view('templates/user_topbar', $data);
        // $this->load->view('user/index', $data);
        // $this->load->view('templates/user_footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/user_footer');
        } else {
            $name = $this->input->post('name');
			$nik = $this->session->userdata('nik');
			$this->db->set('emp_name', $name);
            $this->db->where('nik', $nik);
            $this->db->update('employe');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your Profile Has Been Updated ! </div>');
            redirect('user');
        }
    }

    public function changepassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
		$data['employe'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password1', 'New Password', 'trim|required|min_length[5]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'trim|required|min_length[5]|matches[new_password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/user_footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['employe']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong Current Password ! </div>');
                // redirect('user/changepassword');
                redirect('user');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    New password cannot be the same as current password ! </div>');
                    redirect('user');
                } else {
                    // password ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('nik', $this->session->userdata('nik'));
                    $this->db->update('employe');
                    
                    $this->session->set_flashdata('message', '<div class="flash-data" data-flashdata="Changed"></div>');
                    redirect('user');
                }
            }
        }
    }

}

/* End of file User.php */
