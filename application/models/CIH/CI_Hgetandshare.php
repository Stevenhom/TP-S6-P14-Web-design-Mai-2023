<?php 
    if(! defined('BASEPATH')) exit ('No direct script access allowed');

    class CI_Hgetandshare extends CI_Model{

        function select($table) {
            $query = $this->db->query($table);
            
            return $query->result_array();
        }

        function selectOnce($table) {
            $query = $this->db->query($table);
            
            return $query->row();
        }

        function insert($qlq, $table) {
            $sql = "insert into $table values (default";
            
            foreach($qlq as $val)
                $sql .= ",'$val'";
            
                $sql .= ")";
            //echo $sql;

            /*$this->db->query($sql);
            return 1;*/
            $db_debug = $this->db->db_debug;
            $this->db->db_debug = FALSE;
            if(!@$this->db->query($sql)){
                //echo $this->db->error();
                $error = $this->db->error();
                //echo $this->db->_error_message();
                //echo $this->db->_error_number();
                
                //echo $error['code'];

                //echo $error['message'];
                //redirect('CIH/CI_echap/goToNextN');
                //echo 'Here';
                //echo $error['message'].'<br/>here';    
                return $error['message'];            
            } else return 1;
        }
    }