<?php

namespace App\Entity\Models;
use App\Utils\DateTools;

class AstromenModel extends Models {
    public function get_table() {
        $data = $this->db->dotaz_vse('SELECT id, f_name, l_name, DOB, skill FROM astro_tab');
        if ($data) {
            $dateTools = new DateTools;
            foreach ($data as &$row) {
                $row['DOB'] = $dateTools->enDateToCz($row['DOB']);
            }
        }
        return $data;
    }
    
    public function idExists(int $id) {
        return $this->db->dotaz_hodnota('select count(*) from astro_tab where id=?', array($id)) > 0;
    }
    
    public function isNameExists(string $fName, string $lName, string $dob, int $id = 0) {
        $dateTools = new DateTools;
        $params = array(
            ':fName' => trim($fName), 
            ':lName' => trim($lName), 
            ':dob' => trim($dateTools->czDateToEn($dob))
        );
        if ($id != 0) {
            $idTerm = ' and id!=:id';
            $params[':id'] = $id;
        }
        else {
            $idTerm = '';
        }
        return $this->db->dotaz_hodnota(
                'select count(*) from astro_tab where ((f_name=:fName and l_name=:lName and DOB=:dob) 
                or (f_name=:lName and l_name=:fName and DOB=:dob)) '.$idTerm, 
                $params
                ) > 0;
    }
}
