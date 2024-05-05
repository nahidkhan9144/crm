<?php

namespace App\Models;

use CodeIgniter\Model;

class My_model extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_items($limit, $offset,$search) {
        $query = $this->db->table('details');
        if ($search != null) {
            $query->like('name', $search);
            $query->orLike('company_name', $search);
            $query->orLike('designation', $search);
            $query->orLike('email', $search);
        }
        $query->orderBy('id', 'DESC');
        $query->limit($limit, $offset);
        
        return $query->get()->getResultArray();
    }

    public function count_items($search) {
        if ($search != null) {
            $query = $this->db->table('details');
            $query->like('name', $search);
            $query->orLike('company_name', $search);
            $query->orLike('designation', $search);
            $query->orLike('email', $search);
            return $query->countAllResults();
        } else {
            return $this->db->table('details')->countAllResults(); 
        }
    }
}
?>
