<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SController extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function login(){
        $this->load->view('Back-Office/login');
    }    

    public function authentification(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');
        $this->load->library('session');
		
        $name = $this->input->post('username');
        $pass = $this->input->post('password');
        
        if ($this->models->isAdmin($name, $pass) == true) 
        {
            $user_id = $this->models->get_userid($name, $pass);
            $this->session->set_userdata('user_id', $user_id);
            $this->session->set_userdata('name', $name);
            $this->session->set_userdata('pass', $pass);
            $user=$this->models->get_userdata($user_id);
            $user['admin']= $user;
            //site_url('votre-page?name='.$name);
            $this->load->view('Back-Office/templates/template', $user);  
        }
        else
        {
            $this->session->set_flashdata('error', 'Erreur de connexion !');
            redirect(site_url('Back-Office/SController/login').'?error=Erreur de connexion !');
        }
    }

    public function home(){
        $this->load->library('session');
        $this->load->model('models');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $user['admin']= $user;
        $this->load->view('Back-Office/templates/template', $user);
    }

    public function form(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $user['admin']= $user;
        $data=$this->models->getData('contenu',['idcontent','titre','picture','description']);
        $user['datas']=$data;
        $this->session->flashdata('success', 'Insertion réussie');
        //$this->session->set_flashdata('success2', 'Suppression réussi');
        $this->load->view('Back-Office/templates/template-form', $user);
    }

    public function form_perso(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $user['admin']= $user;
        $data=$this->models->getData('personality',['idperso','name','nationality','age','poste','innovation','picture']);
        $user['datas']=$data;
        $this->session->flashdata('success', 'Insertion réussie');
        //$this->session->set_flashdata('success2', 'Suppression réussi');
        $this->load->view('Back-Office/templates/template-form-perso', $user);
    }

    public function delete(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $user['admin']= $user;
        $idcontent=$this->input->get('idcontent');
        $data= $this->models->getDataConditionated2('contenu',['titre','picture','description'],['idcontent'],[$idcontent]);
        $datas= $data;
        for ($i=0; $i < sizeof($datas); $i++) {
            $data2= $this->models->insert('deleted',['titre','picture','description'],[$datas[$i]['titre'],$datas[$i]['picture'],$datas[$i]['description']]);
            $data3= $this->models->delete('contenu',['idcontent'],[$idcontent]);
            //$this->session->set_flashdata('success2', 'Suppression réussi');
            redirect(site_url('Back-Office/SController/form'));
        }
        

    }

    public function update(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $user['admin']= $user;
        $idcontent=$this->input->get('idcontent');
        $data= $this->models->getDataConditionated2('contenu',['idcontent','titre','picture','description'],['idcontent'],[$idcontent]);
        $user['datas']= $data;
        $this->load->view('Back-Office/templates/template-form-update', $user); 

    }

    public function form_trait(){
        $this->load->model('models');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $user['admin']= $user;
        $data=$this->models->getData('contenu',['idcontent','titre','picture','description']);
        $user['datas']=$data;
        
        $titre= $this->input->post('titre');
        $image= $this->input->post('image');
        $description= $this->input->post('description');

        $config=[
            'upload_path'=>'./assets/img/',
            'allowed_types'=>'gif|jpg|png|jpeg'
        ];
        //$config['upload_path'] = './assets/img/'; // dossier où l'image sera stockée
        //$config['allowed_types'] = 'gif|jpg|png|jpeg'; // types de fichiers autorisés
        $this->upload->initialize($config);
        
        /*if ($this->upload->do_upload($image)) {
            // Récupération du nom de fichier de l'image téléversée
            $image = $this->upload->data($image);
        
            // Insertion des données dans la base de données
            $insert = $this->models->insert('contenu',['titre','picture','description'],[$titre,$image,$description]);
            
        
            // Redirection vers la page de formulaire avec un message de succès
            $this->session->set_flashdata('success', 'Insertion réussie');
            redirect('Back-Office/SController/form');
        } else {
            // Affichage des erreurs de téléversement si nécessaire
            //$errors = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Erreur de connexion !');
            // Affichage du formulaire avec les erreurs
            $this->load->view('Back-Office/templates/template-form');
        }*/
        $this->load->library('upload',$config);
        if (!$this->upload->do_upload('image')) {
            //echo 'ato ei';
            /*$filename=$_FILES['image']['name'];
            $ext=pathinfo($filename,PATHINFO_EXTENSION);
            echo $ext;
            echo $this->upload->display_errors();*/
            redirect(site_url('Back-Office/SController/form'));
        }
        else{
            //echo $name;
            $data=$this->upload->data();
            $name=$data['file_name'];
            $insert= $this->models->insert('contenu',['titre','picture','description'],[$titre,$name,$description]);
            $this->session->set_flashdata('success', 'Insertion réussi');
            $this->load->view('Back-Office/templates/template-form', $user);           
        }
        //$this->upload->data('file_name');
        //echo $image;
        

    }

    public function form_trait_perso(){
        $this->load->model('models');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $user['admin']= $user;
        $data=$this->models->getData('personality',['idperso','name','nationality','age','poste','innovation','picture']);
        $user['datas']=$data;
        
        $nom= $this->input->post('name');
        $nationality= $this->input->post('nationality');
        $age= $this->input->post('age');
        $poste =$this->input->post('poste');
        $innovation= $this->input->post('innovation');
        $image= $this->input->post('image');

        $config=[
            'upload_path'=>'./assets/img/',
            'allowed_types'=>'gif|jpg|png|jpeg'
        ];
        //$config['upload_path'] = './assets/img/'; // dossier où l'image sera stockée
        //$config['allowed_types'] = 'gif|jpg|png|jpeg'; // types de fichiers autorisés
        $this->upload->initialize($config);
        
        /*if ($this->upload->do_upload($image)) {
            // Récupération du nom de fichier de l'image téléversée
            $image = $this->upload->data($image);
        
            // Insertion des données dans la base de données
            $insert = $this->models->insert('contenu',['titre','picture','description'],[$titre,$image,$description]);
            
        
            // Redirection vers la page de formulaire avec un message de succès
            $this->session->set_flashdata('success', 'Insertion réussie');
            redirect('Back-Office/SController/form');
        } else {
            // Affichage des erreurs de téléversement si nécessaire
            //$errors = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Erreur de connexion !');
            // Affichage du formulaire avec les erreurs
            $this->load->view('Back-Office/templates/template-form');
        }*/
        $this->load->library('upload',$config);
        if (!$this->upload->do_upload('image')) {
            //echo 'ato ei';
            $filename=$_FILES['image']['name'];
            $ext=pathinfo($filename,PATHINFO_EXTENSION);
            echo $ext;
            echo $this->upload->display_errors();
            //redirect(site_url('Back-Office/SController/form'));
        }
        else{
            //echo $name;
            $data=$this->upload->data();
            $name=$data['file_name'];
            $insert= $this->models->insert('personality',['name','nationality','age','poste','innovation','picture'],[$nom,$nationality,$age,$poste,$innovation,$name]);
            //$this->session->set_flashdata('success', 'Insertion réussi');
            //$this->load->view('Back-Office/templates/template-form-perso', $user);           
        }
        //$this->upload->data('file_name');
        //echo $image;
        

    }

    public function form_trait_update(){
        $this->load->model('models');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $name = $this->session->userdata('name');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_userid($name, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_userdata($user_id);
        $idcontent=$this->input->get('idcontent');
        $user['admin']= $user;
        $data=$this->models->getData('contenu',['titre','picture','description']);
        $user['datas']=$data;
        
        $titre= $this->input->post('titre');
        $image= $this->input->post('image');
        $description= $this->input->post('description');

        $config=[
            'upload_path'=>'./assets/img/',
            'allowed_types'=>'gif|jpg|png|jpeg'
        ];
        //$config['upload_path'] = './assets/img/'; // dossier où l'image sera stockée
        //$config['allowed_types'] = 'gif|jpg|png|jpeg'; // types de fichiers autorisés
        $this->upload->initialize($config);
        
        /*if ($this->upload->do_upload($image)) {
            // Récupération du nom de fichier de l'image téléversée
            $image = $this->upload->data($image);
        
            // Insertion des données dans la base de données
            $insert = $this->models->insert('contenu',['titre','picture','description'],[$titre,$image,$description]);
            
        
            // Redirection vers la page de formulaire avec un message de succès
            $this->session->set_flashdata('success', 'Insertion réussie');
            redirect('Back-Office/SController/form');
        } else {
            // Affichage des erreurs de téléversement si nécessaire
            //$errors = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Erreur de connexion !');
            // Affichage du formulaire avec les erreurs
            $this->load->view('Back-Office/templates/template-form');
        }*/
        $this->load->library('upload',$config);
        if (!$this->upload->do_upload('image')) {
            //echo 'ato ei';
            /*$filename=$_FILES['image']['name'];
            $ext=pathinfo($filename,PATHINFO_EXTENSION);
            echo $ext;
            echo $this->upload->display_errors();*/
            redirect(site_url('Back-Office/SController/form'));
        }
        else{
            //echo $name;
            $data=$this->upload->data();
            $name=$data['file_name'];
            $update= $this->models->update('contenu',['titre','picture','description'],[$titre,$name,$description],['idcontent'],[$idcontent]);
            //$this->session->set_flashdata('success', 'réussi');
            $this->load->view('Back-Office/templates/template', $user);           
        }
        //$this->upload->data('file_name');
        //echo $image;
        

    }

    public function deconnexion(){
        $this->session->sess_destroy();

        // Rediriger vers la page de connexion
        redirect('Welcome/index');
    }

}

