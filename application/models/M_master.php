<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_master extends CI_Model {

	public function getAllDivisi()
	{
		return $this->db->get('divisi')->result_array();
	}

	public function getAllDept()
	{
		return $this->db->get('departemen')->result_array();
	}

	public function getNik()
	{
		$query = $this->db->query("SELECT MAX(nik) as nik from pengguna");
		$hasil = $query->row();
		return $hasil->nik;
	}

	public function getAllPengguna()
	{
		$this->db->select('pengguna.nik, pengguna.nama_lengkap, pengguna.tanggal_join, divisi.nama_divisi, departemen.nama_departemen, entity.keterangan');
		$this->db->from('pengguna');
		$this->db->join('divisi', 'divisi.id = pengguna.id_divisi');
		$this->db->join('departemen', 'departemen.id = pengguna.id_departemen');
		$this->db->join('entity', 'entity.id = pengguna.id_entity', 'left');
		$this->db->order_by('nik', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

}

/* End of file M_master.php */
