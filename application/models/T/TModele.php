
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class TModele extends CI_Model
    {
        public function countSubcribed($idannonce){
            $sql = "SELECT count(idcandidat) FROM annonceCandidat WHERE idannonce=%s";
            $sql = sprintf($sql, $idannonce);
            $query = $this->db->query($sql);
            $result = $query->row_array();
            return $result['count'];
        }

        public function getAnnouncement(){
            $sql = "SELECT * FROM v_annonce WHERE datefin>=now() AND datedebut<=now()";
            $query = $this->db->query($sql);
            return $query->result_array(); 
                        
        }

        public function getDetails($idannonce){
            $sql = "SELECT * FROM annonce WHERE id = %s";
            $sql = sprintf($sql,$idannonce);
            $query = $this->db->query($sql);
            return $query->result_array(); 
        }

        //TODO if value = null
        public function getIntervaleScore($idannonce, $matiere, $inputval){
            $sql = "SELECT * FROM v_note WHERE idannonce=%s AND nom_matiere=%s"; //could be changed to id
            $sql = sprintf($sql,$this->db->escape($idannonce), $this->db->escape($matiere));
            //echo '</br> debugging getIntervaleScore'.$sql;
            $query = $this->db->query($sql);
            $tranche = [];
            foreach($query->result_array() as $row)
            {
                $tranche[] = $row['contrainte'];
                $noteTranche[] = $row['note'];                
            }
            for($i=0; $i<count($tranche); $i++)
            {
                $array = explode('-',$tranche[$i]);
                if($inputval>= intval($array[0]) && $inputval < intval($array[1]))
                {
                    return $noteTranche[$i];
                }

            }
            return 0;        
        }

        //TODO if value = null
        public function getExactScore($idannonce, $nomMatiere, $inputval)
        {
            $sql = "SELECT * FROM v_note WHERE idannonce=%s AND nom_matiere=%s"; //could be changed to id
            $sqlcount = "SELECT COUNT(contrainte),note FROM v_note WHERE idannonce=%s AND nom_matiere=%s group by note"; 
            $sql = sprintf($sql,$this->db->escape($idannonce),$this->db->escape($nomMatiere));
            echo $sql;
            echo 'Hello';
            $sqlcount = sprintf($sqlcount,$this->db->escape($idannonce),$this->db->escape($nomMatiere));
            $query = $this->db->query($sql);
            $countquery = $this->db->query($sqlcount);    
            $countresultrow = $countquery->row_array();
            $count = $countresultrow['count'];
            //echo '</br> debugging getExactScore '.$sql;  
            foreach($query->result_array() as $row)
            {
                $contrainteList[] = $row['contrainte'];
                $noteContrainte[] = $row['note'];               
            }     
            if($count>0){
                
                for($i=0; $i<count($contrainteList); $i++)
                {
                    if($contrainteList[$i]==$inputval)
                    {
                        return $noteContrainte[$i];
                    }
                }
            }
            else{
                return $countresultrow['note'];;
            }
            
        }

        public function getScoreAge($idannonce, $inputAge){
            //echo $inputAge.' Age score '.$this->getIntervaleScore($idannonce,"Age",$inputAge);
            return $this->getIntervaleScore($idannonce,"Age",$inputAge);
        }

        public function getScoreDegree($idannonce, $inputDegree){
            //echo $inputDegree.' Diplome score '.$this->getExactScore($idannonce,"Diplome",$inputDegree);
            return $this->getExactScore($idannonce,"Diplome",$inputDegree);
        }

        public function getScoreExp($idannonce, $inputExp)
        {
            //echo $inputExp." Exp Score ".$this->getIntervaleScore($idannonce, "Experience", $inputExp);;
            return $this->getIntervaleScore($idannonce, "Experience", $inputExp);

        }
        public function getScoreSexe($idannonce, $inputSexe)
        {
            //echo $inputSexe." Genre Score ".$this->getExactScore($idannonce,"Genre", $inputSexe);
            return $this->getExactScore($idannonce,"Genre", $inputSexe);
        }

        public function getScoreSitJur($idannonce, $inputSitJur)
        {
            //echo $inputSitJur." SitJur score ".$this->getExactScore($idannonce,"SitJur", $inputSitJur);
            return $this->getExactScore($idannonce,"SitJur", $inputSitJur);
        }

        public function getCoeff($idannonce,$matiere)
        {
            $sql = "SELECT DISTINCT idmatiere, nom_matiere, coeff  FROM v_note WHERE idannonce = %s AND nom_matiere = %s";
            $sqlcount = "SELECT count(idmatiere) from v_note where idannonce=%s AND nom_matiere = %s"; 
            $sql = sprintf($sql, $this->db->escape($idannonce), $this->db->escape($matiere));
            $sqlcount = sprintf($sqlcount, $this->db->escape($idannonce), $this->db->escape($matiere));
            //echo '</br>getCoeff :'.$sql;
            $querycount = $this->db->query($sqlcount);
            $count = $querycount->row_array();
            if($count['count']>0){
                $query = $this->db->query($sql);
                $result = $query->row_array();
                return $result['coeff'];
            }
            else{
                return 1;
            }
           
    
            
        }

        public function calculAvg($metier, $profile)
        {
            $totalNote = 0;
            $totalCoeff = 0;
            $total = 0;
    
            
            $ageCoeff = $this->getCoeff($metier, "Age"); //echo 'Age '.$ageCoeff.'</br>';
            $degreeCoeff = $this->getCoeff($metier, "Diplome"); //echo 'diplome '.$degreeCoeff.'</br>';
            $experienceCoeff = $this->getCoeff($metier, "Experience"); //echo 'exp '.$experienceCoeff.'</br>';
            $sexeCoeff = $this->getCoeff($metier, "Genre"); //echo 'genre '.$sexeCoeff.'</br>';
            $sitJurCoeff = $this->getCoeff($metier, "SitJur"); //echo 'sit '.$sitJurCoeff.'</br>';
            $totalCoeff = $ageCoeff+$degreeCoeff+$experienceCoeff+$sexeCoeff+$sitJurCoeff; //echo 'totalcoeff '.$totalCoeff;
    
            $ageNote = $ageCoeff * $this->getScoreAge($metier,$profile['age']); //echo $ageNote.'</br>';
            $degreeNote = $degreeCoeff * $this->getScoreDegree($metier,$profile['degree']); //echo $degreeNote.'</br>';
            $experienceNote = $experienceCoeff * $this->getScoreExp($metier,$profile['experience']); //echo $experienceNote.'</br>';
            $sexeNote = $sexeCoeff * $this->getScoreSexe($metier,$profile['sexe']); //echo $sexeNote.'</br>';
            $sitJurNote = $sitJurCoeff * $this->getScoreSitJur($metier,$profile['sitJur']); //echo $sitJurNote.'</br>';
    
            $totalNote = $ageNote+$degreeNote+$experienceNote+$sexeNote+$sitJurNote;
            //echo '</br> totalnote'.$totalNote.'</br>';
            
             
            $total = $totalNote/$totalCoeff;
    
            return $total;
        }

        public function getID($tel)
        {
            $sql = "SELECT id FROM candidat WHERE tel = %s";
            $sql = sprintf($sql, $this->db->escape($tel));
            $query = $this->db->query($sql);
            //echo '</br> debbuging getid():'.$sql;
            $result = $query->row_array();
            //echo '</br> getting id.... :'. $result['id']; 
            return $result['id']; 

        }

        public function getAge($then) {
            $then_ts = strtotime($then);
            $then_year = date('Y', $then_ts);
            $age = date('Y') - $then_year;
            //if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
            //echo $age;
            return $age;
        }

        

        public function save($profile, $idAnnonce)
        {
            echo 'idannonce :'.$idAnnonce.'<br/>';
            $nbrEnfant = $profile['nbrEnf']; //echo $nbrEnfant.'</br>';
            $nom = $profile['nom']; //echo $nom.'</br>';
            $prenom = $profile['prenom']; //var_dump($prenom); //echo '</br>';
            $dateN = $profile['dateN']; //echo $dateN.'</br>';
            $pere = $profile['pere']; //echo $pere.'</br>';
            $mere = $profile['mere']; //echo $mere.'</br>';
            $sexe = $profile['sexe']; //echo $sexe.'</br>';
            $degree = $profile['degree']; ////echo .'</br>';
            $experience = $profile['experience'];// echo .'</br>';
            $affl = '';
            if(isset($profile['affl']))
            {
                $affl = $profile['affl']; ///echo .'</br>';

            }
            else
            {
                $affl = 'no affiliation';
            }
            $tel = $profile['tel']; //echo .'</br>';
            $sitJur = $profile['sitJur'];// echo .'</br>';
            $identifiant = $profile['identifiant'];
            $sql = "INSERT INTO candidat (id,identifiant,nom,prenom,datenaissance,nompere,nommere,nbrdenfant,tel,genre,diplome,experience,situat_juridique) VALUES (default,%s, %s, %s, %s, %s ,%s, $nbrEnfant, $tel, %s,%s,%s,$sitJur)";
            $sql = sprintf($sql,
            $this->db->escape($identifiant),
            $this->db->escape($nom),
            $this->db->escape($prenom),
            $this->db->escape($dateN),
            $this->db->escape($pere),
            $this->db->escape($mere),
            $this->db->escape($sexe),
            $this->db->escape($degree),
            $this->db->escape($experience),
            $this->db->escape($affl));
          
            //echo $sql;
            $this->db->query($sql);
            $profile['age'] = $this->getAge($dateN);
            $age = $profile['age'];
            //echo '</br> you are '.$profile['age'];
            //echo '</br> you have '.$this->getScoreAge($idAnnonce,$age);
            $newID = $this->getID($tel);
            $note = $this->calculAvg($idAnnonce,$profile);

            $sql = "INSERT INTO annoncecandidat(id,idcandidat,idannonce,note) VALUES (default,%s,%s,%s)";
            $sql = sprintf($sql, $newID,$idAnnonce,$note);
            //echo '</br>'.$sql;
            $this->db->query($sql);
            //echo 'INSERTED';
        }

        



        
    }
?>