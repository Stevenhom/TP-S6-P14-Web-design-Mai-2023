
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Models extends CI_Model
    {
        public function isLogable($nom, $motdepasse)
        {
            if($nom ==''||$motdepasse=='')
            {
                return false;
            }
            return true;
        }
        public function isAdmins($nom, $motdepasse)
        {
            if($this->getDataConditionated('admins', ['nom', 'mdp'], ['nom', 'mdp'], [$nom, $motdepasse]))
            {
                return true;
            }
            return false;
        }

        public function getData($tableName, $columnsName)
        {
            $query = "select ";
            for ($i=0; $i < sizeof($columnsName) - 1; $i++) 
            {
                $query = $query.$columnsName[$i].", ";
            }
            $query = $query.$columnsName[sizeof($columnsName) - 1]." ";
            $query = $query."from ".$tableName." order by nom;"; 
            return $this->db->query($query)->result_array();
        }

        public function getDataConditionated($tableName, $columnsName, $columnsConditionated, $valuesConditionated)
        {
            $query = "select ";
            for ($i=0; $i < sizeof($columnsName) - 1; $i++) 
            {
                $query = $query.$columnsName[$i].", ";
            }
            $query = $query.$columnsName[sizeof($columnsName) - 1]." ";
            $query = $query."from ".$tableName." where "; 
            for ($i=0; $i < sizeof($columnsConditionated) - 1; $i++) 
            {   
                $query = $query.$columnsConditionated[$i]." like '". $valuesConditionated[$i]."%' and ";
            }
            if($columnsConditionated[sizeof($columnsConditionated) - 1]=='experience'){
                $query = $query.$columnsConditionated[sizeof($columnsConditionated) - 1]." >= '". $valuesConditionated[sizeof($columnsConditionated) - 1]."' order by nom;";    
            }
            else{
                $query = $query.$columnsConditionated[sizeof($columnsConditionated) - 1]." like '". $valuesConditionated[sizeof($columnsConditionated) - 1]."%' order by nom;";    
            }
            
            return $this->db->query($query)->result_array();        
        }

        public function ListEmp($departement){
            if($departement!=null){
                $query='select Candidat.id, candidat.nom, candidat.prenom, (Departement.nom)dept from candidat join EmployeeCandidat on candidat.id=EmployeeCandidat.idEmployee join ContratEmployee on ContratEmployee.idEmployee=EmployeeCandidat.idEmployee join Departement on Departement.id=ContratEmployee.idDep where Departement.id=';
                $query= $query.$departement.';';
                return $this->db->query($query)->result_array();
            }
            else{
                $query='select Candidat.id, candidat.nom, candidat.prenom, (Departement.nom)dept from candidat join EmployeeCandidat on candidat.id=EmployeeCandidat.idEmployee join ContratEmployee on ContratEmployee.idEmployee=EmployeeCandidat.idEmployee join Departement on Departement.id=ContratEmployee.idDep';
                return $this->db->query($query)->result_array();
            }
        }

        public function profil($nom){
            $query='select candidat.nom, candidat.prenom, candidat.datenaissance, candidat.nompere, candidat.nommere, candidat.nbrdenfant, candidat.tel, candidat.genre, candidat.diplome,
            (contrat.nom)Contrat, employee.numcnaps, ContratEmployee.salaire, (GroupeCSP.nom)GroupeCSP, (CategorieCSP.nom)CategorieCSP';
            $query=$query." from candidat join EmployeeCandidat on candidat.id=EmployeeCandidat.idEmployee
            join employee on EmployeeCandidat.idemployee=employee.id
            join ContratEmployee on ContratEmployee.idEmployee=EmployeeCandidat.idEmployee
            join contrat on contratEmployee.idcontrat=Contrat.id
            join CategorieCSP on contratEmployee.idcatcsp=CategorieCSP.id
            join GroupeCSP on CategorieCSP.idGroupeCSP=GroupeCSP.id
            where candidat.nom='";
            $query=$query.$nom."';";
            return $this->db->query($query)->result_array();
        }
             
        /*public function getList($columnsConditionated, $valuesConditionated){
            for($i=0; $i < sizeof($columnsConditionated) - 1; $i++){
                if($valuesConditionated[$i]=='')
                {
                    $query= $this->getData('candidat', ['nom','prenom', 'datenaissance', 'tel', 'genre', 'diplome', 'experience']);
                }
                else{
                   
                    $query= $this->getDataConditionated('candidat', ['nom','prenom', 'datenaissance', 'tel', 'genre', 'diplome', 'experience'], $columnsConditionated[$i], $valuesConditionated[$i]);
                }
            }
            return $query;//$this->db->query($query)->result_array();            
        } */  

        public function getDataSup($tableName, $columnsName, $columnsConditionated, $valuesConditionated)
        {
            $query = "select ";
            for ($i=0; $i < sizeof($columnsName) - 1; $i++) 
            {
                $query = $query.$columnsName[$i].", ";
            }
            $query = $query.$columnsName[sizeof($columnsName) - 1]." ";
            $query = $query."from ".$tableName." where "; 
            for ($i=0; $i < sizeof($columnsConditionated) - 1; $i++) 
            {
                $query = $query . $columnsConditionated[$i] . " = '" . $valuesConditionated[$i] . "' and "; 
            }
            $query = $query.$columnsConditionated[sizeof($columnsConditionated) - 1]." >= '". $valuesConditionated[sizeof($columnsConditionated) - 1]."' order by nom;";    
            return $this->db->query($query)->result_array();        
        }


    
        public function getStatsCandidat()
        {
            $query = "select* from result_pourcent;";
            return $this->db->query($query)->result_array();
        }

        public function getStatsSup(){
            $sql="SELECT *FROM stat_pourcent";
            $sql = sprintf($sql);
            $query = $this->db->query($sql);
            return $query->result_array(); 
        }

        public function getDataConditionated2($tableName, $columnsName, $columnsConditionated, $valuesConditionated)
        {
            $query = "select ";
            for ($i=0; $i < sizeof($columnsName) - 1; $i++) 
            {
                $query = $query.$columnsName[$i].", ";
            }
            $query = $query.$columnsName[sizeof($columnsName) - 1]." ";
            $query = $query."from ".$tableName." where "; 
            for ($i=0; $i < sizeof($columnsConditionated) - 1; $i++) 
            {
                $query = $query . $columnsConditionated[$i] . " = '" . $valuesConditionated[$i] . "' and "; 
            }
            $query = $query.$columnsConditionated[sizeof($columnsConditionated) - 1]." = ". $valuesConditionated[sizeof($columnsConditionated) - 1]."";    
            return  $this->db->query($query)->result_array();        
        }

        public function insert($tableName, $column, $values)
        {
            $query = "insert into ".$tableName.' (';
            for ($i=0; $i < sizeof($column) - 1; $i++) 
            { 
                $query = $query.$column[$i].', ';
            } 
            $query = $query.$column[$i].')';
            $query = $query." values (";
            for ($i=0; $i < sizeof($values) - 1; $i++) 
            {
                $query = $query.'\''.$values[$i].'\', ';
            }
            $query = $query.'\''.$values[sizeof($values) - 1].'\'';
            $query = $query.')';
            $this->db->query($query);
        }
        public function update($tableName, $column, $values, $columnsConditionated, $valuesConditionated)
        {
            $query = "update ".$tableName. " set ";
            for ($i=0; $i < sizeof($column) - 1; $i++) 
            { 
                $query = $query.$column[$i]." = '".$values[$i]. "', ";
            }
            $query = $query.$column[sizeof($values) - 1]." = '".$values[sizeof($values) - 1]."'";
            $query = $query." where ";
            for ($i=0; $i < sizeof($columnsConditionated) - 1; $i++) 
            { 
                $query = $query.$columnsConditionated[$i]." = '".$valuesConditionated[$i]. "' and ";
            }
            $query = $query.$columnsConditionated[sizeof($columnsConditionated) - 1]." = '".$valuesConditionated[sizeof($valuesConditionated) - 1]."'";

            $this->db->query($query);
        }
    }
?>