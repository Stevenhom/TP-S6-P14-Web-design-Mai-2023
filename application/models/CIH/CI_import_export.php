<?php 
    if(! defined('BASEPATH')) exit ('No direct script access allowed');

    class CI_import_export extends CI_Model{
        public function __construct() {

            parent::__construct();

            //$this->load->model('Compte');
            //$this->load->library('FPDF/pdf');
        }

        /*function getPDFCompte() {
            $this->pdf->SetFont('Arial','',14);
            $this->pdf->AddPage();
            $largeur = array(30,120);
            $this->pdf->hello($this->Compte->getHeadersTable('compte'),$this->Compte->lscompte(),$largeur);
            //foreach($this->Compte->lscompte() as $p) 
            //    echo strlen($p['numero']).' ';
            // Titres des colonnes
            //$header = array('Pays', 'Capitale', 'Superficie (km²)', 'Pop. (milliers)');
            //$this->pdf->AddPage();
            //$this->pdf->SetFont('Arial','B',16);
            //$this->pdf->Cell(40,10,'Hello World !');
            //$this->pdf->Output();
            $this->pdf->Output();
        }*/

        function writeInFile($file,$ecriture,$a) {
            $fileopen = fopen("$file",$a);
            fwrite($fileopen, $ecriture);
            fclose($fileopen);
        }


        function getCsvData($fileName) {
            $file = fopen($fileName, "r");
            $tab = [];
            $i = 0;
            while(($column = fgetcsv($file, 10000, "/")) !== FALSE) {
                $tab['question'][$i] = $column[0];
                $tab['point'][$i] = $column[1];
                $tab['reponse'][$i] = $column[2];
                $i++;
            }
            return $tab;
        }

        function getRepfromCSV($fileName) {
            $file = fopen($fileName, "r");
            $tab = [];
            $i = 0;
            while(($column = fgetcsv($file, 10000, "/")) !== FALSE) {
                $tab['reponse'][$i] = $column[0];
                $i++;
            }
            return $tab;
        }

        function setCsvToBdd($fileName) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
                $column[1] = str_replace("'", " ", $column[1]);
				if ($this->Compte->insertCompte($column[0],$column[1]) != 0)
					return 0;
			}
            return 1;
        }
}