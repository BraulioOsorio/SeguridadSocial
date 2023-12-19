<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecuperarPassw extends CI_Model {
    
    public $table = 'recuperar_passw';
    public $table_id = 'correo';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function is_token_active($token) {
        $current_time = date('Y-m-d H:i:s');  // Obtén la fecha y hora actual

        // Consulta la base de datos para obtener la fecha de expiración del token
        $this->db->select('expiration_time');
        $this->db->where('token', $token);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $expiration_time = $row->expiration_time;

            // Compara la fecha de expiración con la hora actual
            if ($current_time <= $expiration_time) {
                // El token aún está activo
                return true;
            } else {
                // El token ha expirado
                return false;
            }
        } else {
            // El token no se encontró en la base de datos
            return false;
        }
    }
}
