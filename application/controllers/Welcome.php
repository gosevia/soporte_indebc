<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){
		$data = array('datos' => '');
		$this->load->view('header');
		//$data['datos'] = $this->solicitud_model->getUsuarios();
		$this->load->view('login', $data);
		$this->load->view('footer');
	}
}
