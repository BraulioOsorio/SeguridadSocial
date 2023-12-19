<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CPago extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('datos_pago_emp');
		$this->load->model('PagoEmp');
		$this->load->model('PagoInde');
		$this->load->model('Empresa');
		$this->load->model('Independiente');
        $this->load->model('PlanTrabajador');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('phpmailer_lib');
    }

    public function selectPago() {
        // verificar si la session sigue activa
        if (!$this->session->userdata('user_id')) {
            redirect('/CUsuario');
        }

        $this->load->view('Pagos/selectPago');
    }

    public function filtrarPago($tipo) {
        if (!$this->session->userdata('user_id')) {
            redirect('/CUsuario');
        }
        
        $data['tipo'] = $tipo;
        $this->load->view('Pagos/buscarPago',$data);
    }

    public function estadoPago() {
        $vdata["nit"] = $vdata["documento"] = "";
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $tipo = $this->input->post('tipo');
            if ($tipo == 'empresa') {
                $vdata["nit"] = $this->input->post('nit');
                $empresa = $this->Empresa->selectNit($vdata["nit"]);
                if (!empty($empresa)) {
                    $ultimoPago = $this->PagoEmp->getUltimoPago($empresa->id_empresa);
                    if(!empty($ultimoPago)){
                        $getFechaActual = new DateTime();
                        $fecha_actual = $getFechaActual->format('Y-m-d');

                        $dataT["trabajadores"] = $this->Independiente->getTrabajadores($empresa->id_empresa);
                        $primerRegistro = $dataT["trabajadores"][0]; 
                        $idTrabajador = $primerRegistro->id_trabajador;

                        $resultados = $this->PlanTrabajador->findPlanTra($idTrabajador);


                        if(!empty($resultados)){
                            $idPlan = $resultados[0]->id_plan;
                            $fecha_db = new DateTime($ultimoPago[0]->fecha_pago);
                            $fecha_db->add(new DateInterval('P1M')); // Suma 1 mes
    
                            $fecha_pago = $fecha_db->format('Y-m-d');
    
                            $fechadb = $ultimoPago[0]->fecha_pago;
    
                            $resultado = getMontoTotalEmp($empresa->id_empresa);
                            $monto_total = $resultado["monto_total"];
    
                            if ($fechadb < $fecha_actual || $ultimoPago[0]->estado_pago == 1) {
                                $data["id_empresa"] = $empresa->id_empresa;
                                $data["id_plan"] = $idPlan;
                                $data["monto_total"] = $monto_total;
                                $data["fecha_pago"] = $fecha_pago;
                                $this->PagoEmp->insertPagoEmp($data);
                            }
                        }                        
                    }

                    $dataPago = $this->PagoEmp->findPagoE($vdata["nit"]);
                    if (!empty($dataPago)) {
    
                        $estado["estadoPago"] = $dataPago;
                        $this->load->view('Pagos/estadoPagoE',$estado);
                    }else {
                        $alerta = array(
                            "mensaje" =>  "La empresa no tiene un plan asignado para pagar",
                            "color" => "warning"
                        );
                        $this->session->set_flashdata('alertaa', $alerta);
                        redirect('buscar-pago/empresa','refresh');
                    }
                }else{
                    $alerta = array(
                        "mensaje" =>  "El NIT de la empresa no fue encontrado, verifique de nuevo.",
                        "color" => "danger"
                    );
                    $this->session->set_flashdata('alertaa', $alerta);
                    redirect('buscar-pago/empresa','refresh');
                }
            }else{
                $vdata["documento"] = $this->input->post('documento');
                $persona = $this->Independiente->getIndependienteByDoc($vdata["documento"]);
                if (!empty($persona)) {
                    $ultimoPago = $this->PagoInde->getUltimoPago($persona->id_trabajador);
                    if (!empty($ultimoPago)) {
                        $getFechaActual = new DateTime();
                        $fecha_actual = $getFechaActual->format('Y-m-d');

                        $resultados = $this->PlanTrabajador->findPlanTra($persona->id_trabajador);
                        if(!empty($resultados)){
                            $idPlan = $resultados[0]->id_plan;
                            $fecha_db = new DateTime($ultimoPago[0]->fecha_pago);
                            $fecha_db->add(new DateInterval('P1M')); // Suma 1 mes
    
                            $fecha_pago = $fecha_db->format('Y-m-d');
    
                            $fechadb = $ultimoPago[0]->fecha_pago;
    
    
                            $resultado = getMontoTotalInde($persona->id_trabajador, $idPlan);
                            $monto_total = $resultado["monto_total"];
    
                            if ($fechadb < $fecha_actual || $ultimoPago[0]->estado_pago == 1) {
                                $data["id_trabajador"] = $persona->id_trabajador;
                                $data["id_plan"] = $idPlan;
                                $data["monto_total"] = $monto_total;
                                $data["fecha_pago"] = $fecha_pago;
                                $this->PagoInde->insertPagoI($data);

                               //  \_( ._.)_/   -(.I.)-  \_(._. )_/
                            }
                        }
                    }
                    $dataPago = $this->PagoInde->findPagoI($vdata["documento"]);
                    if (!empty($dataPago)) {   
                        $estado["estadoPago"] = $dataPago;
                        $this->load->view('Pagos/estadoPagoI',$estado);
                    }else {
                        $alerta = array(
                            "mensaje" =>  "El trabajador no tiene un plan asignado",
                            "color" => "warning"
                        );
                        $this->session->set_flashdata('alertaa', $alerta);
                        redirect('buscar-pago/persona','refresh');
                    }               
                }else {
                    $alerta = array(
                        "mensaje" =>  "EL trabajador no existe en el sistema",
                        "color" => "warning"
                    );
                    $this->session->set_flashdata('alertaa', $alerta);
                    redirect('buscar-pago/persona','refresh');
                }
            }
        }
    }

    public function indePago() {
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            if (empty($this->input->post('dineroRecibido'))) {
                $alerta = array(
                    "mensaje" =>  "Debe ingresar un monto a recibir",
                    "color" => "warning"
                );
                $this->session->set_flashdata('alertaa', $alerta);
                redirect('buscar-pago/persona','refresh');
            }

            $dineroRecibido = $this->input->post('dineroRecibido');
            // Filtrar solo dígitos y el punto decimal
            $dineroRecibido = filter_var($dineroRecibido, FILTER_SANITIZE_NUMBER_FLOAT);
            // Convertir a float
            $dineroRecibido = floatval($dineroRecibido);
            $monto = floatval($this->input->post('monto'));
            $vdata["dineroRecibido"] = $dineroRecibido;
            $vdata["monto"] = $monto;

            $vdata["trabajador"] = $this->input->post('trabajador');
            $vdata["plan"] = $this->input->post('plan');
            $vdata["fecha"] = $this->input->post('fecha');
            $correoTrabajador = $this->input->post('correo');
            // Cálculo
            $vdata["devuelta"] = $vdata["dineroRecibido"] - $vdata["monto"];
            if ($dineroRecibido < $monto) {
                $alerta = array(
                    "mensaje" =>  "Monto insuficiente",
                    "color" => "warning"
                );
                $this->session->set_flashdata('alertaa', $alerta);
                redirect('buscar-pago/persona','refresh');
            } else{
                $id_pago_in = $this->input->post('id_pago_in');
                $this->PagoInde->updateEstadoPagoI($id_pago_in);

                // enviando correo de confirmacion
                $infoCorreo = array(
                    "destinatario" => $correoTrabajador,
                    "datos_pago" => $vdata
                );

                $correoEnviado = $this->enviarEmail($infoCorreo);
                if ($correoEnviado) {
                    $alertaCorreo = array(
                        "mensaje" =>  "Se ha enviado un correo de confirmación.",
                        "color" => "success"
                    );
                } else {
                    $alertaCorreo = array(
                        "mensaje" =>  "Problemas al enviar correo, verifica que tu correo exista.",
                        "color" => "warning"
                    );
                }
                
                $this->session->set_flashdata('alertaCorreo', $alertaCorreo);
                $this->load->view('Pagos/factura',$vdata);
            }
        }
    }

    public function empPago() {
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            if (empty($this->input->post('dineroRecibido'))) {
                $alerta = array(
                    "mensaje" =>  "Debe ingresar un monto a recibir",
                    "color" => "warning"
                );
                $this->session->set_flashdata('alertaa', $alerta);
                redirect('buscar-pago/empresa','refresh');
            }
            $dineroRecibido = $this->input->post('dineroRecibido');
            // Filtrar solo dígitos y el punto decimal
            $dineroRecibido = filter_var($dineroRecibido, FILTER_SANITIZE_NUMBER_FLOAT);
            // Convertir a float
            $dineroRecibido = floatval($dineroRecibido);
            $monto = floatval($this->input->post('monto'));
            $vdata["dineroRecibido"] = $dineroRecibido;
            $vdata["monto"] = $monto;


            $vdata["empresa"] = $this->input->post('empresa');
            $vdata["plan"] = $this->input->post('plan');
            $vdata["fecha"] = $this->input->post('fecha');
            $correoEmpresa = $this->input->post('correo');
            //calculo
            $vdata["devuelta"] = $vdata["dineroRecibido"] - $vdata["monto"];
            if ($dineroRecibido < $monto) {
                $alerta = array(
                    "mensaje" =>  "Monto insuficiente",
                    "color" => "warning"
                );
                $this->session->set_flashdata('alertaa', $alerta);
                redirect('buscar-pago/empresa','refresh');
            } else{
                $id_pago_em = $this->input->post('id_pago_em');
                $this->PagoEmp->updateEstadoPagoEmp($id_pago_em);

                // enviando correo de confirmacion
                $infoCorreo = array(
                    "destinatario" => $correoEmpresa,
                    "datos_pago" => $vdata
                );

                $correoEnviado = $this->enviarEmail($infoCorreo);
                if ($correoEnviado) {
                    $alertaCorreo = array(
                        "mensaje" =>  "Se ha enviado un correo de confirmación.",
                        "color" => "success"
                    );
                } else {
                    $alertaCorreo = array(
                        "mensaje" =>  "Problemas al enviar correo, verifica que tu correo exista.",
                        "color" => "warning"
                    );
                }
                
                
                $this->session->set_flashdata('alertaCorreo', $alertaCorreo);
                $this->load->view('Pagos/factura',$vdata);
            }
        }
    }

    public function enviarEmail($infoCorreo) {
        $mail = $this->phpmailer_lib->load();
        $mail->ClearAddresses();
        $mail->ClearAttachments();
        $mail->isSMTP();

        // configuracion servidor smtp
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kmma407@gmail.com'; 
        $mail->Password = 'ojljbfmwtntvwltv'; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465; 

        $mail->setFrom('kmma407@gmail.com', 'Integrando Pagos');
        $mail->addAddress($infoCorreo['destinatario']);
        $mail->Subject = "Pago de seguridad social exitoso";
        $mail->isHTML(true);
        $email_content = $this->load->view("Pagos/contenidoCorreo.php",$infoCorreo['datos_pago'], true);
        $mail->Body = $email_content;

        $enviado = false;
        if ($mail->send()) {
            $enviado = true;
        }
        return $enviado;
    }
}
