<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlanTrabajador extends CI_Model {
    
    Public $table = 'planes_trabajador';
    Public $table_id = 'id_plan_trabajador';


	Public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
    }

    public function AsignarPlan($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function hasPlan($idTrabajador)
    {
        $this->db->select('id_plan_trabajador');
        $this->db->from('planes_trabajador');
        $this->db->where('id_trabajador', $idTrabajador);

        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? true : false;
    }

    public function actualizarPlan($idPlan, $idTrabajador) {
        $this->db->where('id_trabajador', $idTrabajador);
        $this->db->update('planes_trabajador', array('id_plan' => $idPlan));
    }    

    public function findPlanTra($idTrabajador){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('id_trabajador', $idTrabajador);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    
}
