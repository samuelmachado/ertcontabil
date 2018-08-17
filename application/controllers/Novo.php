<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Novo extends CI_Controller {
	public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('usuarios_model','usuarios');
        $this->load->library('Transform');
        $this->transform =  new Transform();
  
    }
    
   
    public function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $requiredItems = ['con_category','con_telephone','con_email','con_cep','con_address','con_n','con_neighborhood','con_city','con_state'];

        foreach ($requiredItems as $item) {
            if($this->input->post($item) == '') {
                $data['inputerror'][] = $item;
                $data['error_string'][] = 'Requerido.';
                $data['status'] = FALSE;
            }
        }

        // if($this->input->post('con_bank') == ''){
        //     $data['inputerror'][] = 'con_bank';
        //     $data['error_string'][] = 'Requerido.';
        //     $data['status'] = FALSE;
        // }

        // if($this->input->post('con_accountType') == ''){
        //     $data['inputerror'][] = 'con_accountType';
        //     $data['error_string'][] = 'Requerido.';
        //     $data['status'] = FALSE;
        // }

        // if($this->input->post('con_agency') == ''){
        //     $data['inputerror'][] = 'con_agency';
        //     $data['error_string'][] = 'Requerido.';
        //     $data['status'] = FALSE;
        // }

        // if($this->input->post('con_account') == ''){
        //     $data['inputerror'][] = 'con_account';
        //     $data['error_string'][] = 'Requerido.';
        //     $data['status'] = FALSE;
        // }

        if($this->input->post('con_email') != '' && !filter_var($this->input->post('con_email'), FILTER_VALIDATE_EMAIL)) {
            $data['inputerror'][] = 'con_email';
            $data['error_string'][] = 'Digte um E-mail válido.';
            $data['status'] = FALSE;
        }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit(1);
        }
    }

    public function ajax_update()
    {

        $this->_validate();
        $data = $this->input->post(NULL, TRUE);

        $data['con_finished'] = 'sim'; 
        $beforeUpdate = $this->table->get_by_id($data['con_id']);
        $this->table->update(array('con_id' => $this->input->post('con_id')), $data);
        
        $logUpdate = '';
        foreach ($data as $key => $value) {
           if($data[$key] != $beforeUpdate->$key){
            if($key != '')
                $logUpdate .= '[Campo '.$key.' Antes: '.$beforeUpdate->$key.' | Depois: '.$value.' ';
           }
        }
      

        $this->clogs->save([
            'con_id' => $data['con_id'],
            'usr_id' => 0,
            'cnl_action' => 'Cliente/fornecedor realizou o preenchimento das demais informações',
            'cnl_agent' => $this->clogs->getAgent(),
            'cnl_ip' => $_SERVER['REMOTE_ADDR'],
            'cnl_info' => $logUpdate,
            'cnl_registered' => date('Y-m-d H:i:s') 
        ]);
        echo json_encode(array("status" => TRUE));
    }


    public function usuario($hash){
         $this->load->view('preenchimento_usuario_view', ['data' => $this->usuarios->getUserByHash($hash) ]);
    }

     public function saveUser(){
        $this->_validateUsuario();
        $data = $this->input->post(NULL, TRUE);
        unset($data['usr_password2']);

           $data['usr_password'] = sha1(md5($data['usr_password']));

        $this->usuarios->update(array('usr_id' => $this->input->post('usr_id')), $data);

        echo json_encode(array("status" => TRUE));

    }

     public function _validateUsuario()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $requiredItems = ['usr_password', 'usr_password2'];

        foreach ($requiredItems as $item) {
            if($this->input->post($item) == '') {
                $data['inputerror'][] = $item;
                $data['error_string'][] = 'Requerido';
                $data['status'] = FALSE;
            }
        }



        if(($this->input->post('usr_password') != $this->input->post('usr_password2')) && $this->input->post('usr_password') !='' ) {
            $data['inputerror'][] = 'usr_password';
            $data['error_string'][] = 'As senhas não conferem.';
            $data['status'] = FALSE;
        }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit(1);
        }
    }
}