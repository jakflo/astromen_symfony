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
}
