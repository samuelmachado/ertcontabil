<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Login extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model','login');
        date_default_timezone_set('America/Sao_Paulo');

    }
    
    public function index()
    {
        $this->load->view('login_view');
    }

    public function sair(){
        $this->session->sess_destroy();
        redirect('login','refresh');
    }
    
    public function process(){
        $response = $this->login->checkAuth( $this->input->post(NULL, TRUE) );
        if($response){
            $this->setSessionUser($response);
            if($response->usr_auth == 'admin'){
                return print json_encode(['status' => 'success', 'redirect' => site_url('projetos')]);
            } else {
                $link = 'pastas/projeto/'.md5($response->prj_id);
                return print json_encode(['status' => 'success', 'redirect' => site_url($link)]);
            }
        } else {
            return print json_encode(['status' => 'erro']);
        }
    }

      private function setSessionUser($response){
        $this->session->set_userdata([
            'logged_in' => true,
            'auth' => $response->usr_auth,
            'usr_id' => $response->usr_id,
        ]);
    }

     public function principal(){
         $this->load->model('usuarios_model','usuarios');

        $response = $this->usuarios->get_by_id($this->session->usr_id);
        $link = 'pastas/projeto/'.md5($response->prj_id);
        redirect($link);
    }
}