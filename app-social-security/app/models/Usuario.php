<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model {
    
    Public $table = 'usuarios';
    Public $table_id = 'id_usuario';
    
    
	Public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->database();
        $this->load->library('encryption');
    }


    function findAll($id){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where("{$this->table_id} !=", $id);
        $query = $this->db->get();
        return $query->result();
    }



	public function index(){
		
	}

    public function find($id){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->table_id,$id);

        $query = $this->db->get();
        return $query->row();
    }

    public function get_user_by_email($identifier) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('correo', $identifier);
        try {
            $query = $this->db->get();
            return $query->row();
        } catch (Exception $th) {
            return null;
        }      
    }

    public function login($data) {
        if (isset($data['contrasenia']) && isset($data['correo'])) {
            $correo = $data['correo'];
            $password = $data['contrasenia'];
            //$password_hash = md5($password);
            $user = $this->get_user_by_email($correo);
            $decrypted_string = $this->encryption->decrypt($user->contrasenia);

            
            if ($user != null) {
                if ($user->correo === $correo && $password === $decrypted_string && $user->estado_usuario == '1') {
                    return $user;
                }elseif($user->correo === $correo && $password === $decrypted_string && $user->estado_usuario == '0'){
                    return $user;
                }else {
                    return false;
                }
            }else {
                return false;
            }


        } else {
            return false;
        }
    }
    

    public function update($id, $data){
        //$data['contrasenia'] = md5($data['contrasenia']);
        $password = $data['contrasenia'];
        $data['contrasenia'] = $this->encryption->encrypt($password);
        $this->db->where($this->table_id,$id);
        $this->db->update($this->table,$data);
    }


    public function delete($id){
        $data = array('estado_usuario' => 0);
        $this->db->where($this->table_id, $id);
        $this->db->update($this->table, $data);
    }

    public function updateActivate($id){
        $data = array('estado_usuario' => 1);
        $this->db->where($this->table_id, $id);
        $this->db->update($this->table, $data);
    }

    public function setPassw($correo,$change){
        //$encrypt = md5($change);
        $encrypt = $this->encryption->encrypt($change);
        $data = array('contrasenia' => $encrypt);
        $this->db->where('correo', $correo);
        $this->db->update($this->table, $data);
    }

    public function insert($data){
        //$data['contrasenia'] = md5($data['contrasenia']);
        $password = $data['contrasenia'];

        // Encriptar la contraseña
        $data['contrasenia'] = $this->encryption->encrypt($password);
        

        try {
            
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        } catch (Exception $th) {
            return null;
        }
    }
    
    public function countEmpleados() {
        $this->db->select('COUNT(*) as total_empleados');
        $this->db->from($this->table);
        $this->db->where('estado_usuario', 1);
        $this->db->where('cargo', "empleado");
        $query = $this->db->get();
        $result = $query->row();
    
        return $result->total_empleados;
    }

    public function actualizar_foto_perfil($id_usuario, $ruta_foto) {
        $foto_actual = $this->obtener_ruta_foto($id_usuario);

        // Actualizar la ruta de la foto en la base de datos
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios', array('foto_perfil' => $ruta_foto));

        // Eliminar la foto anterior si existe
        if ($foto_actual && file_exists($foto_actual)) {
            unlink($foto_actual);
        }
    }

    public function obtener_ruta_foto($id_usuario) {
        $this->db->select('foto_perfil');
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('usuarios');
        $result = $query->row();

        return $result ? $result->foto_perfil : null;
    }
}
