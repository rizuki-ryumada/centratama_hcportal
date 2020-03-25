<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobpro_model extends CI_Model {

    public function getMyprofile($nik)
    {
        $this->db->select('employe.*, divisi.division, departemen.nama_departemen, position.position_name, position.id_atasan1 as posnameatasan1,
                            position.id_atasan2, profile_jabatan.tujuan_jabatan, profile_jabatan.id_posisi');
        $this->db->from('employe');
		$this->db->join('divisi', 'divisi.id = employe.id_div', 'left');
		$this->db->join('departemen', 'departemen.id = employe.id_dep', 'left');
		$this->db->join('position', 'position.id = employe.position_id', 'left');
		$this->db->join('profile_jabatan', 'profile_jabatan.id_posisi = position.id', 'left');
        
        $this->db->where('employe.nik', $nik);
        return $this->db->get()->row_array();
    }

    public function getMyDivisi($nik)
    {
        $this->db->select('*');
        $this->db->from('divisi');
        $this->db->join('employe', 'employe.id_div = divisi.id');
        $this->db->where('employe.nik', $nik);
        return $this->db->get()->row_array();        
    }
    
    public function getMyDept($nik)
    {
        $this->db->select('*');
        $this->db->from('departemen');
        $this->db->join('employe', 'employe.id_dep = departemen.id');
        $this->db->where('employe.nik', $nik);
        return $this->db->get()->row_array();        
    }

    public function getPosisi($nik)
    {
        $this->db->select('*');
        $this->db->from('position');
        $this->db->join('employe', 'employe.position_id = position.id');
        $this->db->where('employe.nik', $nik);
        return $this->db->get()->row_array();  
    }

    public function getProfileJabatan($id)
    {
        return $this->db->get_where('profile_jabatan', ['id_posisi' => $id])->row_array();
    }

    public function getAllPosition()
    {
        $this->db->order_by("position_name", "asc");
        return $this->db->get('position')->result_array();
        
    }

    public function getTujabById($id)
    {
        return $this->db->get_where('profile_jabatan', ['id_posisi' => $id])->row_array();
    }

    public function getTjById($id)
    {
        return $this->db->get_where('tanggung_jawab', ['id_tgjwb' => $id])->row_array();
    }

    public function updateJP()
    {
        $data = [
            'keterangan' => $this->input->post('tanggung_jawab'),
            'list_aktivitas' => $this->input->post('aktivitas'),
            'list_pengukuran' => $this->input->post('pengukuran')
        ];
        $this->db->where('id_tgjwb', $this->input->post('id'));
        $this->db->update('tanggung_jawab', $data);
    }

    public function updateTuJab()
    {
        $data = [
            'tujuan_jabatan' => $this->input->post('tujuan_jabatan')
        ];
        $this->db->where('id_posisi', $this->input->post('id'));
        $this->db->update('profile_jabatan', $data);
    }

    public function upTuj($id, $tujuan)
    {
        $this->db->where('id_posisi', $id);
        $this->db->update('profile_jabatan', ['tujuan_jabatan' => $tujuan]);
    }

    public function updateWen($id, $value, $modul)
    {
        $this->db->where(array("id"=>$id));
        $this->db->update("wewenang",array($modul=>$value));
    }

    public function getKualifikasiById($id)
    {
        return $this->db->get_where('kualifikasi', ['id_posisi' => $id])->row_array();
    }
	public function getStaff($id)
	{
		return $this->db->get_where('jumlah_staff', ['id_posisi' => $id])->row_array();
    }
    
    //Ryu code starts here
    public function getPositionDetail($id_posisi){
        $this->db->select('*');
        $this->db->from('position');
        $this->db->where(array('id' => $id_posisi, 'assistant' => 0));
        return $this->db->get()->row_array();
    }

    public function getWhoisSama($id_atasan1){
        $this->db->select('*');
        $this->db->from('position');
        $this->db->where(array('id_atasan1' => $id_atasan1, 'assistant' => 0));
        return $this->db->get()->result_array();
    }

    public function getPositionDetailAssistant($id_posisi){
        $this->db->select('*');
        $this->db->from('position');
        $this->db->where(array('id' => $id_posisi, 'assistant' => 1));
        return $this->db->get()->row_array();
    }

    public function getWhoisSamaAssistant($id_atasan1){
        $this->db->select('*');
        $this->db->from('position');
        $this->db->where(array('id_atasan1' => $id_atasan1, 'assistant' => 1));
        return $this->db->get()->result_array();
    }

    public function getAtasanAssistant($id_atasan1){
        $this->db->select('position_name');
        $this->db->from('position');
        $this->db->where(array('id' => $id_atasan1));
        return $this->db->get()->row_array();
    }
}

/* End of file Jobpro_model.php */
