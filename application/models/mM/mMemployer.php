<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class mMemployer extends CI_Model
    {
        public function insemployer($idEC)
        {
            $sql='insert into employee(idEC,entrer,NumCNAPS) values(\''.$idEC.'\',now(),default)';
            $query = $this->db->query($sql);	
        }
        public function inscontratempl($idempl,$idcatcsp,$idcontrat,$dep,$salaire,$Hentrer,$Hsortir){
            $sql='insert into ContratEmployee values (default,now(),\''.$idempl.'\',\''.$idcatcsp.'\',\''.$idcontrat.'\',\''.$dep.'\',\''.$salaire.'\',\''.$Hentrer.'\',\''.$Hsortir.'\')';
           // echo $sql;
            $query = $this->db->query($sql);	
        }
        public function irsa($salairebrut){
            $irsa['CNAPS']=$salairebrut*0.01;
            $irsa['sanitaire']=$salairebrut*0.01;
            $salaire=$salairebrut-$irsa['CNAPS']-$irsa['sanitaire'];
            $sql='select * from irsa where trancheinf<=\''.$salairebrut.'\'order by id asc';
            $res= $this->db->query($sql)->result_array();
            $res[count($res)-1]['tranchesup']=$salaire;
            $val=($res[count($res)-1]['tranchesup']-($res[count($res)-1]['trancheinf']-1))*$res[count($res)-1]['pourcentage']/100;
            $res[count($res)-1]['valeur']=$val;
            return $res;
        }
    }
?>