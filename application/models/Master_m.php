<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_m extends CI_Model {
	public function delete($table, $where){
        $this->db->where($where['index'], $where['data']);
        $this->db->delete($table);
    }

	public function getAllDivisi()
	{
		return $this->db->get('divisi')->result_array();
	}

	public function getAllDept()
	{
		return $this->db->get('departemen')->result_array();
	}

	public function getDetail($select, $table, $where){ // ambil sebaris data dari tabel
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->row_array();
    }
    public function getDetails($select, $table, $where){ // ambil semua data dari tabel
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->result_array();
	}
	
	public function getJoin2tables($select, $table, $join, $where){ // join 2 table dan ambil valuenya, join left
        $this->db->select($select);
        $this->db->join($join['table'], $join['index'], $join['position']);
        return $this->db->get_where($table, $where)->result_array();
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

	public function insert($table, $data){
        $this->db->insert($table, $data);
    }

	public function update($table, $where, $data){
        $this->db->where($where['db'], $where['server']);
        $this->db->update($table, $data);
    }

}

/* End of file M_master.php */
