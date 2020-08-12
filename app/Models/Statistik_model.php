<?php namespace App\Models;

use CodeIgniter\Model;
 
class Statistik_model extends Model {
 
    protected $table = 'statistik';
 
    public function get($where = false)
    {
        if($where === false){
            return $this->findAll();
        } else {
            return $this->getWhere($where)->getRowObject();
        }  
    }
     
    public function insert($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function update($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function delete($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 