<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Model {
    
    Public $table = 'empresas';
    Public $table_id = 'id_empresa';
    Public $nit = 'nit';
    Public $correo = 'correo_empresa';


	Public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
    }

    public function insertEmpresa($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function selectNit($dataNit){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->nit, $dataNit);

        $query = $this->db->get();
        return $query->row();
    }

    public function selectCorreo($dataCorreo){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->correo, $dataCorreo);

        $query = $this->db->get();
        return $query->row();
    }

    public function getCorreoEmpresa($id){
        $this->db->select($this->correo);
        $this->db->from($this->table);
        $this->db->where($this->table_id, $id);

        $query = $this->db->get();
        return $query->row();
    }

    //public function selectEmpresas() {
    //    $this->db->select('*');
    //    $this->db->from($this->table);
    //    $this->db->where('estado_empresa', 1); 
    //
    //    $query = $this->db->get();
    //    return $query->result();
    //}
    public function selectEmpresas() {
        $this->db->distinct();
        $this->db->select('empresas.id_empresa, empresas.nombre_empresa, empresas.nit, empresas.direccion_empresa, empresas.telefono_empresa, empresas.correo_empresa, empresas.fecha_creacion, empresas.fecha_modificacion, empresas.estado_empresa, planes_pago.nombre_plan,planes_pago.id_plan');
        $this->db->from('empresas');
        $this->db->join('trabajadores', 'empresas.id_empresa = trabajadores.id_empresa', 'left');
        $this->db->join('planes_trabajador', 'trabajadores.id_trabajador = planes_trabajador.id_trabajador', 'left');
        $this->db->join('planes_pago', 'planes_trabajador.id_plan = planes_pago.id_plan', 'left');
        $this->db->where('empresas.estado_empresa', 1);
        $this->db->group_by('empresas.id_empresa');
    
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function update($id,$data){
        unset($data['nit']);
        $this->db->where($this->table_id,$id);
        $this->db->update($this->table,$data);
    }
    function find($id){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->table_id,$id);
        $query = $this->db->get();
        return $query->row();
    }

    function deleteE($id){
        $data = array(
            'estado_empresa' => 0 
        );
    
        $this->db->where($this->table_id, $id);
        $this->db->update($this->table, $data);
    }

    public function countEmpresas() {
        $this->db->select('COUNT(*) as total_empresas');
        $this->db->from($this->table);
        $this->db->where('estado_empresa', 1);
    
        $query = $this->db->get();
        $result = $query->row();
    
        return $result->total_empresas;
    }

    public function isEmpresa($nit) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->nit, $nit);
    
        $query = $this->db->get();
    
        return ($query->num_rows() > 0) ? true : false;
    }
    

}
