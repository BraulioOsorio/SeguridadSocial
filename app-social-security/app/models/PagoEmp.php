<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PagoEmp extends CI_Model {
    
    Public $table = 'pagos_empresas';
    Public $table_id = 'id_pago_em';


	Public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
    }

    public function findPagoE($nit){
        $this->db->select('pagos_empresas.id_pago_em,empresas.nombre_empresa, empresas.correo_empresa, planes_pago.nombre_plan, pagos_empresas.monto_total, pagos_empresas.fecha_pago, pagos_empresas.estado_pago');
        $this->db->from($this->table);
        $this->db->join('empresas','empresas.id_empresa = pagos_empresas.id_empresa');
        $this->db->join('planes_pago','planes_pago.id_plan = pagos_empresas.id_plan');
        $this->db->where('empresas.nit',$nit);
        $this->db->order_by('pagos_empresas.fecha_pago', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function updateEstadoPagoEmp($id_pago_em) {
        $data = array('estado_pago' => 1);
        $this->db->where($this->table_id, $id_pago_em);
        $this->db->update($this->table, $data);
    }

    public function insertPagoEmp($data) {
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    function updatePagoEmp($id_empresa,$data){
        $this->db->where('id_empresa',$id_empresa);
        $this->db->update($this->table,$data);
    }

    public function getUltimoPago($id_empresa) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_empresa',$id_empresa);
        $this->db->order_by('pagos_empresas.fecha_pago', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getValidationE($id_empresa) {
        $this->db->select('COUNT(*) as total_filas');
        $this->db->from($this->table);
        $this->db->where('id_empresa', $id_empresa);
        $query = $this->db->get();
        $result = $query->row();
    
        return $result->total_filas;
    }
    
}
