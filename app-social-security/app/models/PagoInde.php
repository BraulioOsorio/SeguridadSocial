<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PagoInde extends CI_Model {
    
    Public $table = 'pagos_independiente';
    Public $table_id = 'id_pago_in';


	Public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
    }

    public function findPagoI($documento){
        $this->db->select('pagos_independiente.id_pago_in,trabajadores.nombre_trabajador,trabajadores.correo_trabajador,planes_pago.nombre_plan,pagos_independiente.monto_total,pagos_independiente.fecha_pago,pagos_independiente.estado_pago');
        $this->db->from($this->table);
        $this->db->join('trabajadores ','trabajadores.id_trabajador = pagos_independiente.id_trabajador');
        $this->db->join('planes_pago ',' planes_pago.id_plan = pagos_independiente.id_plan');
        $this->db->where('trabajadores.documento', $documento);
        $this->db->order_by('pagos_independiente.fecha_pago', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function updateEstadoPagoI($id_pago_in) {
        $data = array('estado_pago'=>1);
        $this->db->where($this->table_id, $id_pago_in);
        $this->db->update($this->table, $data);
    }

    public function insertPagoI($data) {
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    function updatePagoI($id_trabajador,$data){
        $this->db->where('id_trabajador',$id_trabajador);
        $this->db->update($this->table,$data);
    }

    public function getUltimoPago($id_inde) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_trabajador',$id_inde);
        $this->db->order_by('pagos_independiente.fecha_pago', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getValidationI($id_trabajador) {
        $this->db->select('COUNT(*) as total_filas');
        $this->db->from($this->table);
        $this->db->where('id_trabajador', $id_trabajador);
        $query = $this->db->get();
        $result = $query->row();
    
        return $result->total_filas;
    }

    
}
