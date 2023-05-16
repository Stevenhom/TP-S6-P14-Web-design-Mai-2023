<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class mMcandidat extends CI_Model
    {
        public function instestcandidat($idcand,$idtest)
        {
            $sql='insert into TestCandidat(id,idcandidat,idTest,Note,Reponse,DateTest) values(default,\''.$idcand.'\',\''.$idtest.'\',null,null,null)';
            $query = $this->db->query($sql);	
        }
        public function deltestcandidat($idcand,$idtest)
        {
            $sql='delete from TestCandidat where idcandidat=\''.$idcand.'\'and idtest=\''.$idtest.'\'';
            $query = $this->db->query($sql);	
        }
        public function insentretientcandidat($idcand,$identretient)
        {
            $sql='insert into entretientCandidat(id,idEntretient,idCandidat,Note,DateEntretient) values(default,\''.$identretient.'\',\''.$idcand.'\',null,default)';
            $query = $this->db->query($sql);	
        }
        public function delentretientcandidat($idcand,$identretient)
        {
            $sql='delete from entretientCandidat where idcandidat=\''.$idcand.'\'and identretient=\''.$identretient.'\'';
            $query = $this->db->query($sql);	
        }
        public function updentretientcandidat($idcand,$identretient,$note)
        {
            $sql='update entretientcandidat set Note=\''.$note.'\' where identretient=\''.$identretient.'\'and idcandidat=\''.$idcand.'\'';
            $query = $this->db->query($sql);	
        }
    }
?>