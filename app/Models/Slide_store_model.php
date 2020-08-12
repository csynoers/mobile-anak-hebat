<?php namespace App\Models;

use CodeIgniter\Model;
 
class Slide_store_model extends Model {
 
    protected $table = 'slide_store';
    protected $primaryKey = 'id_slide_store';
 
    public function get($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
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