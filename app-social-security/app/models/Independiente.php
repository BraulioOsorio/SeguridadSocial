<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Independiente extends CI_Model
{

    public $table = 'trabajadores';
    Public $tablePlan = 'planes_trabajador';
    public $table_id = 'id_trabajador';
    public $documento = 'documento';
    public $id_plan = 0;


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
    }

    function getIndependiente($id)
    {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->table_id, $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getIndependienteByDoc($documento_persona)
    {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->documento, $documento_persona);
        $query = $this->db->get();
        //Esto me devuelve una sola fila, se accede como objeto ejemplo: $query->id_trabajador 
        return $query->row();
    }

    public function insertIndependiente($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function updateIndependiente($id_trabajador, $data)
    {
        $this->db->where($this->table_id,$id_trabajador);
        $this->db->update($this->table,$data);    
    }


    public function getAllIndependientes() {
        $this->db->select('trabajadores.*, planes_pago.nombre_plan,planes_pago.id_plan');
        $this->db->from('trabajadores');
        $this->db->join('planes_trabajador', 'trabajadores.id_trabajador = planes_trabajador.id_trabajador', 'left');
        $this->db->join('planes_pago', 'planes_trabajador.id_plan = planes_pago.id_plan', 'left');
        $this->db->where('trabajadores.estado_trabajador', 1);
        $this->db->where('trabajadores.id_empresa', NULL);

        $query = $this->db->get();
        return $query->result();
    }


    public function deleteIndependiente($id_trabajador){
        $data = array(
            'estado_trabajador' => 0 
        );
    
        $this->db->where($this->table_id, $id_trabajador);
        $this->db->update($this->table, $data);
    }

    public function countIndependientes() {
        $this->db->select('COUNT(*) as total_independientes');
        $this->db->from($this->table);
        $this->db->where('estado_trabajador', 1);
    
        $query = $this->db->get();
        $result = $query->row();
    
        return $result->total_independientes;
    }

    public function updateEmpresa($id_empresa, $id_trabajador){
        

        $this->db->distinct();
        $this->db->select('planes_pago.id_plan');
        $this->db->from('empresas');
        $this->db->join('trabajadores', 'empresas.id_empresa = trabajadores.id_empresa', 'left');
        $this->db->join('planes_trabajador', 'trabajadores.id_trabajador = planes_trabajador.id_trabajador', 'left');
        $this->db->join('planes_pago', 'planes_trabajador.id_plan = planes_pago.id_plan', 'left');
        $this->db->where('empresas.estado_empresa', 1);
        $this->db->where('empresas.id_empresa',$id_empresa);
    
        $query = $this->db->get();
        

        $row = $query->row();

        $id_plan = $row->id_plan;
        if($id_plan !== null){
            $dataPlan = array(
                'id_trabajador' => $id_trabajador,
                'id_plan'  => $id_plan
            );
    
            $this->db->insert($this->tablePlan, $dataPlan);
            $insertar = $this->db->insert_id();
        }
        $data = array(
            'id_empresa' => $id_empresa
        );
        $this->db->where($this->table_id, $id_trabajador);
        $result = $this->db->update($this->table, $data);

        return $result;
    }
    public function getTrabajadores($id_empresa){
        
        $this->db->select('trabajadores.*, planes_pago.nombre_plan');
        $this->db->from('trabajadores');
        $this->db->join('planes_trabajador', 'trabajadores.id_trabajador = planes_trabajador.id_trabajador', 'left');
        $this->db->join('planes_pago', 'planes_trabajador.id_plan = planes_pago.id_plan', 'left');
        $this->db->where('trabajadores.estado_trabajador', 1);
        $this->db->where('trabajadores.id_empresa', $id_empresa);

        $query = $this->db->get();
        return $query->result();

    }
    public function desvincular($id_trabajador){
        
        $data = array(
            'id_empresa' => null
        );
        $this->db->where($this->table_id, $id_trabajador);
        $result = $this->db->update($this->table, $data);

        $this->db->where('id_trabajador', $id_trabajador);
        $this->db->delete('planes_trabajador');

    }

    

    public function desvincularPlanEmpresa($nit_empresa) {
        $this->db->select('empresas.id_empresa');
        $this->db->from('empresas');
        $this->db->where('empresas.nit', $nit_empresa);
    
        $query_empresa = $this->db->get();
        $row_empresa = $query_empresa->row();
        $id_empresa = $row_empresa->id_empresa;
    
        $this->db->select('trabajadores.id_trabajador');
        $this->db->from('trabajadores');
        $this->db->where('trabajadores.id_empresa', $id_empresa);
        $this->db->where('trabajadores.estado_trabajador', 1);
    
        $query_trabajadores = $this->db->get();
        $result = $query_trabajadores->result();
    
        if (!empty($result)) {
            $trabajadores_ids = array_column($result, 'id_trabajador');
    
            $this->db->where_in('id_trabajador', $trabajadores_ids);
            $this->db->delete('planes_trabajador');
        }
    }
    

    
    

    
}
