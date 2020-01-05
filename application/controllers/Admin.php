<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	private $id;
	public $filtro;

	public function index(){
		$this->load->view('header');
		$this->load->view('admin');
		$this->load->view('footer');
    }
	public function iniciar($id){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['seguimiento'] = null;
		$data['detalle'] = null;
		$data['historial'] = null;
		$data['user'] = $this->admin_model->getUsuarioInfo($id);
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$data['reportes'] = $this->admin_model->getReportes();
		$data['admin'] = $this->admin_model->getAdminInfo();
        $this->$id = $data['user']->{'idUsuario'};
		$this->load->view('header');
		$this->load->view('admin', $data);
		$this->load->view('footer');
	}
	public function solicitantes($id){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['seguimiento'] = null;
		$data['detalle'] = null;
		$data['historial'] = null;
		$data['user'] = $this->admin_model->getUsuarioInfo($id);
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$data['admin'] = $this->admin_model->getAdminInfo();
        $this->$id = $data['user']->{'idUsuario'};
		$this->load->view('header');
		$this->load->view('admin_solicitantes', $data);
		$this->load->view('footer');
	}
	public function soporte(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['editar'] = null;
		$data['detalle'] = null;
		$data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['soporte'] = $this->admin_model->getSoporte();
		$this->load->view('header');
		$this->load->view('usuarios_soporte', $data);
		$this->load->view('footer');
	}
	public function data(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['p1'] = null; 
		$data['p2'] = null;
		$data['p3'] = null;
		$data['p4'] = null;
		$data['filtro'] = null;
		$data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['soporte'] = $this->admin_model->getSoporte();
		$data['reportes'] = $this->admin_model->getReportes();
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$this->load->view('header');
		$this->load->view('data', $data);
		$this->load->view('footer');
	}
	public function filtrar(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['soporte'] = $this->admin_model->getSoporte();
		$data['reportes'] = $this->admin_model->getReportes();
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$datestring = $_POST['start'];
		$timestamp = strtotime($datestring);
		$d1 = date('Y-m-d H:i:s', $timestamp);
		$data['startDate'] = $d1;
		$datestring = $_POST['end'];
		$timestamp = strtotime($datestring);
		$d2 = date('Y-m-d H:i:s', $timestamp);
		$data['endDate'] = $d2;
		$data['filtro'] = $this->admin_model->getByDate($_POST['filtrar'], $_POST['instalaciones'], $d1, $d2); 
		$data['p1'] = $_POST['filtrar']; 
		$data['p2'] = $_POST['instalaciones'];
		$data['p3'] = $d1;
		$data['p4'] = $d2;
		$this->load->view('header');
		$this->load->view('data', $data);
		$this->load->view('footer');
	}
	public function html_to_pdf($p1, $p2, $p3, $p4){
		// guardar chart img en servidor para despues incluir en el reporte
		$chart = $_POST['imgCode'];
		list($type, $chart) = explode(';', $chart);   
		list(, $chart) = explode(',', $chart);
		$chart = base64_decode($chart);
		file_put_contents('uploads/files/chartReporte.png', $chart);
		$data['startDate'] = $p3;
		$data['endDate'] = $p4;
		$data['filtro'] = $this->admin_model->getByDate($p1, $p2, $p3, $p4);
		$this->load->view('pdfDataView', $data);
		$html = $this->output->get_output();
		$this->load->library('pdf');
		$this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream("estadisticas_Sistema_de_Soporte_INDEBC.pdf", array("Attachment"=>0));
    }
	public function crear($id){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['historial'] = null;
		$data['user'] = $this->admin_model->getUsuarioInfo($id);
		$this->$id = $data['user']->{'idUsuario'};
		$this->load->view('header');
		$this->load->view('register', $data);
		$this->load->view('footer');          
	}
	public function registrar(){
		if(isset($_POST['cancelar'])){
			redirect(base_url().'index.php/admin/iniciar/'.$this->session->userdata['user_id']);
		}else{
			$data['user'] = $data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
			$this->form_validation->set_rules('nombre', 'Nombre', 'callback_custom_required[nombre]');
			$this->form_validation->set_rules('apellido', 'Apellido', 'callback_custom_required[apellido]');
			$this->form_validation->set_rules('correo', 'Correo', 'trim|callback_custom_required[correo]|valid_email|callback_check_correo_exists');
			$this->form_validation->set_rules('password', 'Contraseña', 'callback_custom_required[password]');
			$this->form_validation->set_rules('confirm', 'Confirmar Contraseña', 'callback_custom_required[confirm]|matches[password]');
			$this->form_validation->set_rules('telefono', 'Teléfono', 'callback_custom_required[telefono]');
			if($this->form_validation->run() === FALSE){
				$this->load->view('header');
				$this->load->view('register', $data);
				$this->load->view('footer');          
			}else{
				$enc_password = md5($this->input->post('password'));
				$this->admin_model->register($enc_password);
				$this->session->set_flashdata('user_registered', 'Se ha creado un nuevo usuario.');
				redirect(base_url().'index.php/admin/iniciar/'.$this->session->userdata['user_id']);
			}
		}
	}
	function check_correo_exists($correo){
		$this->form_validation->set_message('check_correo_exists', 'Este correo ya está registrado. Por favor elija otro.');
		if($this->user_model->check_correo_exists($correo)){
			return true;
		}else{
			return false;
		}
	}
	function custom_required($str, $func){
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		switch($func) {
			case 'cambiar':
				$this->form_validation->set_message('custom_required', 'Se requiere llenar los 3 campos para cambiar contraseñas.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'nombre':
				$this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo Nombre.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'apellido':
				$this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo Apellido.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'correo':
				$this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo Correo Electrónico.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'rfc':
				$this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo RFC.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'password':
				$this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo Contraseña.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'confirm':
				$this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo Confirmar Contraseña.');
				return (trim($str) == '') ? FALSE : TRUE;
				break; 
			case 'telefono':
			$this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo de Teléfono.');
			return (trim($str) == '') ? FALSE : TRUE;
			break; 
		}
	}
	public function historial($id){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['historial'] = null;
		$data['seguimiento'] = $this->admin_model->getHistorial();
		$data['user'] = $this->admin_model->getUsuarioInfo($id);
		$data['admin'] = $this->admin_model->getAdminInfo();
        $this->$id = $data['user']->{'idUsuario'};
		$this->load->view('header');
		$this->load->view('historial', $data);
		$this->load->view('footer');
	}
	public function detalleSolicitante(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['detalle'] = $this->admin_model->getSolicitanteInfo($_POST['detalle']);
		$data['seguimiento'] = null;
		$data['historial'] = null;
		$data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$data['admin'] = $this->admin_model->getAdminInfo();
		$this->load->view('header');
		$this->load->view('admin_solicitantes', $data);
		$this->load->view('footer');
	}
	public function editarSolicitante(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['detalle'] = null;
		$data['historial'] = null;
		$data['seguimiento'] = $this->admin_model->getSolicitanteInfo($_POST['detalle']);
        $data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$data['admin'] = $this->admin_model->getAdminInfo();
		$this->load->view('header');
		$this->load->view('admin_solicitantes', $data);
		$this->load->view('footer');
	}
	public function actualizarSolicitante(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		if(isset($_POST['cancelar'])){
			redirect(base_url().'index.php/admin/solicitantes/'.$this->session->userdata['user_id']);
		}
		$this->admin_model->actualizarSolicitante($_POST['detalle'], $_POST['rol'], $_POST['estatus']);
		$this->session->set_flashdata('update_client', 'Se han actualizado los datos del solicitante.');
		redirect(base_url().'index.php/admin/solicitantes/'.$this->session->userdata['user_id']);
    }
    public function detalleReporte(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		if(isset($_POST['detalle'])){
			$this->session->set_userdata('currentReporte', $_POST['detalle']);
		}
		$data['detalle'] = $this->admin_model->getReporte($this->session->userdata['currentReporte']);
		$data['historial'] = $this->admin_model->getHistorial();
		$data['seguimiento'] = null;
		if(empty($data['detalle'][0]['fechaLecturaSoporte'])){
			$this->admin_model->lecturaReporte($this->session->userdata['currentReporte']);
		}
		$data['files'] = $this->solicitud_model->obtenerArchivos($data['detalle'][0]['idReporte']);
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['reportes'] = $this->admin_model->getReportes();
		$data['admin'] = $this->admin_model->getAdminInfo();
		$this->load->view('header');
		$this->load->view('admin', $data);
		$this->load->view('footer');
	}
	public function seguimientoReporte(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		if(isset($_POST['cerrar'])){
			redirect(base_url().'index.php/admin/iniciar/'.$this->session->userdata['user_id']);
		}
		$data['detalle'] = null;
		$data['historial'] = $this->admin_model->getHistorial();
		$data['solicitantes'] = $this->admin_model->getSolicitantes();
		$data['seguimiento'] = $this->admin_model->getReporte($_POST['detalle']);
		$data['files'] = $this->solicitud_model->obtenerArchivos($this->session->userdata['currentReporte']);
        $data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['reportes'] = $this->admin_model->getReportes();
		$data['admin'] = $this->admin_model->getAdminInfo();
		$this->load->view('header');
		$this->load->view('admin', $data);
		$this->load->view('footer');
	}
	public function actualizarReporte(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		if(isset($_POST['cancelar'])){
			redirect(base_url().'index.php/admin/detalleReporte');
		}
		$this->admin_model->actualizarReporte($_POST['detalle'], $_POST['textdiagnostico'], $_POST['textsolucion'], $this->session->userdata['user_id']);
		$this->sendEmailNotification($_POST['detalle'], $this->session->userdata['user_id']);
		$this->session->set_flashdata('update_report', 'Se ha actualizado el reporte.');
		redirect(base_url().'index.php/admin/detalleReporte');
	}
	public function detalleSoporte(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['detalle'] = $this->admin_model->getSolicitanteInfo($_POST['detalle']);
		$data['editar'] = null;
		$data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['soporte'] = $this->admin_model->getSoporte();
		$data['admin'] = $this->admin_model->getAdminInfo();
		$this->load->view('header');
		$this->load->view('usuarios_soporte', $data);
		$this->load->view('footer');
	}
	public function editarSoporte(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['detalle'] = null;
		$data['editar'] = $this->admin_model->getSolicitanteInfo($_POST['detalle']);
        $data['user'] = $this->admin_model->getUsuarioInfo($this->session->userdata['user_id']);
		$data['soporte'] = $this->admin_model->getSoporte();
		$data['admin'] = $this->admin_model->getAdminInfo();
		$this->load->view('header');
		$this->load->view('usuarios_soporte', $data);
		$this->load->view('footer');
	}
	public function actualizarSoporte(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		if(isset($_POST['cancelar'])){
			redirect(base_url().'index.php/admin/soporte');
		}
		$this->admin_model->actualizarSoporte($_POST['detalle'], $_POST['correo'], $_POST['nombre'], $_POST['instalacion'], $_POST['telefono'], $_POST['estatus']);
		$this->session->set_flashdata('update_soporte', 'Se han actualizado los datos de la cuenta de soporte.');
		redirect(base_url().'index.php/admin/soporte');
    }
	public function logout(){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		// Eliminar datos de usuario
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('logged_in');
		$this->session->set_flashdata('user_loggedout', 'Se ha cerrado la sessión.');
		redirect(base_url());
	}
	public function sendEmailNotification($folio, $userId){
		$user = $this->solicitud_model->getUsuarioInfo($userId);
		$idInstalacion = $user->idInstalacion;
		$name = $user->displayName;
		$instalacion = "";
		switch($idInstalacion){
			case 1: $instalacion = "CAR Tijuana"; break;
			case 2: $instalacion = "CD Deportiva Mexicali"; break;
			case 3: $instalacion = "CAR Ensenada"; break;
			case 4: $instalacion = "KM43"; break;
			case 5: $instalacion = "CAR San Felipe"; break; 
		}
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.indebc.gob.mx',
			'smtp_port' => 465,
			'smtp_user' => 'sistemas@indebc.gob.mx',
			'smtp_pass' => 'jias19arenas',
			'smtp_crypto' => 'ssl',
			'mailtype'  => 'html', 
			'charset'   => 'utf-8'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('sistemas@indebc.gob.mx', 'Soporte');
		$this->email->to('soporte@indebc.gob.mx');
		/*  
		$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');
		*/
		$subject = "Seguimiento realizado! Instalación: ".$instalacion.".";
		$message = $name." le ha dado seguimiento a la solicitud ".$folio.".";
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
	}
}
