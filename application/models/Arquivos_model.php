<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Arquivos_model extends CI_Model {
    var $table = 'arquivos';
    var $key = 'arq_id';
  
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getFiles($fol_hash){
        return $this->db->where('fol_hash', $fol_hash)->get($this->table)->result();
    }

    public function getFile($arq_hash){
        return $this->db->where('arq_hash', $arq_hash)->get($this->table)->row();
    }


    public function storeFile($data){
    	$this->db->insert($this->table,$data);
    }

    public function deleteFile($arq_hash){
        $this->db->where('arq_hash', $arq_hash)->delete($this->table);
    }

    public function titleUpdate($arq_id, $desc){
        $this->db->where('arq_id', $arq_id)->update($this->table, ['arq_description' => $desc]);
    }

    public function storeLog($data){
        $this->db->insert('arquivos_logs',$data);
    }
    public function getAgent(){
        $this->load->library('user_agent');

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        return $this->agent->platform() . '/' . $agent;
    }

}