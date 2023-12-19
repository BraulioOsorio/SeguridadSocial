<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Model {
    
    Public $table = 'planes_pago';
    Public $table_id = 'id_plan';


	Public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
    }

    public function insertPlan($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function findPlanByName($nombre){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nombre_plan', $nombre);
        $this->db->where('estado_plan', 1); 
        $query = $this->db->get();
        return $query->result();
    }


    public function findAllPlanes() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('estado_plan', 1); 
        $this->db->order_by('nombre_plan', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    
    function updatePlan($id,$data){
        $this->db->where($this->table_id,$id);
        $this->db->update($this->table,$data);
    }

    function findPlan($id){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->table_id,$id);
        $query = $this->db->get();
        return $query->row();
    }

    function deletePlan($id){
        $data = array(
            'estado_plan' => 0 
        );
    
        $this->db->where($this->table_id, $id);
        $this->db->update($this->table, $data);
    }

    public function countPlanes() {
        $this->db->select('COUNT(*) as total_planes');
        $this->db->from($this->table);
        $this->db->where('estado_plan', 1);
    
        $query = $this->db->get();
        $result = $query->row();
    
        return $result->total_planes;
    }
    
}
