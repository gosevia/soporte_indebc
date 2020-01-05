<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitante extends CI_Controller {
	private $id;

	public function index(){
		$this->load->view('header');
		$this->load->view('solicitante');
		$this->load->view('footer');
	}
	public function iniciar($id){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		$data['user'] = $this->solicitud_model->getUsuarioInfo($id);
		$data['reportes'] = $this->solicitud_model->getReportes($id);
		$data['default_problema'] = '';
		$data['text'] = '';
		$data['default_instalacion'] = $data['user']->{'idInstalacion'};
		$this->$id = $data['user']->{'idUsuario'};
		$this->load->view('header');
		$this->load->view('solicitante', $data);
		$this->load->view('footer');
	}
	public function solicitud(){ // Cuando se realiza un POST del form para registrar reporte
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		if(isset($_POST['nuevo'])){
			$data['default_problema'] = '';
			$data['text'] = '';
			$data['default_instalacion'] = '';
			redirect(base_url()."index.php/solicitante/iniciar/".$this->session->userdata['user_id']);
		}else{
			if(isset($_POST['problema']) || isset($_POST['textarea']) || isset($_POST['instalacion'])){
				$data['default_problema'] = $_POST['problema'];
				$data['text'] = $_POST['textarea'];
				$data['default_instalacion'] = $_POST['instalacion'];
			}
			$data['reportes'] = $this->solicitud_model->getReportes($this->session->userdata['user_id']);
			$data['user'] = $this->solicitud_model->getUsuarioInfo($this->session->userdata['user_id']);
			$this->form_validation->set_rules('problema', 'Tipo de servicio', 'callback_custom_required[idtipoDeServicio]');
			$this->form_validation->set_rules('textarea', 'Reporte', 'callback_custom_required[reporteUsuario]');
			$this->form_validation->set_rules('instalacion', 'Instalación', 'callback_custom_required[idInstalacion]');
			if($this->form_validation->run() === FALSE || empty($_POST['problema'])){
				$this->session->set_flashdata('llenar_campos', 'Llene todos los campos para poder guardar el reporte.');
				$this->load->view('header');
				$this->load->view('solicitante', $data);
				$this->load->view('footer');          
			}else{
				$data = array();
				// If file upload form submitted
				if(!empty($_FILES['files']['name'])){
					$filesCount = count($_FILES['files']['name']);
					for($i = 0; $i < $filesCount; $i++){
						$_FILES['file']['name'] = $_FILES['files']['name'][$i];
						$_FILES['file']['type'] = $_FILES['files']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['files']['error'][$i];
						$_FILES['file']['size'] = $_FILES['files']['size'][$i];
						
						// File upload configuration
						$uploadPath =  'uploads/files/';
						$config['upload_path'] = $uploadPath;
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						
						// Load and initialize upload library
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						
						// Upload file to server
						if($this->upload->do_upload('file')){
							// Uploaded file data
							$fileData = $this->upload->data();
							$reporte = $this->solicitud_model->getLastReporteId();
							$reporteId = $reporte[0]['idReporte'];
							$reporteId += 1;
							$uploadData[$i]['idReporte'] = $reporteId;
							$uploadData[$i]['file_name'] = $fileData['file_name'];
							$uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");
						}
					}
					if(!empty($uploadData)){
						// Insert files data into the database
						$insert = $this->solicitud_model->subirArchivos($uploadData);
					}
				}
				$this->solicitud_model->guardarReporte($this->session->userdata['user_id']);
				$this->sendEmailNotification();
				$result = $this->solicitud_model->getLastReporteId();
				$folio = $result[0]['idReporte'];
				$message = 'Se ha guardado su reporte con número de folio: '.$folio.'. En breve se atenderá a su problema.';
				$this->session->set_flashdata('reporte_guardado', $message);
				redirect(base_url()."index.php/solicitante/iniciar/".$this->session->userdata['user_id']);
			}
		}
	}
	public function sendEmailNotification(){
		$result = $this->solicitud_model->getLastReporteId();
		$folio = $result[0]['idReporte'];
		$idUsuario = $result[0]['idUsuario'];
		$idInstalacion = $result[0]['idInstalacion'];
		$instalacion = "";
		switch($idInstalacion){
			case 1: $instalacion = "CAR Tijuana"; break;
			case 2: $instalacion = "CD Deportiva Mexicali"; break;
			case 3: $instalacion = "CAR Ensenada"; break;
			case 4: $instalacion = "KM43"; break;
			case 5: $instalacion = "CAR San Felipe"; break; 
		}
		$user = $this->solicitud_model->getUsuarioInfo($idUsuario);
		$name = $user->displayName;
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
		$this->email->from('sistemas@indebc.gob.mx', 'Solicitante');
		$this->email->to('soporte@indebc.gob.mx');
		/*  
		$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');
		*/
		$subject = "Nueva orden de servicio! Instalación: ".$instalacion.". Folio: ".$folio." ";
		$message = $name." ha creado una nueva solicitud. Entre al sistema para ver los detalles.";
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
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
	function custom_required($str, $func){
		if(!$this->session->userdata('logged_in')){
			redirect(base_url());
		}
		switch($func) {
			case 'idtipoServicio':
				$this->form_validation->set_message('custom_required', 'Por favor seleccione un tipo de problema.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'reporteUsuario':
				$this->form_validation->set_message('custom_required', 'Por favor redacte una breve descripción de su problema.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;
			case 'idInstalacion':
				$this->form_validation->set_message('custom_required', 'Por favor seleccione una instalación.');
				return (trim($str) == '') ? FALSE : TRUE;
				break;    
		}
	}
}
