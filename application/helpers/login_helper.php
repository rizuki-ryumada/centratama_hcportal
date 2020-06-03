<?php defined('BASEPATH') OR exit('No direct script access allowed');

function is_logged_in(){
    
    $CI =& get_instance();
    
    if(!$CI->session->userdata('nik')){
        redirect('auth','refresh');
    } else {
        $role_id = $CI->session->userdata('role_id');
        $menu = $CI->uri->segment(1);

        $queryMenu = $CI->db->get_where('user_menu', ['menu' => $menu])->row_array();

        if(empty($queryMenu)){ // jika level menu utama tidak ada, cari di sub menu, access submenu level berbeda, ada menu yg gaada di list menu
            $queryMenu = $CI->db->get_where('user_sub_menu', ['title' => $menu])->row_array();
        }else{
            //do nothing
        }

        $menu_id = $queryMenu['id'];

        $userAccess = $CI->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

        if($userAccess->num_rows() < 1){
            redirect('auth/blocked','refresh');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci =& get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_surat_access($role_id, $surat_id){
    $CI =& get_instance();

    $CI->db->where('role_surat_id', $role_id);
    $CI->db->where('surat_id', $surat_id);
    $result = $CI->db->get('user_access_surat');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

?>