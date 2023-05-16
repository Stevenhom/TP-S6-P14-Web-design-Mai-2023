<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SController extends CI_Controller{

    public function home(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');

        $data=$this->models->getData('contenu',['titre','picture','description']);
        $data['datas']=$data;
        $this->load->view('Front-Office/templates/template',$data);
    }
}

