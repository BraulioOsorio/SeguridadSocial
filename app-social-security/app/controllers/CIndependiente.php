<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CIndependiente extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('Empresa');
		$this->load->model('Usuario');
		$this->load->model('Independiente');
		$this->load->database();
		$this->load->library('session');
	}

	public function crearIndependiente($id_trabajador = null)
	{
		if (!$this->session->userdata('correo')) {
			redirect(base_url(), 'refresh');
		} else {
			if ($this->session->userdata('rol') !== 'admin' && $this->session->userdata('rol') !== 'empleado') {

				$alerta = array(
					'status' => false,
					'title' => 'Este usuario no cuenta con permisos para realizar esta acción.',
					'message' => 'Error'
				);
				$this->session->set_flashdata('alerta', $alerta);
				redirect("/CUsuario/plantilla", "refresh");
			}

			$vdata["nombre_trabajador"] = $vdata["apellido_trabajador"] = $vdata["documento"] = $vdata["fecha_nacimiento"] = $vdata["direccion_trabajador"] = $vdata["telefono_trabajador"] = $vdata["correo_trabajador"] = $vdata["salario"] = $vdata["id_empresa"] = $vdata["estado_trabajador"] = "";
			if (isset($id_trabajador)) {
				$independiente = $this->Independiente->getIndependiente($id_trabajador);
				if (isset($independiente)) {
					$vdata["nombre_trabajador"] = $independiente->nombre_trabajador;
					$vdata["apellido_trabajador"] = $independiente->apellido_trabajador;
					$vdata["documento"] = $independiente->documento;
					$vdata["fecha_nacimiento"] = $independiente->fecha_nacimiento;
					$vdata["direccion_trabajador"] = $independiente->direccion_trabajador;
					$vdata["telefono_trabajador"] = $independiente->telefono_trabajador;
					$vdata["correo_trabajador"] = $independiente->correo_trabajador;
					$vdata["salario"] = $independiente->salario;

					$vdata["estado_trabajador"] = $independiente->estado_trabajador;
				}
			}
			if ($this->input->server("REQUEST_METHOD") == "POST") {
				$data["nombre_trabajador"] = $this->input->post("nombre_trabajador");
				$data["apellido_trabajador"] = $this->input->post("apellido_trabajador");
				$data["documento"] = $this->input->post("documento");
				$data["fecha_nacimiento"] = $this->input->post("fecha_nacimiento");
				$data["direccion_trabajador"] = $this->input->post("direccion_trabajador");
				$data["telefono_trabajador"] = $this->input->post("telefono_trabajador");
				$data["correo_trabajador"] = $this->input->post("correo_trabajador");
				$data["salario"] = $this->input->post("salario");

				//wow
				$vdata["nombre_trabajador"] = $this->input->post("nombre_trabajador");
				$vdata["apellido_trabajador"] = $this->input->post("apellido_trabajador");
				$vdata["documento"] = $this->input->post("documento");
				$vdata["fecha_nacimiento"] = $this->input->post("fecha_nacimiento");
				$vdata["direccion_trabajador"] = $this->input->post("direccion_trabajador");
				$vdata["telefono_trabajador"] = $this->input->post("telefono_trabajador");
				$vdata["correo_trabajador"] = $this->input->post("correo_trabajador");
				$vdata["salario"] = $this->input->post("salario");



				$persona_existe = $this->Independiente->getIndependienteByDoc($data["documento"]);

				$mensaje = "";
				$color = '';
				if (isset($id_trabajador)) {
					if (!empty($persona_existe) && $data["documento"] != $vdata["documento"]) {
						$mensaje = "La persona con documento N. " . $data["documento"] . " ya se encuentra registrada.";
						$color = 'warning';
					} else {
						$this->Independiente->updateIndependiente($id_trabajador, $data);
						$alerta = array(
							'status' => true,
							'title' => 'Trabajador actualizado con éxito',
							'message' => 'Datos modificados exitosamente.'
						);
						$this->session->set_flashdata('alerta', $alerta);
						redirect("/inicio", "refresh");
					}
				} else {
					if (!empty($persona_existe)) {
						$mensaje = "La persona con documento N. " . $data["documento"] . " ya se encuentra registrada.";
						$color = 'warning';
					} else {
						$this->Independiente->insertIndependiente($data);
						$vdata["nombre_trabajador"] = $vdata["apellido_trabajador"] = $vdata["documento"] = $vdata["fecha_nacimiento"] = $vdata["direccion_trabajador"] = $vdata["telefono_trabajador"] = $vdata["correo_trabajador"] = $vdata["salario"]  = $vdata["estado_trabajador"] = "";
						$mensaje = "La persona se ha registrado correctamente.";
						$color = 'success';
					}
				}
				$alerta = array(
					'mensaje' => $mensaje,
					'color' => $color
				);
				$this->session->set_flashdata('alertaa', $alerta);
			}

			$this->load->view('Independientes/crearIndependiente', $vdata);
		}
	}


	public function consultarIndependientes()
	{
		if (!$this->session->userdata('correo')) {
			redirect(base_url(), 'refresh');
		} else {
			$data["independientes"] = $this->Independiente->getAllIndependientes();
			$this->load->view('Independientes/consultarInde', $data);
		}
	}

	public function eliminarIndependiente($id_trabajador = null)
	{
		if (!$this->session->userdata('correo')) {
			redirect(base_url(), 'refresh');
		} else {
			if ($this->session->userdata('rol') !== 'admin') {
				$alerta = array(
					'status' => false,
					'title' => 'Este usuario no cuenta con permisos para realizar esta acción.',
					'message' => 'Error'
				);
				$this->session->set_flashdata('alerta', $alerta);
				redirect("/CUsuario/plantilla", "refresh");
			}
			$alerta = array(
				'status' => true,
				'title' => 'Trabajador independiente eliminado exitosamente',
				'message' => 'Eliminado con éxito.'
			);
			$this->session->set_flashdata('alerta', $alerta);
			$this->Independiente->deleteIndependiente($id_trabajador);
			redirect("/inicio", "refresh");
			
		}
	}
}
