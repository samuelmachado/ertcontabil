<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Projetos extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
            redirect('login');
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('projetos_model','table');
     
    }

     public function index()
    {
        if($this->session->auth != 'admin')
            redirect('login/principal');

        $this->load->view('template/top_logged');
        $this->load->view('projetos_view');
        $this->load->view('template/footer_logged');
    }

        public function ajax_list(){

        $list = $this->table->get_datatables();
        $data = [];
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->prj_name;
            $row[] = '
             <a href="'.site_url('pastas/projeto/').md5($item->prj_id).'"><i class="fa fa-folder fa-2x icon-btn"></i></a>&nbsp;&nbsp;
             <a href="'.site_url('usuarios/projeto/').md5($item->prj_id).'"><i class="fa fa-group fa-2x icon-btn"></i></a>&nbsp;&nbsp;
            <i class="fa fa-pencil-square-o fa-2x icon-btn" onclick="edit_register('.$item->prj_id.')"></i>&nbsp;&nbsp;
            <i class="fa fa-times fa-2x icon-btn" onclick="delete_register('.$item->prj_id.')"></i>';
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

        $requiredItems = ['prj_name'];

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
        unset($data['prj_id']);
        $insert = $this->table->save($data);     
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
        $this->table->update(array('prj_id' => $this->input->post('prj_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

       public function ajax_delete($id)
    {
        $this->table->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function getAll(){
    $type = $this->input->post('type');
    $out = $this->finalidades->getAll($type);
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($out));
    }

   
}