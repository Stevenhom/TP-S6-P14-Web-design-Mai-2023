
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class TMEmbauche extends CI_Model
    {
        
        public function saveGrp($groupe){
            $sql = "INSERT INTO groupecsp(id, nom) VALUES(default,%s)";
            $sql = sprintf($sql,$this->db->escape($groupe));
            $this->db->query($sql);

        }

        public function saveCat($idGroupe , $code, $nom){
            $sql = "INSERT INTO CategorieCSP(id,idGroupeCSP,Code,nom) VALUES(default,%s,%s,%s)";
            $sql = sprintf($sql,$idGroupe,$this->db->escape($code),$this->db->escape($nom));
            $this->db->query($sql);  
        }

        public function getOptionGrp(){
            $sql = "SELECT * FROM groupecsp";
            $query = $this->db->query($sql);  
            $result = $query->result_array();
            return $result;
        }

        //////////////////////////////////////////////
        public function select($sql){
            $query = $this->db->query($sql);  
            $result = $query->result_array();
            return $result;
            
        }

        public function insert($sql){
            $query = $this->db->query($sql);  
            $result = $query->result_array();
            
        }
        /////////////////////////////////////////

        public function getCategorie($idCategorie){
            $sql = "SELECT * FROM categoriecsp WHERE idgroupecsp = ".$idCategorie;
            echo $sql;
            //$result = $this->select($sql);
            //return $result;
            $query = $this->db->query($sql);  
            $result = $query->result_array();
            /*foreach($result as $categorie){
                $categorie['id'] ;echo $categorie['nom'];
            }*/
            if($result == null){
                throw new Exception("you do not have categorie in this group");
            }
            return $result;

        }

        public function insertSM($idCategorie,$sme,$sma,$date){
            $sql = "INSERT INTO SMESMAParCatGrp(id, idCatCSP,SME,SMA,dateMAS) VALUES(default,$idCategorie,$sme,$sma,%s)";
            $sql = sprintf($sql,$this->db->escape($date));
            echo $sql;
           
            $this->db->query($sql);
        }

        public function getListGrpCat(){
            $sql = "SELECT * FROM v_groupCat";
            $query = $this->db->query($sql);  
            $result = $query->result_array();
            return $result;
        }
        // public function getListSalaire_old($idCategorie, $date){
        //     $sql = "SELECT * FROM v_salaire WHERE idcategorie = %s AND year = %s";
        //     echo $date;
        //     $date = DateTime::createFromFormat("Y-m-d", $date);
        //     $date = $date->format("Y");
        //     $sql = sprintf($sql, $idCategorie,$date);
        //     $query = $this->db->query($sql);  
        //     $result = $query->result_array();
        //     return $result;
        // }
        
        public function getListSalaire($idGroupe, $date){
            $sql = "SELECT * FROM v_salaire WHERE idGroupe = %s AND year = %s";
            $date = DateTime::createFromFormat("Y-m-d", $date);
            $date = $date->format("Y");
            $sql = sprintf($sql, $idGroupe,$date);
            //echo $sql;
            $query = $this->db->query($sql);  
            $result = $query->result_array();
            return $result;
        }



    }
?>