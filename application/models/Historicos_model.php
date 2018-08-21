<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Historicos_model extends CI_Model {
    var $table = 'arquivos_logs';
    var $key = 'cnl_id';
    var $column_order = array('cnl_registered','usr_login','cnl_action','cnl_info','cnl_agent',null);
    var $column_search = array('cnl_registered','usr_login','cnl_action','cnl_info','cnl_agent');
    var $order = array('cnl_id' => 'DESC');
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getColumns(){
        $valores = $this->column_search;
        // array_push($valores,'prj_id');
        return $valores;
    }
    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item)  
        {
            if($_POST['search']['value']) 
            {
                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }

            $i++;
        }
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }  else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        $this->prepareQuery();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $this->prepareQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->prepareQuery();
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where($this->key,$id);
        $query = $this->db->get();
        return $query->row();
    }
  
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
 

    private function prepareQuery(){
        $this->db->join('users', 'arquivos_logs.usr_id = users.usr_id');
    }

}
//2018907150226 