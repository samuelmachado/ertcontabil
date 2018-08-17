<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Usuarios extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
            redirect('login');
        date_default_timezone_set('America/Sao_Paulo');
         $this->load->model('usuarios_model','usuarios');
                $this->load->model('projetos_model','projetos');

        $this->table = $this->usuarios;
  
    }
        public function projeto($prj_id){
            if($this->session->auth != 'admin')
                redirect('login/principal');

            $dados = [
                'projeto' => $this->projetos->getHash($prj_id),
            ];
            $this->load->view('template/top_logged');
            $this->load->view('usuarios_view', $dados);
            $this->load->view('template/footer_logged');

        }
        public function ajax_list(){

        $list = $this->table->get_datatables();
        $data = [];
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->usr_name;
            $row[] = $item->usr_login;
            $row[] = $item->usr_auth;
           
            $row[] = '
            <i class="fa fa-key fa-2x icon-btn" onclick=send_password("'.$item->usr_token.'")></i>&nbsp;&nbsp;
            <i class="fa fa-pencil-square-o fa-2x icon-btn" onclick="edit_register('.$item->usr_id.')"></i>&nbsp;&nbsp;
            <i class="fa fa-times fa-2x icon-btn" onclick="delete_register('.$item->usr_id.')"></i>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->table->count_all(),
            "recordsFiltered" => $this->table->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $requiredItems = ['usr_name', 'usr_login'];

        foreach ($requiredItems as $item) {
            if($this->input->post($item) == '') {
                $data['inputerror'][] = $item;
                $data['error_string'][] = 'Requerido';
                $data['status'] = FALSE;
            }
        }

        if($this->input->post('usr_login') != '' && !filter_var($this->input->post('usr_login'), FILTER_VALIDATE_EMAIL)) {
            $data['inputerror'][] = 'usr_login';
            $data['error_string'][] = 'Digte um E-mail válido.';
            $data['status'] = FALSE;
        } else {

             if($this->usuarios->getEmail( $this->input->post('usr_login') ) ) {
                $data['inputerror'][] = 'usr_login';
                $data['error_string'][] = 'Este email já foi utilizado em outro projeto';
                $data['status'] = FALSE;
            }
        }

        // if(($this->input->post('usr_password') != $this->input->post('usr_password2')) && $this->input->post('usr_password') !='' ) {
        //     $data['inputerror'][] = 'usr_password';
        //     $data['error_string'][] = 'As senhas não conferem.';
        //     $data['status'] = FALSE;
        // }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit(1);
        }
    }


    public function ajax_add()
    {
        $data = $this->input->post(NULL, TRUE);
        $this->_validate($data);
        
        unset($data['usr_id']);
        // unset($data['usr_password2']);
        // $data['usr_password'] = sha1(md5($data['usr_password']));
        $data['usr_token'] = md5(date('Y-m-d H:i:s').$this->session->usr_id.rand(1,100));
        $insert = $this->table->save($data);

        $this->newPassword( $data['usr_token'] );
     
        echo json_encode(array("status" => TRUE));
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

        return '<b>Sistema Operacional:</b> ' . $this->agent->platform() . ' <b>Navegador:</b>' . $agent;
    }

    public function ajax_edit($id)
    {
        $data = $this->table->get_by_id($id);
        $data->usr_password = '123456';
        $data->usr_password2 = '123456';
        echo json_encode(['data' => $data, 'fields' => $this->table->getColumns()]);

    }

     public function ajax_update()
    {

        $this->_validate();
        $data = $this->input->post(NULL, TRUE);
        

        $this->table->update(array('usr_id' => $this->input->post('usr_id')), $data);
        
       
        echo json_encode(array("status" => TRUE));
    }

       public function ajax_delete($id)
    {
        $this->table->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function generatePassUser($hash){
        $this->newPassword($hash);
        echo json_encode(array("status" => TRUE));
    }
    public function newPassword($hash){
        $user = $this->table->getUserByHash($hash);
        $this->load->model('send_email');
        $this->send_email->sendMailContact([
            'from' => 'naoresponda@sistema.visualmode.com.br',
            'from_name' => 'Sistema ERT Contábil',
            'to' => $user->usr_login,
            'subject' => $user->usr_name.', complete seu cadastro',
            'message' => 'Por gentileza, defina sua senha no portal ERT Contábil',
            'link' => site_url().'/novo/usuario/'.$hash,
        ]);
    }
}