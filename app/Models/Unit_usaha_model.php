<?php namespace App\Models;

use CodeIgniter\Model;
 
class Unit_usaha_model extends Model {
 
    protected $table = 'unit_usaha';
    protected $primaryKey = 'id_unit_usaha';
 
    public function getUnitUsaha($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertUnitUsaha($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateUnitUsaha($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteUnitUsaha($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 