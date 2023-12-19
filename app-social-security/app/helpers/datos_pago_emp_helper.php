<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance(); // Obtener la instancia de CodeIgniter

// Cargar modelos
$CI->load->model('Empresa');
$CI->load->model('Plan');
$CI->load->model('PlanTrabajador');
$CI->load->model('Independiente');

if (!function_exists('getMontoTotalEmp')) {
    function getMontoTotalEmp($id_empresa) {
        // Obtener la instancia de CodeIgniter en el helper
        $CI =& get_instance();

		$data["trabajadores"] = $CI->Independiente->getTrabajadores($id_empresa);
		$total = 0;
		$monto_total = 0;
		if(!empty($data["trabajadores"])){
			$primerRegistro = $data["trabajadores"][0]; 
			$id = $primerRegistro->id_trabajador;
			
			$resultados = $CI->PlanTrabajador->findPlanTra($id);
			
			if(!empty($resultados)){
				$priResult =  $resultados[0];
				
				if(isset($priResult)){
					$dataPlan = $CI->Plan->findPlan($priResult->id_plan);
					if(isset($dataPlan)){
						foreach ($data["trabajadores"] as $key => $trabajador) {
							$totalSalud = $trabajador->salario*($dataPlan->porcentaje_salud/100);
							$totalPension = $trabajador->salario*($dataPlan->porcentaje_pension/100);
							$totalArl = $trabajador->salario*($dataPlan->porcentaje_arl/100);
							$total = $totalSalud + $totalPension + $totalArl;
							$data["trabajadores"][$key]->totalPago = $total;
							$monto_total += $total;
						}
					}
				}
			}
		}

		return array("monto_total" => $monto_total, "data" => $data);
		
	}
}


if (!function_exists('getMontoTotalInde')) {
    function getMontoTotalInde($id_independiente, $id_plan) {
        // Obtener la instancia de CodeIgniter en el helper
        $CI =& get_instance();

		$data = $CI->Independiente->getIndependiente($id_independiente);
		$total = 0;
		if(!empty($data)){ 
			$dataPlan = $CI->Plan->findPlan($id_plan);
			if(isset($dataPlan)){
				$totalSalud = $data->salario*($dataPlan->porcentaje_salud/100);
				$totalPension = $data->salario*($dataPlan->porcentaje_pension/100);
				$totalArl = $data->salario*($dataPlan->porcentaje_arl/100);
				$total = $totalSalud + $totalPension + $totalArl;
			}
		}

		return array("monto_total" => $total);
		
	}
}



