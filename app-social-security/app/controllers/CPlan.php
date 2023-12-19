<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CPlan extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->helper('datos_pago_emp');
        $this->load->model('Plan');
        $this->load->model('Usuario');
		$this->load->model('PlanTrabajador');
		$this->load->model('Empresa');
		$this->load->model('Independiente');
		$this->load->model('PagoEmp');
		$this->load->model('PagoInde');
        $this->load->database();
        $this->load->library('session');
    }

    public function planes($idTrabajador = null , $idPlan = null){
		if (!$this->session->userdata('correo')) {
			redirect('/CUsuario', 'refresh');
		} else {
			
			if ($this->input->server("REQUEST_METHOD") == "POST") {
				if ($this->input->post('accion') == 'crear') {
					$data["nombre_plan"] = $this->input->post("nombre");
					$data["tipo"] = $this->input->post("tipo");
					$data["porcentaje_salud"] = $this->input->post("salud");
					$data["porcentaje_pension"] = $this->input->post("pension");
					$data["porcentaje_arl"] = $this->input->post("arl");
					$nombrePlanRepeat = $this->Plan->findPlanByName($data["nombre_plan"]);
					if (empty($nombrePlanRepeat)) { // Si la consulta no devuelve resultados
						$this->Plan->insertPlan($data);
						$alerta = array(
							'status' => true,
							'title' => 'Plan creado con éxito',
							'message' => 'Creado exitosamente'
						);
					} else {
						$alerta = array(
							'status' => false,
							'title' => 'Ya existe un plan con ese nombre',
							'message' => 'No se puede crear un plan existente'
						);
					}
				}elseif ($this->input->post('accion') == 'editar') {
					$data['nombre_plan'] = $this->input->post('nombre');
					$data['tipo'] = $this->input->post('tipo');
					$data["porcentaje_salud"] = $this->input->post("salud");
					$data["porcentaje_pension"] = $this->input->post("pension");
					$data["porcentaje_arl"] = $this->input->post("arl");
					$plan_id = $this->input->post('id_plan');
					$PlanActual = $this->Plan->findPlan($plan_id);
					if ($PlanActual->nombre_plan == $data["nombre_plan"]) {
						$this->Plan->updatePlan($plan_id,$data);
						$alerta = array(
							'status' => true,
							'title' => 'Plan actualizado con éxito',
							'message' => 'Modificado exitosamente'
						);
					}else {
						$nombrePlanRepeat = $this->Plan->findPlanByName($data["nombre_plan"]);
						if (empty($nombrePlanRepeat)) {
							$this->Plan->updatePlan($plan_id,$data);
							$alerta = array(
								'status' => true,
								'title' => 'Plan actualizado con éxito',
								'message' => 'Modificado exitosamente'
							);
						} else {
							$alerta = array(
								'status' => false,
								'title' => 'Ya existe un plan con ese nombre',
								'message' => 'No se puede actualizar un plan colocando ese nombre'
							);
						}
					}
				}elseif ($this->input->post('accion') == 'eliminar') {
					$plan_id = $this->input->post('id_plan');
                    $this->Plan->deletePlan($plan_id);
                    $alerta = array(
                        'status' => true,
                        'title' => 'Plan eliminado con éxito',
                        'message' => 'Eliminado exitosamente'
                    );
				}elseif ($this->input->post('accion') == 'buscar') {
					$data['nombre_plan'] = $this->input->post('nombre');
					$id_trabajador_filtro = $this->input->post('id_trabajador');
					$id_plan_filtro = $this->input->post('id_plan_asignado');
					$id_nit_filtro = $this->input->post('id_nit_empresa');
					$planes['planFilter'] = $this->Plan->findPlanByName($data["nombre_plan"]);
					if (empty($planes['planFilter'])) { 
						$alerta = array(
							'status' => false,
							'title' => 'No existe un plan con ese nombre',
							'message' => 'No se puede buscar un plan que no existente'
						);
						$this->session->set_flashdata('nit', $idTrabajador);
						$this->session->set_flashdata('pla', $idPlan);
						
					} else {
						$alerta = array(
							'status' => true,
							'title' => 'Plan filtrado correctamente',
							'message' => 'Busqueda realizada con exito'
						);
						$this->session->set_flashdata('alerta', $alerta);
						$this->session->set_flashdata('Planes', $planes);
						$this->session->set_flashdata('id', $idTrabajador);
						$this->session->set_flashdata('id_trabajador_filtro', $id_trabajador_filtro);
						$this->session->set_flashdata('id_plan_filtro', $id_plan_filtro);
						$this->session->set_flashdata('id_nit_filtro', $id_nit_filtro);
						
						if ($this->Empresa->isEmpresa($idTrabajador)) {
							$this->session->set_flashdata('nit', $idTrabajador);
							$this->session->set_flashdata('pla', $idPlan);
						}
					}
				}
				$this->session->set_flashdata('alerta', $alerta);
				redirect('/CPlan/planes', 'refresh');
			}

			//comprobar si $idTrabajador es un nit
			$this->session->set_flashdata('id', $idTrabajador);
			if ($this->Empresa->isEmpresa($idTrabajador)) {
				$this->session->set_flashdata('nit', $idTrabajador);
				$this->session->set_flashdata('pla', $idPlan);
			}else{
				$this->session->set_flashdata('id', $idTrabajador);
				$this->session->set_flashdata('pla', $idPlan);
			}

			if (isset($idTrabajador)) {
				$vdata["idTrabajador"] = $idTrabajador;
				
			}else{
				$vdata["idTrabajador"] = "";

			}

			$vdata["planes"] = $this->Plan->findAllPlanes();
			$this->load->view('Planes/CrearPlan', $vdata);
		}
	}
	public function asignarPlan($idPlan,$idTrabajador) {
		$data['id_plan'] = $idPlan;
		$data['id_trabajador'] = $idTrabajador;

		$actualizarPlan = $this->PlanTrabajador->hasPlan($idTrabajador);
		if ($actualizarPlan) {
			$this->PlanTrabajador->actualizarPlan($idPlan, $idTrabajador);
		} else {
			$this->PlanTrabajador->AsignarPlan($data);
			$filas = $this->PagoInde->getValidationI($idTrabajador);
			if ($filas == 0 ) {
				$resultado = getMontoTotalInde($idTrabajador,$idPlan);
				$monto_total = $resultado["monto_total"];
				$fechaActual = new DateTime();
				$fecha_pago = clone $fechaActual;
				$fecha_pago->modify('+1 month');
				$vdata["id_trabajador"] = $idTrabajador;
				$vdata["id_plan"] = $idPlan;
				$vdata["monto_total"] = $monto_total;
				$vdata["fecha_pago"] = $fecha_pago->format('Y-m-d');
				$this->PagoInde->insertPagoI($vdata);
			}
		}

		$alerta = array(
			'status' => true,
			'title' => "Plan Asignado Exitosamente.",
			'message' => 'Asigando Con Exito'
		);
		$this->session->set_flashdata('alerta', $alerta);
		redirect('CIndependiente/consultarIndependientes', 'refresh');
	}

	//esta funcion asigna el mismo plan a todos los trabajadores de la empresa seleccionada
	public function asignarPlanEmpresa($idPlan, $nitEmpresa) {
		$idEmpresa = $this->Empresa->selectNit($nitEmpresa)->id_empresa;
		$trabajadores = $this->Independiente->getTrabajadores($idEmpresa);

		if (!empty($trabajadores)) {

			$actualizarPlan = $this->PlanTrabajador->hasPlan(current($trabajadores)->id_trabajador);
			if ($actualizarPlan) {
				foreach ($trabajadores as $key => $trabajador) {
					$data['id_plan'] = $idPlan;
					$data['id_trabajador'] = $trabajador->id_trabajador;
	
					$this->PlanTrabajador->actualizarPlan($idPlan, $trabajador->id_trabajador);
				}
				
			} else {
				foreach ($trabajadores as $key => $trabajador) {
					$data['id_plan'] = $idPlan;
					$data['id_trabajador'] = $trabajador->id_trabajador;
	
					$this->PlanTrabajador->asignarPlan($data);
				}
				$filas = $this->PagoEmp->getValidationE($idEmpresa);
				if ($filas == 0) {
					$fechaActual = new DateTime();
					$fecha_pago = clone $fechaActual; // Clonar la fecha actual para no modificarla directamente
					$fecha_pago->modify('+1 month');
					$resultado = getMontoTotalEmp($idEmpresa);
					$monto_total = $resultado["monto_total"];
					$vdata["id_empresa"] = $idEmpresa;
					$vdata["id_plan"] = $idPlan;
					$vdata["monto_total"] = $monto_total;
					$vdata["fecha_pago"] = $fecha_pago->format('Y-m-d');
					$this->PagoEmp->insertPagoEmp($vdata);
				}

			}

			$alerta = array(
				'status' => true,
				'title' => "Plan Asignado Exitosamente.",
				'message' => 'Asigando Con Exito'
			);
		} else {
			$alerta = array(
				'status' => false,
				'title' => 'Asignar trabajadores.',
				'message' => 'La empresa no cuenta con trabajadores asignados en este momento.'
			);
		}
		$this->session->set_flashdata('alerta', $alerta);
		redirect('CEmpresa/consultarEmpresas', 'refresh');
	}
}