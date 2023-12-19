<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CEmpresa extends CI_Controller
{

	

	

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('datos_pago_emp');
		$this->load->model('Empresa');
		$this->load->model('Usuario');
		$this->load->model('Plan');
		$this->load->model('PlanTrabajador');
		$this->load->model('Independiente');
		$this->load->database();
		$this->load->library('session');
	}

	public function crearEmpresa($id = null)
	{
		if (!$this->session->userdata('correo')) {
			redirect('/CUsuario', 'refresh');
		} else {
			

			$vdata["nombre_empresa"] = $vdata["nit"] = $vdata["correo_empresa"] = $vdata["telefono_empresa"] = $vdata["direccion_empresa"] = "";
			if (isset($id)) {
				$empresa = $this->Empresa->find($id);
				if (isset($empresa)) {
					$vdata["nombre_empresa"] = $empresa->nombre_empresa;
					$vdata["nit"] = $empresa->nit;
					$vdata["direccion_empresa"] = $empresa->direccion_empresa;
					$vdata["telefono_empresa"] = $empresa->telefono_empresa;
					$vdata["correo_empresa"] = $empresa->correo_empresa;
				}

			}
			if ($this->input->server("REQUEST_METHOD") == "POST") {
				$data["nombre_empresa"] = $this->input->post("nombre_empresa");
				$data["nit"] = $this->input->post("nit");
				$data["correo_empresa"] = $this->input->post("correoEmpresa");
				$data["telefono_empresa"] = $this->input->post("telefono");
				$data["direccion_empresa"] = $this->input->post("direccion");

				$vdata["nombre_empresa"] = $this->input->post("nombre_empresa");
				$vdata["nit"] = $this->input->post("nit");
				$vdata["correo_empresa"] = $this->input->post("correoEmpresa");
				$vdata["telefono_empresa"] = $this->input->post("telefono");
				$vdata["direccion_empresa"] = $this->input->post("direccion");
				$verificarNit = $this->Empresa->selectNit($data["nit"]);
				$alerta = array();

				if (!empty($verificarNit)) {
					$alerta = array(
						'mensaje' => 'El nit ya está registrado',
						'color' => 'warning'
					);
				} else {
					if (!isset($id)) {
						$verificarCorreo = $this->Empresa->selectCorreo($data["correo_empresa"]);

					}

					if (!empty($verificarCorreo)) {
						$alerta = array(
							'mensaje' => 'El Correo ya está registrado',
							'color' => 'warning'
						);
					} else {
						if (isset($id)) {
							$this->Empresa->update($id, $data);
							redirect("CEmpresa/consultarEmpresas", "refresh");
						} else {
							$this->Empresa->insertEmpresa($data);
							redirect("CEmpresa/consultarEmpresas", "refresh");
						}

					}
				}

				$this->session->set_flashdata('alerta', $alerta);
			}
			$this->load->view('Empresas/CrearE', $vdata);
		}
	}


	public function consultarEmpresas()
	{
		if (!$this->session->userdata('correo')) {
			redirect('/CUsuario', 'refresh');
		} else {
			$data["empresas"] = $this->Empresa->selectEmpresas();
			$this->load->view('Empresas/consultarE', $data);
		}
	}

	public function eliminarEmpresa($id = null)
	{
		if (!$this->session->userdata('correo')) {
			redirect('/CUsuario', 'refresh');
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
			if (isset($id)) {
				$empresa = $this->Empresa->find($id);
				if (isset($empresa)) {
					$vdata["id_empresa"] = $empresa->id_empresa;
					$vdata["nombre_empresa"] = $empresa->nombre_empresa;
					$vdata["nit"] = $empresa->nit;
					$vdata["direccion_empresa"] = $empresa->direccion_empresa;
					$vdata["telefono_empresa"] = $empresa->telefono_empresa;
					$vdata["correo_empresa"] = $empresa->correo_empresa;
				}

			}
			$this->load->view('Empresas/EliminarE', $vdata);
		}
	}

	public function borrar()
	{
		$id = $this->uri->segment(3);

		if ($id === null) {

		} else {
			$this->Empresa->deleteE($id);
			redirect("CEmpresa/consultarEmpresas", "refresh");
		}
	}

	public function buscarTrabajador($idEmpresa = null)
	{
		if (!$this->session->userdata("correo")) {
			redirect('/CUsuario', 'refresh');
		} else {
			$sessionActual = $this->session->userdata();

			if(isset($idEmpresa)){
				$addSession = array(
					'id_empresa' => $idEmpresa
				);
				$this->session->set_userdata(array_merge($sessionActual, $addSession));
			}	
			$vdata["id_trabajador"]  = $vdata["nombre_trabajador"] = $vdata["apellido_trabajador"] = $vdata["correo_trabajador"] = $vdata["status"] = "";
			if ($this->input->server("REQUEST_METHOD") == "POST") {
				$cedula = $this->input->post("cedulaTrabajador");

				$trabEncontrado = $this->Independiente->getIndependienteByDoc($cedula);
				$alerta = array();
				$mensaje = "";
				$color = "";

				if (isset($trabEncontrado)) {

					
					if ($trabEncontrado->id_empresa == null) {
						$vdata["id_trabajador"] = $trabEncontrado->id_trabajador;
						$vdata["nombre_trabajador"] = $trabEncontrado->nombre_trabajador;
						$vdata["apellido_trabajador"] = $trabEncontrado->apellido_trabajador;
						$vdata["correo_trabajador"] = $trabEncontrado->correo_trabajador;
						$vdata["status"] = true;
						
					}else{
						$mensaje = "Este usuario ya está asociado a una empresa";
						$color = "warning";
					}
				} else {
					$mensaje = "No se encontró una cédula registrada con este número";
					$color = "warning";
				}

				$alerta = array(
					"mensaje" =>  $mensaje,
					"color" => $color
				);
				$this->session->set_flashdata('alertaa', $alerta);

			}
			$this->load->view("Empresas/buscarTrabajador", $vdata);
		}
	}

	public function asignarTrabajador($id_empresa, $id_trabajador) {
		if (!$this->session->userdata("correo")) {
			redirect('/CUsuario', 'refresh');
		} else {
			$resultQuery =$this->Independiente->updateEmpresa($id_empresa, $id_trabajador);

			if($resultQuery){
				redirect("CEmpresa/consultarEmpresas", "refresh"); //Aqui remplazar por la lista de los trabajadores de la empresa a la que fue asignado (si se puede jajasd).
			}else{
				$alerta = array(
					"mensaje" =>  "Hubieron problemas al asignar al vendedor",
					"color" => "danger"
				);
				$this->session->set_flashdata('alerta', $alerta);
				redirect('CEmpresa/buscarTrabajador','refresh');
			}
		}
	}
	
	public function TrabajadoresEmpresa($id_empresa = null)
	{
		if (!$this->session->userdata('correo')) {
			redirect('/CUsuario', 'refresh');
		} else {
			if(isset($id_empresa)){
				$resultado = getMontoTotalEmp($id_empresa);
				$data = $resultado['data'];
				$this->load->view('Empresas/Trabajadores', $data);
			}		
		}
	}


	public function Desvincular($id_trabajador)
	{
		if (!$this->session->userdata('correo')) {
			redirect('/CUsuario', 'refresh');
		} else {
			if (isset($id_trabajador)) {
				$this->Independiente->desvincular($id_trabajador);
				$alerta = array(
					'status' => true,
					'title' => 'Trabajador Desvinculado Con Exito',
					'message' => 'Desvinculación Exitosa'
				);
				$this->session->set_flashdata('alerta', $alerta);

				redirect('lista-independientes', 'refresh');
			}
		}
	}

	public function DesvincularEmpresa($nit)
	{
		if (!$this->session->userdata('correo')) {
			redirect('/CUsuario', 'refresh');
		} else {
			if(isset($nit)){
				$this->Independiente->desvincularPlanEmpresa($nit);
				$alerta = array(
					'status' => true,
					'title' => ' Empresa Desvinculada Con Exito',
					'message' => 'Desvinculación Exitosa'
				);
				$this->session->set_flashdata('alerta', $alerta);

				redirect('CEmpresa/consultarEmpresas', 'refresh');
				
			}	
			
			
		}
	}





}
