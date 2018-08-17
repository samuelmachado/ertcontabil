<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Home extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
            redirect('login');
        date_default_timezone_set('America/Sao_Paulo');
        
    }
    //     public function __construct()
    // {
    //     parent::__construct();
    //     if(!$this->session->userdata('logged_in'))
    //         redirect('login');
    //     date_default_timezone_set('America/Sao_Paulo');
    //     $this->load->model('finalidades_model','finalidades');
    //     $this->load->model('log_finalidades_model','clogs');

    //      $this->columnKey = [
    //     'fia_name' => 'Nome',
    //     'fia_category' => 'Categoria',
    //     ];
    //     $this->table = $this->finalidades;
  
    // }

     public function index()
    {
        $this->load->view('template/top_logged');
        $this->load->view('finalidades_view');
        $this->load->view('template/footer_logged');
    }

        public function ajax_list(){

        $list = $this->table->get_datatables();
        $data = [];
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->fia_name;
            $row[] = $item->fia_category;
            $row[] = '             <i class="fa fa-pencil-square-o fa-2x icon-btn" onclick="edit_register('.$item->fia_id.')"></i>&nbsp;&nbsp;
             <i class="fa fa-history fa-2x icon-btn" onclick="log_register('.$item->fia_id.')"></i>&nbsp;&nbsp;
            <i class="fa fa-times fa-2x icon-btn" onclick="delete_register('.$item->fia_id.')"></i>';
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

        $requiredItems = ['fia_category','fia_name'];

        foreach ($requiredItems as $item) {
            if($this->input->post($item) == '') {
                $data['inputerror'][] = $item;
                $data['error_string'][] = 'Requerido';
                $data['status'] = FALSE;
            }
        }

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
        
        unset($data['fia_id']);

        $insert = $this->table->save($data);


        $logUpdate = '';
        foreach ($data as $key => $value) {
            $logUpdate .= $this->columnKey[$key].': '.$value.'&#13;';
        }
        $this->generateLog($insert,'Criação',$logUpdate);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $data = $this->table->get_by_id($id);
        echo json_encode(['data' => $data, 'fields' => $this->table->getColumns()]);

    }

     public function ajax_update()
    {

        $this->_validate();
        $data = $this->input->post(NULL, TRUE);
        $beforeUpdate = $this->table->get_by_id($data['fia_id']);
        $this->table->update(array('fia_id' => $this->input->post('fia_id')), $data);
        
        $logUpdate = '';
        
         foreach ($data as $key => $value) {
           if($data[$key] != $beforeUpdate->$key){
            if($key != '')
                $logUpdate .= $this->columnKey[$key].': '.$beforeUpdate->$key.'|'.$value.'&#13;';
           }
        }
        $this->generateLog($data['fia_id'],'Edição',$logUpdate);
        echo json_encode(array("status" => TRUE));
    }

       public function ajax_delete($id)
    {
        $this->generateLog($id,'Remoção','');
        $this->table->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

  public function changeTitle($arq_id,$description){
        $description = urldecode($description);
        if(!$this->session->userdata('logged_in'))
            redirect('login');
                $this->load->model('arquivos_model', 'arquivos');
        $this->arquivos->titleUpdate($arq_id,$description);
        print json_encode(['status' => 'ok']);
        //$this->lesson->audioTitleUpdate($aud_id,$title);
    }

}