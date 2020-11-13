<?php namespace App\Models;

use CodeIgniter\Model;
 
class Member_model extends Model {
 
    protected $table = 'member';
    protected $primaryKey = 'id_member';
 
    public function get($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertThis($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateThis($data=NULL, $id=NULL)
    {
        $where = [$this->primaryKey => $id];
        if ( is_array($id) ) {
            $where = $id;
        }
        return $this->db->table($this->table)->update($data, $where);
    }
 
    public function deleteThis($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 