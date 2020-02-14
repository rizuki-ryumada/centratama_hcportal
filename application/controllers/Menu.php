<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * menu class
 */
class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        
        $this->form_validation->set_rules('menu', '<b>Menu Name</b>', 'required');
        $this->form_validation->set_rules('target', '<b>Target Name</b>', 'required');
        $this->form_validation->set_rules('icon', '<b>Icon Name</b>', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/user_footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="flash-data" data-flashdata="Added"></div>');
            redirect('menu');
        }
    }
    
    public function editmenu()
    {
        $data['title'] = 'Menu Management';
        // $data['menu'] = $this->Menu_model->getMenuById($id);
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        
        $this->form_validation->set_rules('menu', '<b>Menu Name</b>', 'required');
        $this->form_validation->set_rules('target', '<b>Target Name</b>', 'required');
        $this->form_validation->set_rules('icon', '<b>Icon Name</b>', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/user_footer');
        } else {
            $this->Menu_model->updateMenu();
            $this->session->set_flashdata('flash', 'Update');
            redirect('menu');
        }
    }

    public function deletemenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
        $this->session->set_flashdata('flash', 'Removed');
        redirect('menu', 'refresh');
    }

    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        
        $data['subMenu'] = $this->Menu_model->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        
        $this->form_validation->set_rules('title', '<b>Title</b>', 'required');
        $this->form_validation->set_rules('menu_id', '<b>Menu</b>', 'required');
        $this->form_validation->set_rules('url', '<b>Url</b>', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/user_footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="flash-data" data-flashdata="Added"></div>');
            redirect('menu/submenu');
        }
    }

    public function deletesubmenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
        $this->session->set_flashdata('flash', 'Removed');
        redirect('menu/submenu', 'refresh');
    }
    
    
    public function updatesubmenu($id)
    {
        $data['title'] = 'Edit Sub Menu';
        $data['subMenuId'] = $this->Menu_model->getSubMenuById($id);
        $data['subMenu'] = $this->Menu_model->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['user'] = $this->db->get_where('employe', ['nik' => $this->session->userdata('nik')])->row_array();
        
        $this->form_validation->set_rules('title', '<b>Title</b>', 'required');
        $this->form_validation->set_rules('menu_id', '<b>Menu</b>', 'required');
        $this->form_validation->set_rules('url', '<b>Url</b>', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('menu/editsubmenu', $data);
            $this->load->view('templates/user_footer');
        } else {
            $this->Menu_model->updateSubMenu();
            $this->session->set_flashdata('flash', 'Update');
            redirect('menu/submenu', 'refresh');
        }
    }

    public function getMenuById()
    {
        echo json_encode($this->Menu_model->getMenuById($_POST['id']));
    }
}



/* End of file Menu.php */
