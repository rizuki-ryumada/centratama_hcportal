<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Employe_model extends CI_Model {

    var $table = 'report';
    var $column_order = array('division','nama_departemen','position_name','emp_name'); //set column field database for datatable orderable
    var $column_search = array('division','nama_departemen','position_name','emp_name'); //set column field database for datatable searchable 
    var $order = array('division' => 'asc'); // default order

    private function _get_report()
    {
        if ($this->input->post('divisi')) {
            $this->db->where('division', htmlspecialchars($this->input->post('divisi')));
        }
        if ($this->input->post('departemen')) {
            $this->db->like('nama_departemen', htmlspecialchars($this->input->post('departemen')));
        }
        
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if($i === 0){
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search)-1 == $i) {
                    $this->db->group_end();
                    
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_report()
    {
        $this->_get_report();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
    }

    public function count_filtered()
    {
        $this->_get_report();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getReport($postData=null)
    {

        // $response = array();

        // $draw = $postData['draw'];
        // $start = $postData['start'];
        // $rowperPage = $postData['length'];
        // $columnIndex = $postData['order'][0]['column'];
        // $columnName = $postData['columns'][$columnIndex]['data'];
        // $columnSortOrder = $postData['order'][0]['dir'];
        // $searchValue = $postData['search']['value'];

        // $searchDiv = $postData['divisi'];

        // $search_arr = array();
        // $searchQuery = "";
        // if($searchValue != ''){
        //     $search_arr[]= "(emp_name like '%".$searchValue."%' or division like '%".$searchValue."%' or nama_departemen like '%".$searchValue."%' or position_name like '%".$searchValue."%')";
        // }
        // if ($searchDiv != '') {
        //     $search_arr[] = "division='".$searchDiv."' ";
        // }
        // if (count($search_arr) > 0) {
        //     $searchQuery = implode(" and ", $search_arr);
        // }

        // ##total employe tanpa filter
        // $this->db->select('count(*) as allcount');
        // $records = $this->db->get('report')->result();
        // $totalRecords = $records[0]->allcount;

        // ##total employe dengan filter
        // $this->db->select('count(*) as allcount');
        // if($searchQuery != '')
        // $this->db->where($searchQuery);
        // $records = $this->db->get('report')->result();
        // $totalRecordwithFilter = $records[0]->allcount;

        // ##fetch record
        // $this->db->select('*');
        // if($searchQuery != '')
        // $this->db->where($searchQuery);
        // $this->db->order_by($columnName, $columnSortOrder);
        // $this->db->limit($rowperpage, $start);
        // $records = $this->db->get('report')->result();

        // $data = array();

        // foreach($records as $record ){
        //     $data[] = array( 
        //         "division"=>$record->division,
        //         "nama_departemen"=>$record->nama_departemen,
        //         "position_name"=>$record->position_name,
        //         "emp_name"=>$record->emp_name
        //         );
        //     }
        //     $response = array(
        //     "draw" => intval($draw),
        //     "iTotalRecords" => $totalRecords,
        //     "iTotalDisplayRecords" => $totalRecordwithFilter,
        //     "data" => $data
        //     );
            
        //     return $response;    
    }



    public function sessEmp($nik)
    {
        $this->db->select('user.nik, user.role_id, user.is_active, employe.emp_name');
        $this->db->from('user');
        $this->db->join('employe', 'employe.nik = user.nik', 'left');
        $this->db->where('employe.nik', $nik);
        $this->db->get();
        
        return $this->db->get()->result_array();
    }

    public function getAll()
    {
        return $this->db->get('employe')->result_array();
    }

    public function getByDiv($id)
    {
        $this->db->select('employe.emp_name,position_id,id_div,id_dep, position.id, position_name, divisi.id, division, departemen.id, nama_departemen');
        $this->db->from('employe');
        $this->db->join('divisi', 'divisi.id = employe.id_div');
        $this->db->join('departemen', 'departemen.id = employe.id_dep');
        $this->db->join('position', 'position.id = employe.position_id');
        $this->db->where('employe.id_div', $id);
        return $this->db->get()->result_array();
    }

    public function getAllEmp()
    {
        $this->db->select('employe.nik as id_emp, employe.emp_name,nik, position.hirarki_org, position_id, position.div_id , position.dept_id, position.id, position_name, divisi.id, division, departemen.id, nama_departemen');
        $this->db->from('position');
        $this->db->join('divisi', 'divisi.id = position.div_id');
        $this->db->join('departemen', 'departemen.id = position.dept_id');
        $this->db->join('employe', 'employe.position_id = position.id');
        $this->db->order_by('id_emp', 'asc');
        
        return $this->db->get()->result_array();
    }
    
    public function getDataEmp()
    {
        $this->db->select('employe.id as id_emp, employe.emp_name, position_name, divisi.division, departemen.nama_departemen');
        $this->db->from('employe');
        $this->db->join('divisi', 'divisi.id = employe.id_div');
        $this->db->join('departemen', 'departemen.id = employe.id_dep');
        $this->db->join('position', 'position.id = employe.position_id');
        $this->db->order_by('id_emp', 'asc');
        
        return $this->db->get()->result_array();
    }

    public function getLastNik()
    {
        $this->db->select_max('nik');
        $result = $this->db->get('employe')->row_array();
        $data = $result['nik'];
        $nomor = (int) substr($data, 2, 6);
        $nomor++;
        $kode = "CG";
        $nik = $kode . sprintf("%06s", $nomor); 
        return $nik;
    }
}

/* End of file Employe_model.php */