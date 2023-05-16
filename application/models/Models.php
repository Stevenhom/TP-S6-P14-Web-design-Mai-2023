
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Models extends CI_Model
    {
        /*public function isLogable($nom, $motdepasse)
        {
            if(sizeof($this->getDataConditionated('toututilisateur', ['nom', 'motdepasse'], ['nom', 'motdepasse'], [$nom, $motdepasse])) == 0)
            {
                return false;
            }
            return true;
        }*/
        public function isAdmin($nom, $motdepasse)
        {
            if (sizeof($this->getDataConditionated('admin', ['name', 'pass'], ['name', 'pass'], [$nom, $motdepasse])) == 0) 
            {
                return false;
            }
            return true;
        }
        public function getData($tableName, $columnsName)
        {
            $query = "select ";
            for ($i=0; $i < sizeof($columnsName) - 1; $i++) 
            {
                $query = $query.$columnsName[$i].", ";
            }
            $query = $query.$columnsName[sizeof($columnsName) - 1]." ";
            $query = $query."from ".$tableName; 
            return  $this->db->query($query)->result_array();
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
                $query = $query . $columnsConditionated[$i] . " = '" . $valuesConditionated[$i] . "' and "; 
            }
            $query = $query.$columnsConditionated[sizeof($columnsConditionated) - 1]." = '". $valuesConditionated[sizeof($columnsConditionated) - 1]."'";    
            return $this->db->query($query)->result_array();        
        }

        public function get_userid($name, $pass){
            $query = "select idadmin from admin where name='".$name."' and pass='".$pass."'";    
            //echo $query;
            $result=$this->db->query($query)->result_array();
            if(!empty($result)) {
                // Retourner la première valeur de la première ligne
                return $result[0]['idadmin'];
            } else {
                // Si le résultat est vide, retourner null
                return null;
            }
        }

        public function get_userdata($id){
            $query = "select*from admin where idadmin=".$id."";    
            return $this->db->query($query)->result_array();
        }

        public function get_user_data($user_id) {
            $query = $this->db->get_where('admin', array('idadmin' => $user_id));
            return $query->row_array();
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

        public function escapeApostrophe($str) {
            return str_replace("'", "''", $str);
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
                $query = $query.'\''.$this->escapeApostrophe($values[$i]).'\', ';
            }
            $query = $query.'\''.$this->escapeApostrophe(($values[sizeof($values) - 1])).'\'';
            $query = $query.')';
            $this->db->query($query);
        }
        
        public function update($tableName, $column, $values, $columnsConditionated, $valuesConditionated)
        {
            $query = "update " . $tableName . " set ";
            for ($i = 0; $i < sizeof($column) - 1; $i++) { 
                $query .= $column[$i] . " = '" . $this->db->escape_str($values[$i]) . "', ";
            }
            $query .= $column[sizeof($values) - 1] . " = '" . $this->db->escape_str($values[sizeof($values) - 1]) . "'";
            $query .= " where ";
            for ($i = 0; $i < sizeof($columnsConditionated) - 1; $i++) { 
                $query .= $columnsConditionated[$i] . " = '" . $this->db->escape_str($valuesConditionated[$i]) . "' and ";
            }
            $query .= $columnsConditionated[sizeof($columnsConditionated) - 1] . " = '" . $this->db->escape_str($valuesConditionated[sizeof($valuesConditionated) - 1]) . "'";

            $this->db->query($query);
        }
        
        /*public function update($tableName, $column, $values, $columnsConditionated, $valuesConditionated)
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
        }*/

        public function delete($tableName, $columnsConditionated, $valuesConditionated)
        {
            $query = "delete from ".$tableName;
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