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
    
    public function getFullName(int $id) {
        $name = $this->db->dotaz_radek(
                'SELECT f_name, l_name FROM astro_tab where id=?', 
                array($id)
                );
        return trim("{$name['f_name']} {$name['l_name']}");
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
    
    public function add(string $fName, string $lName, string $dob, string $skill) {
        $dateTools = new DateTools;
        $this->db->sendSQL(
                'insert into astro_tab(f_name, l_name, DOB, skill) value(?, ?, ?, ?)', 
                array($fName, $lName, $dateTools->czDateToEn($dob), $skill)
                );
    }
    
    public function delete(int $id) {
        $this->db->sendSQL('delete from astro_tab where id=?', array($id));
    }
    
    public function edit(int $id, string $fName, string $lName, string $dob, string $skill) {
        $dateTools = new DateTools;
        $this->db->sendSQL(
                'update astro_tab set f_name=:fName, l_name=:lName, DOB=:dob, skill=:skill where id=:id', 
                array(
                    ':fName' => $fName, ':lName' => $lName, 
                    ':dob' => $dateTools->czDateToEn($dob), ':skill' => $skill, 
                    ':id' => $id
                )
                );
    }
}
