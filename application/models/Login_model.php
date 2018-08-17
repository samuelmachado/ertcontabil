<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Login_model extends CI_Model {
 
    var $table = 'users';
   
 
    public function __construct()
    {
        parent::__construct();
    }

    public function checkAuth($data){
        $this->db->from($this->table);
        $this->db->where('usr_login',$data['login']);
        $this->db->where('usr_password',sha1(md5($data['senha'])));
        return $this->db->get()->row();
    }
 
 
}