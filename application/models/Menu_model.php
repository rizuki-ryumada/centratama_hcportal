<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubmenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                    ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getMenuByID($id)
    {
        return $this->db->get_where('user_menu',['id' => $id])->row_array();
    }

    public function getSubMenuById($id)
    {
        return $this->db->get_where('user_sub_menu',['id' => $id])->row_array();
    }

    public function updateSubMenu()
    {
        $data = [
            'title' => $this->input->post('title'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'is_active' => $this->input->post('is_active')
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_sub_menu', $data);
    }

    public function updateMenu()
    {
        $data = [
            'menu' => $this->input->post('menu'),
            'target' => $this->input->post('target'),
            'icon' => $this->input->post('icon')
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_menu', $data);
    }
}


/* End of file Menu_model.php */


?>