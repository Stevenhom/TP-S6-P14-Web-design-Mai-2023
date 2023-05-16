<?php 
    if(! defined('BASEPATH')) exit ('No direct script access allowed');

    class CI_Hmodel extends CI_Model{
        public function __construct() {

            parent::__construct();
            
        }

        function checkIfExist($qlq, $table) {
            $sql = "select * from $table where 1=1 ";
            foreach($qlq as $champ => $val) {
                $sql .= "and $champ='$val' ";                

            }

            $query = $this->db->query($sql);
            if(!@$query) {
                $error = $this->db->error();
                echo $error['message'];
                return;
            }
            if(count($query->result_array()) != 0)
                return $query->result_array();
            
            return 0;      
        }

        function getRecap($idAnnonce) {
            $sql = "select Metier.nom metier,Annonce.id,Matiere.id idmat,Matiere.nom matiere,Contrainte,Coeff,Note from CoefficientNote join Annonce on CoefficientNote.idAnnonce = Annonce.id join Metier on Annonce.idmetier = Metier.id join Matiere on CoefficientNote.idMatiere = Matiere.id where Annonce.id=$idAnnonce order by Matiere.id";
            
            $query = $this->db->query($sql);

            return $query->result_array();
        }

        function getNoteTestVF($idannonce,$idcandidat) {
            $this->load->model('CI_import_export');
            $datasQuest = $this->CI_import_export->getCsvData('assets/questions/question'.$idannonce.'.csv');
            $dataAns = $this->getAnswer($idannonce,$idcandidat);
            //$dataAns = $this->CI_import_export->getRepfromCSV('assets/reponses/'.$idannonce.'/reponse'.$idcandidat.'.csv');
            /*echo '<pre>';
            print_r($dataAns);
            echo '</pre>';
            echo '<pre>';
            print_r($datasQuest);
            echo '</pre>';*/

            $points = 0;
            $indiceCorrect = [];
            //echo count($datasQuest['question']).'<br/>'.$idannonce;
            /*echo '<pre>';
            print_r($datasQuest);
            echo '</pre>';*/
            for($i=0;$i<count($datasQuest['question']);$i++)
                $indiceCorrect[$i]=0;

            for($i = 0; $i<count($dataAns['reponse']); $i++) {
                if($datasQuest['reponse'][$i] == $dataAns['reponse'][$i]) {
                    $points += $datasQuest['point'][$i];
                    $indiceCorrect[$i]=1;
                }
            }
            $details['point'] = $points;
            $details['correct'] = $indiceCorrect;
            return $details;
        }

        function getAnswer($idannonce,$idcandidat) {
            $this->load->model('CI_import_export');
            $dataAns = $this->CI_import_export->getRepfromCSV('assets/reponses/'.$idannonce.'/reponse'.$idcandidat.'.csv');

            return $dataAns;
        }
    }