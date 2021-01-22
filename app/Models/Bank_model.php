<?php namespace App\Models;

use CodeIgniter\Model;
 
class Bank_model extends Model {
 
    protected $table = 'bank';
    protected $primaryKey = 'id_bank';
 
    public function get($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertBank($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateBank($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteBank($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 