<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Historico extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
            redirect('login');
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('historicos_model','table');
             $this->load->library('Transform');
        $this->transform =  new Transform();
    }

     public function index()
    {
     
        $this->load->view('template/top_logged');
        $this->load->view('historicos_view');
        $this->load->view('template/footer_logged');
    }

        public function ajax_list(){

        $list = $this->table->get_datatables();
        $data = [];
        $no = $_POST['start'];
        foreach ($list as $item) {

            $no++;
            $row = array();
            $row[] = $this->transform->dateHourBr($item->cnl_registered);
            $row[] = $item->usr_login;
            $row[] = $item->cnl_action;
            $row[] = $item->cnl_info;
            $row[] = $item->cnl_agent;

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

   



   
}