<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pastas extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
            redirect('login');
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('pastas_model','table');
        if(ENVIRONMENT == 'development'){
            $this->serverPath = $_SERVER['DOCUMENT_ROOT'].'/ertcontabil/';
        } else {
            $this->serverPath = $_SERVER['DOCUMENT_ROOT'];
        }
        $this->load->library('Transform');
        $this->transform =  new Transform();
        $this->load->model('arquivos_model', 'arquivos');

    }

     public function projeto($prj_id)
    {	
		$this->load->model('Projetos_model','projetos');

    	$dados = ['projeto' =>  $this->projetos->getHash($prj_id), ];
        $this->load->view('template/top_logged');
        $this->load->view('pastas_view', $dados);
        $this->load->view('template/footer_logged');
    }

     public function arquivos($fol_hash)
    {   
        $this->load->model('Projetos_model','projetos');

        $dados = [
            'projeto' => $this->table->getHash($fol_hash),
            'fol_hash' => $fol_hash
        ];

        $this->load->view('template/top_logged');
        $this->load->view('arquivos', $dados);
        $this->load->view('template/footer_logged');
    }

        public function ajax_list(){

        $list = $this->table->get_datatables();
        $data = [];
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->fol_name;
            $btn = '<a href="'.site_url('pastas/arquivos/').$item->fol_hash.'"><i class="fa fa-folder fa-2x icon-btn"></i></a>&nbsp;&nbsp;';
            
            if($this->session->auth == 'admin'){
            
            $btn .= '<i class="fa fa-pencil-square-o fa-2x icon-btn" onclick="edit_register('.$item->fol_id.')"></i>&nbsp;&nbsp;
                     <i class="fa fa-times fa-2x icon-btn" onclick="delete_register('.$item->fol_id.')"></i>';
            }
            
            $row[] = $btn;
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

    public function getFiles($fol_hash){
        if(!$this->session->userdata('logged_in'))
            redirect('login');

        $data = $this->arquivos->getFiles($fol_hash);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }



    public function deleteArquivo($arq_hash){
        $arquivo = $this->arquivos->getFile($arq_hash);
        $this->arquivos->deleteFile($arq_hash);
        redirect('pastas/arquivos/'.$arquivo->fol_hash);
    }

    public function fileUpload($fol_hash, $fol_id)
    {

        if (!$this->session->userdata('logged_in'))
            redirect('login');
        ini_set('upload_max_filesize', '100M');


        $folder = $fol_hash;
        $storeFolder = $this->serverPath.'assets/u/' . $folder . '/';   //2
        print $storeFolder;
        if (!file_exists($storeFolder)) {
            mkdir($storeFolder, 0777, true);
            $myfile = fopen($storeFolder . "index.html", "w");
            fwrite($myfile, "not allowed");
            fclose($myfile);
        }

        //print  $storeFolder;

        if (!empty($_FILES)) {

            $filename = $_FILES["file"]["name"];
            $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
            $file_ext = substr($filename, strripos($filename, '.')); // get file name

            $tempFile = $_FILES['file']['tmp_name'];          //3

            $targetPath = $storeFolder;  //4
            //$newfilename = $file_basename.'_f'.md5($file_basename.rand(1,100)) . $file_ext;
            $newfilename = url_title( $this->transform->clearString($file_basename) ) . $file_ext;
            $targetFile = $targetPath . $_FILES['file']['name'];  //5
          
            move_uploaded_file($tempFile, $targetPath . $newfilename); //6
            $dados = [
                'fol_date' => date('Y-m-d'),
                'arq_friendlyname' => $_FILES['file']['name'],
                'arq_name' => $newfilename,
                'arq_path' => base_url('assets/u/' . $folder . '/' . $newfilename),
                'fol_hash' => $fol_hash,
                'fol_id' => $fol_id,
                'arq_hash' => md5($fol_hash.$fol_id.date('Y-m-d H:i:s'))
            ];
            $this->arquivos->storeFile($dados);
        }
    }
    
    public function forceDownloadArquivo($arq_hash){
        if(!$this->session->userdata('logged_in'))
            redirect('login');

        $arquivo = $this->arquivos->getFile($arq_hash);
        $path = $this->serverPath.'assets/u/'.$arquivo->fol_hash.'/'.$arquivo->arq_name;
        $name = $arquivo->arq_name;
        if(is_file($path)) {
            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }
            $this->load->helper('file');
            $mime = get_mime_by_extension($path);
            header('Pragma: public');     // required
            header('Expires: 0');         // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
            header('Cache-Control: private', false);
            header('Content-Type: ' . $mime);
            header('Content-Disposition: attachment; filename="' . basename($name) . '"');  // Add the file name
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($path));
            header('Connection: close');
            readfile($path);
            echo '<script>window.close();</script>';
        }
    }




     public function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $requiredItems = ['fol_name'];

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
        
        unset($data['fol_id']);
        $data['fol_hash'] = sha1(date('Y-m-d H:i:s').rand(1,100).rand(1,10));
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
        $this->table->update(array('fol_id' => $this->input->post('fol_id')), $data);
        
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