<?php 
    if(! defined('BASEPATH')) exit ('No direct script access allowed');

    class Harena extends CI_Model{
        function insert($nomTable, $colonnes, $valeurs) {
            
            $sql = "insert into $nomTable(";
            $deb = 0;
            foreach($colonnes as $col) {
                $sql .= $deb != 0 ? ','.$col : $col;
                $deb = 1;
            }
            $deb = 0;
            $sql .= ") values(";
            echo $sql;
            foreach($valeurs as $val) {
                if($deb == 0) {
                    $sql .= ($val == 'default!' ? 'default' : "'$val'");
                    $deb = 1;
                } else
                    $sql .= ','.($val == 'default!' ? 'default' : "'$val'");
            }
            $sql .= ')';
            echo $sql;
            $db_debug = $this->db->db_debug;
            $this->db->db_debug = FALSE;
            
            if(!@$this->db->query($sql)) {
                $error = $this->db->error();
                return $error['message'];
            }

            return 1;
            //$query = $this->db->query($sql);
            //echo $sql;
        }

        function select($nomTable) {
            $sql = "select * from $nomTable";
            $query = $this->db->query($sql);

            return $query->result_array();
        }

        function update($tab,$col,$val) {
            $sql = "update $tab set $col[0]=$val[0] where $col[1]=$val[1]";

            //echo $sql;

            $query = $this->db->query($sql);
        }

        function getMonths() {
            $month[0] = 'Janvier';
            $month[1] = 'Fevrier';
            $month[2] = 'Mars';
            $month[3] = 'Avril';
            $month[4] = 'Mai';
            $month[5] = 'Juin';
            $month[6] = 'Juillet';
            $month[7] = 'Aout';
            $month[8] = 'Septembre';
            $month[9] = 'Octobre';
            $month[10] = 'Novembre';
            $month[11] = 'Decembre';
            
            return $month;
        }
        
    }