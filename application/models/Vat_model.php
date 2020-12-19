<?php

class vat_model extends CI_Model {

    var $table = 'vat_list';
    var $column_order = array(null, 'date', 'vat_per'); //set column field database for datatable orderable
    var $column_search = array('date', 'vat_per'); //set column field database for datatable searchable
    var $order = array('date' => 'desc'); // default order

    public function __construct() {
        $this->load->database();
    }

    private function _get_datatables_query() {
        $this->db->from($this->table);


        $this->db->where(array('status' => 1));

        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        $this->db->where('status', 1);
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($sdate = "", $edate = "") {
        
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        if ($sdate != "") {
             $this->db->where('date >=', $sdate);
            
        }
        if ($edate != "") {
            $this->db->where('date <=', $edate);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($sdate = "", $edate = "") {
        $this->_get_datatables_query();
        
        if ($sdate != "") {
             $this->db->where('date >=', $sdate);
            
        }
        if ($edate != "") {
            $this->db->where('date <=', $edate);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($sdate = "", $edate = "") {
        $this->db->from($this->table);
       
        if ($sdate != "") {
             $this->db->where('date >=', $sdate);
            
        }
        if ($edate != "") {
            $this->db->where('date <=', $edate);
        }
        $this->db->where("status", "1");
        return $this->db->count_all_results();
    }

    function delete($id, $data,$date) {
//        $this->db->where('l_id', $id);
        if($date != ""){
           $this->db->where('date <=', date('Y-m-d', strtotime($date)));
        }
        $this->db->update('vat_list', $data);
    }

    function update($id, $data,$date) {
//        $this->db->where('id', $id);
//        print_r(date('Y-m-d', strtotime($date)));
        if($date != ""){
           $this->db->where('date >=', date('Y-m-d', strtotime($date)));
        }
        $this->db->update('vat_list', $data);
    }

}

?>