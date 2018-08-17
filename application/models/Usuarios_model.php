<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Usuarios_model extends CI_Model {
    var $table = 'users';
    var $key = 'usr_id';
    var $column_order = array('usr_name','usr_login','usr_auth',null);
    var $column_search = array('usr_name','usr_login','usr_auth');
    var $order = array('usr_id' => 'desc');
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getColumns(){
        $valores = $this->column_search;
        array_push($valores,'usr_id','prj_id');
        return $valores;
    }
    private function _get_datatables_query()
    {
         $postFields = [
            'prj_id' => 'where',            
        ];
        foreach ($postFields as $key => $value) {
             if($this->input->post($key.'_filter')) {
                $this->db->$value($key, $this->input->post($key.'_filter'));
            }
        }

       
  

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
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where($this->key,$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getEmail($email){
        $this->db->from($this->table);
        $this->db->where('usr_login', $email);
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

    public function getTypehead(){
        $this->db->from($this->table);
        return $this->db->get()->result();   
    }

    public function getConfig(){
        $this->db->where('sys_id','1');
        $this->db->join('users', 'users.usr_id = systems.usr_id');
        return $this->db->get('systems')->row();
    }

    public function saveConfig($data){
        $this->db->where('sys_id','1');
        $this->db->update('systems', $data);
    }

    public function getFuel(){
        $this->db->where('sys_id',1);
       return  $this->db->get('systems')->row();
    }

    public function getUserByHash($hash){
        $this->db->where('usr_token', $hash);
        return $this->db->get('users')->row();
    }
}