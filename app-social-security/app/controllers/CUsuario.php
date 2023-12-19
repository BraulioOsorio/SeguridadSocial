<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CUsuario extends CI_Controller {
	Public function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model(array('Usuario', 'RecuperarPassw', 'Plan', 'Empresa', 'Independiente'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
    }

	public function index(){
        $this->session->sess_destroy();
        $this->load->view('Usuario/login');
	}


    public function login_ajax() {
        if ($this->input->is_ajax_request()) {
            $error_reporting = error_reporting();
            error_reporting(0);

            // Obtener datos del formulario
            $data["contrasenia"] = $this->input->post("contrasenia");
            $data["correo"] = $this->input->post("correo");
    
            // Array para almacenar mensajes de validación
            $validationMessages = array();
    
            if (empty($data["contrasenia"])) {
                $validationMessages['contrasenia'] = 'La contraseña es requerida';
                $this->output->set_status_header(400);
            }
    
            if (empty($data["correo"])) {
                $validationMessages['correo'] = 'El correo es requerido';
                $this->output->set_status_header(400);
            }
    
            if (empty($validationMessages)) {
                // Solo ejecutar lógica de inicio de sesión si no hay mensajes de validación
                $usuario = $this->Usuario->login($data);
                $encontrado = $this->Usuario->get_user_by_email($data["correo"]);

                if (!empty($encontrado) && $usuario == false) {
                    $response = array('status' => false, 'message' => 'Contraseña incorrecta');
                    $this->output->set_status_header(401);
                }elseif ( empty($encontrado) ) {
                    $response = array('status' => false, 'message' => 'El usuario no existe en el sistema');
                    $this->form_validation->set_error_delimiters('', '');
                    $this->output->set_status_header(401);
                } elseif ($usuario && !empty($encontrado) ) {
                    if ($usuario->estado_usuario != 1) {
                        $response = array('status' => false, 'message' => 'El usuario está inactivo');
                        $this->output->set_status_header(401);
                    } else {
                        $session_data = array(
                            "name" => "$usuario->nombre_usuario $usuario->apellido_usuario",
                            'user_id' => $usuario->id_usuario,
                            'correo' => $usuario->correo,
                            'rol' => $usuario->cargo,
                            'foto' => $usuario->foto_perfil,
                            // Agrega cualquier otro dato de usuario que desees almacenar en la sesión
                        );
                        $this->session->set_userdata($session_data);
                        $response = array('status' => true, 'message' => 'Inicio de sesión exitoso');
                    }
                }
            } else {
                // Mensajes de validación
                $response = array('status' => false, 'errors' => $validationMessages);
            }
            
            echo json_encode($response);
            error_reporting($error_reporting);
        } else {
            show_404(); // Manejar solicitudes que no son AJAX
        }
    }
    


    public function cerrar_sesion() {
        $this->session->sess_destroy(); // Destruye la sesión actual
        redirect(base_url()); // Redirige al inicio de sesión o a donde prefieras
    }
    

    public function plantilla()
    {
        if (!$this->session->userdata('user_id')) {
            // La sesión no está activa, redirigir al inicio de sesión
            redirect(base_url());
        }
        $data['cantidad_planes'] = $this->Plan->countPlanes();
        $data['cantidad_empresas'] = $this->Empresa->countEmpresas();
        $data['cantidad_empleados'] = $this->Usuario->countEmpleados();
        $data['cantidad_independientes'] = $this->Independiente->countIndependientes();

        $this->load->view('Usuario/plantilla',$data);
    }

    public function usuarios() {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }else {
            if ($this->session->userdata('rol') !== 'admin') {
				$alerta = array(
					'status' => false,
					'title' => 'Este usuario no cuenta con permisos para realizar esta acción.',
					'message' => 'Error'
				);
				$this->session->set_flashdata('alerta', $alerta);
				redirect("/CUsuario/plantilla", "refresh");
			}
            if ($this->input->server("REQUEST_METHOD") == "POST") {
                if ($this->input->post('accion') == 'crear') {
                    $data["nombre_usuario"] = $this->input->post("nombre");
                    $data["apellido_usuario"] = $this->input->post("apellido");
                    $data["correo"] = $this->input->post("correo");
                    $data["contrasenia"] = $this->input->post("contrasenia");
                    $data["cargo"] = $this->input->post("rol");

                    if (
                        empty($data["nombre_usuario"]) &&
                        empty($data["apellido_usuario"]) &&
                        empty($data["correo"]) &&
                        empty($data["contrasenia"]) &&
                        empty($data["cargo"])
                    ) {
                        $alerta = array(
                            'status' => false,
                            'title' => 'Todos los campos deben ser diligenciados',
                            'message' => 'Error en el registro.'
                        );
                        $this->session->set_flashdata('alerta', $alerta);
                        redirect('/CUsuario/usuarios', 'refresh');
                    }

                    $correoRepeat = $this->Usuario->get_user_by_email($data["correo"]);
                    if (empty($correoRepeat)) {
                        $status = $this->Usuario->insert($data);
                        $alerta = array(
                            'status' => true,
                            'title' => 'Empleado registrado con éxito',
                            'message' => 'Registrado exitosamente'
                        );
                    }else {
                        $alerta = array(
                            'status' => false,
                            'title' => 'Ya existe un empleado con ese correo',
                            'message' => 'Verifica el correo.'
                        );
                    }
                }elseif ($this->input->post('accion') == 'editar') {
                    $data["nombre_usuario"] = $this->input->post("nombreEdit");
                    $data["apellido_usuario"] = $this->input->post("apellidoEdit");
                    $data["correo"] = $this->input->post("correoEdit");
                    $data["contrasenia"] = $this->input->post("contraseniaEdit");
                    $id_usuario = $this->input->post("id_usuario");
                    $usuario_original = $this->Usuario->find($id_usuario);

                    $data["cargo"] = $usuario_original->cargo;

                    if ($usuario_original->correo === $data["correo"]) {
                        // Si el correo es el mismo que el original, procede con la actualización
                        $this->Usuario->update($id_usuario, $data);
                        $alerta = array(
                            'status' => true,
                            'title' => 'Empleado actualizado con éxito',
                            'message' => 'Modificado exitosamente'
                        );
                    }else {
                        $correoRepetido = $this->Usuario->get_user_by_email($data["correo"]);
                        if (empty($correoRepetido)) {
                            $this->Usuario->update($id_usuario,$data);
                            $alerta = array(
                                'status' => true,
                                'title' => 'Empleado actualizado con éxito',
                                'message' => 'Modificado exitosamente'
                            );
                        }else {
                            $alerta = array(
                                'status' => false,
                                'title' => 'Ya existe un empleado con ese correo',
                                'message' => 'Verifica el correo.'
                            );
                        }
                    }
                }
                
                $this->session->set_flashdata('alerta', $alerta);
                redirect('/CUsuario/usuarios', 'refresh');
            }

            $id_usuario = $this->session->userdata('user_id');
            $vdata["usuarios"] = $this->Usuario->findAll($id_usuario);
            foreach ($vdata["usuarios"] as $key => $user) {
                $decrypted_string = $this->encryption->decrypt($user->contrasenia);
                $user->contrasenia = $decrypted_string;
            }
            $this->load->view('Usuario/tabla',$vdata);
        }

    }

    // ELIMINAR USUARIO
    public function delete($usuario_id) {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }

        if ($this->session->userdata('rol') != 'admin') {
            redirect("/Usuario/tabla");
        }

        $this->Usuario->delete($usuario_id);
        $alerta = array(
            'status' => true,
            'title' => 'Empleado eliminado con éxito',
            'message' => 'Eliminado exitosamente'
        );
        $this->session->set_flashdata('alerta', $alerta);
        redirect("/CUsuario/usuarios",'refresh');
    }

    // ACTIVAR USUARIO
    public function activate($usuario_id) {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }

        if ($this->session->userdata('rol') != 'admin') {
            redirect("/Usuario/tabla");
        }

        $this->Usuario->updateActivate($usuario_id);
        $alerta = array(
            'status' => true,
            'title' => 'Empleado activado con éxito',
            'message' => 'Activado exitosamente'
        );
        $this->session->set_flashdata('alerta', $alerta);
        redirect("/CUsuario/usuarios");
    }


    public function perfil() {
        if (!$this->session->userdata('user_id')) {
            // La sesión no está activa, redirigir al inicio de sesión
            redirect(base_url());
        }
        
        $id_user = $this->session->userdata('user_id');
        $rol = $this->session->userdata('rol');

        $user = $this->Usuario->find($id_user);
        $datos["nombre"] = $user->nombre_usuario;
        $datos["apellido"] = $user->apellido_usuario;
        $datos["correo"] = $user->correo;
        $datos["passw"] = $user->contrasenia;
        $contrasenia_db = $datos["passw"];
        $decrypted_string = $this->encryption->decrypt($contrasenia_db);
        $datos["passw"] = $decrypted_string;
        $datos["rol"] = $user->cargo;
        $datos["foto"] = $user->foto_perfil;

        if($this->input->server("REQUEST_METHOD")== "POST"){
            $data["contrasenia"] = $this->input->post("passw");
            $data["correo"] = $this->input->post("correo");
            $data["nombre_usuario"] = $this->input->post("nombre");
            $data["apellido_usuario"] = $this->input->post("apellido");
            $data["cargo"] = $rol;

            if ($user->nombre_usuario == $data["nombre_usuario"] 
            && $user->apellido_usuario == $data["apellido_usuario"]
            && $user->contrasenia == $data["contrasenia"] 
            && $user->correo == $data["correo"] ) {
                $alerta = array(
                    "status"=> false,
                    "title"=> "No hay datos que actualizar",
                    "message"=> "No ha cambiado ningún dato."
                );
                $this->session->set_flashdata("alerta",$alerta);
                redirect('/CUsuario/perfil','refresh');
            }

            if ($user->correo == $data["correo"]) {
                $this->Usuario->update($id_user, $data);
                $alerta = array(
                    "status"=> true,
                    "title"=> "Datos actualizados",
                    "message"=> "Datos editados exitosamente"
                );
            }else {
                $correoRepetido = $this->Usuario->get_user_by_email($data["correo"]);
                if (empty($correoRepetido)) {
                    $this->Usuario->update($id_user, $data);
                    $alerta = array(
                        "status"=> true,
                        "title"=> "Datos actualizados",
                        "message"=> "Datos editados exitosamente"
                    );
                }else {
                    $alerta = array(
                        "status"=> false,
                        "title"=> "Error al editar",
                        "message"=> "El correo ya existe."
                    );
                }
            }

            
            $this->session->set_flashdata("alerta",$alerta);
            redirect('/CUsuario/perfil','refresh');
	    }
        $this->load->view('Usuario/profile',$datos);
    }

    public function cambiarFoto() {
        if (!$this->session->userdata('user_id')) {
            // La sesión no está activa, redirigir al inicio de sesión
            redirect(base_url());
        }
        
        $id_user = $this->session->userdata('user_id');
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            // Establecer el límite en 5 megabytes
            $config['max_size'] = 8 * 1024;  // 5 MB en kilobytes (1024 KB = 1 MB)

            $this->load->library('upload', $config);
    
            if ($this->upload->do_upload('userfile')) {
                $upload_data = $this->upload->data();
                $ruta_foto = 'uploads/' . $upload_data['file_name'];
                // Actualizar la ruta de la foto en la base de datos
                $this->Usuario->actualizar_foto_perfil($id_user, $ruta_foto);
                $this->session->set_userdata('foto', $ruta_foto);
                $alerta = array(
                    "status"=> true,
                    "title"=> "Foto actualizada con éxito.",
                    "message"=> "Foto modificada exitosamente"
                );
            } else {
                // Manejar el caso en el que la carga de la imagen falla
                $error_message = strip_tags($this->upload->display_errors());
                $alerta = array(
                    "status"=> false,
                    "title"=> "Error: " . $error_message,
                    "message"=> "No se pudo modificar la foto de perfil"
                );
                
            }
            $this->session->set_flashdata("alerta",$alerta);
            redirect('/CUsuario/perfil','refresh');
        }
        

    }

    public function recuperar() {
        $data["correo"] = "";
    
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $email = $this->input->post("correo");
            $encontrado = $this->Usuario->get_user_by_email($email);
    
            if (!empty($encontrado)) {
                $data["correo"] = $encontrado->correo;
                $this->session->set_userdata("correo", $encontrado->correo);
    
                $alerta = array(
                    'status' => true,
                    'title' => 'Revisa tu correo, enviamos un codigo de verificacion',
                    'message' => 'token enviado exitosamente.'
                );
                $this->session->set_flashdata('alerta', $alerta);
                redirect('/CUsuario/token');
            } else {
                $alerta = array(
                    'status' => false,
                    'title' => 'Usuario no encontrado',
                    'message' => 'El usuario no se encuentra en el sistema.'
                );
                $this->session->set_flashdata('alerta', $alerta);
                redirect('/CUsuario/recuperar', 'refresh');
            }
        }
    
        $this->load->view('Password/recuperarPass', $data);
    }
    

    public function token() {
        if (!$this->session->userdata('correo')) {
            redirect(base_url());
        }
        
        if ($this->input->server("REQUEST_METHOD") == "POST" ) {
            $num1 = $this->input->post("num1");
            $num2 = $this->input->post("num2");
            $num3 = $this->input->post("num3");
            $num4 = $this->input->post("num4");
            $token = $num1 . $num2 . $num3 . $num4;
            //$verificar_token = $this->RecuperarPassw->is_token_active($token);
            $verificar_token = true;
            if ($verificar_token) {
                redirect('/CUsuario/restablecerPassw');
            }else {
                $alerta = array(
                    'status' => false,
                    'title' => 'El token ha caducado',
                    'message' => 'El tiempo del token a expirado.'
                );
                $this->session->set_flashdata('alerta', $alerta);
                redirect(base_url(),'refresh');
            }
        }
        $this->load->view('/Password/token');
    }

    public function restablecerPassw(){

        if (!$this->session->userdata('correo')) {
            redirect(base_url());
        }

        if($this->input->server("REQUEST_METHOD")== "POST"){
            $data["passw1"] = $this->input->post("passw1");
            $data["passw2"] = $this->input->post("passw2");
            if ($data["passw1"] === $data["passw2"]) {
                $email = $this->session->userdata('correo');
                try {
                    $this->Usuario->setPassw($email,$data["passw1"]);
                    $alerta = array(
                        'status' => true,
                        'title' => 'Contraseña restablecida con éxito',
                        'message' => 'Contraseña cambiada exitosamente.'
                    );
                } catch (Exception $th) {
                    $alerta = array(
                        'status' => false,
                        'title' => 'Ocurrio un error al restablecer',
                        'message' => 'Error vuelva a intentarlo.'
                    );
                }
                $this->session->set_flashdata('alerta', $alerta);
                redirect(base_url(),'refresh');
            }else {
                $alerta = array(
                    'status' => false,
                    'title' => 'Las contraseñas no coinciden',
                    'message' => 'Las contraseñas deben ser iguales.'
                );
                $this->session->set_flashdata('alerta', $alerta);
                redirect('/CUsuario/restablecerPassw','refresh');
            } 
	    }
        $this->load->view('/Password/restablecerPass');
    }
}
