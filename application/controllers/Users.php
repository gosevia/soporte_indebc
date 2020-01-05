<?php
    class Users extends CI_Controller{
        public function index(){
            $this->load->view('header');
            $this->load->view('login');
            $this->load->view('footer');
        }
        public function view_register(){
            $this->load->view('header');
            $this->load->view('register');
            $this->load->view('footer');
        }
        public function password($id){
            if(!$this->session->userdata('logged_in')){
                redirect(base_url());
            }
            $data['user'] = $this->user_model->getUsuarioInfo($id);
            $this->load->view('header');
            $this->load->view('password', $data);
            $this->load->view('footer');
        }
        public function verify(){
            if(!$this->session->userdata('logged_in')){
                redirect(base_url());
            }
            $data['user'] = $this->user_model->getUsuarioInfo($this->session->userdata['user_id']);
            if(empty($_POST['actual']) || empty($_POST['nuevo']) || empty($_POST['confirmar'])){
                $this->session->set_flashdata('password_change', 'Necesita llenar los 3 campos correctamente para cambiar contraseña.');
                redirect(base_url().'index.php/users/password/'.$this->session->userdata['user_id']);
            }
            if($data['user'][0]->{'password'} == md5($_POST['actual'])){
                if($_POST['nuevo'] == $_POST['confirmar']){
                    $password = md5($this->input->post('nuevo'));
                    $this->user_model->setPassword($this->session->userdata['user_id'], $password);
                    $this->session->set_flashdata('password_changed', 'Se ha cambiado su contraseña exitosamente. Vuelva a ingresar con los datos nuevos.');
                    redirect(base_url());     
                }else{
                    $this->session->set_flashdata('no_match', 'Su nueva contraseña debe ser igual para los últimos 2 campos.');
                    redirect(base_url().'index.php/users/password/'.$this->session->userdata['user_id']);
                }
            }else{
                $this->session->set_flashdata('wrong_password', 'Su contraseña actual no es correcta. Vuelva a intentar.');
                redirect(base_url().'index.php/users/password/'.$this->session->userdata['user_id']);
            }
        }
        public function register(){
            if(isset($_POST['cancelar'])){
                redirect(base_url());
            }else{
                $this->form_validation->set_rules('nombre', 'Nombre', 'callback_custom_required[nombre]');
                $this->form_validation->set_rules('apellido', 'Apellido', 'callback_custom_required[apellido]');
                $this->form_validation->set_rules('correo', 'Correo', 'trim|callback_custom_required[correo]|valid_email|callback_check_correo_exists');
                $this->form_validation->set_rules('password', 'Contraseña', 'callback_custom_required[password]');
                $this->form_validation->set_rules('confirm', 'Confirmar Contraseña', 'callback_custom_required[confirm]|matches[password]');
                $this->form_validation->set_rules('area', 'Área', 'callback_custom_required[area]');
                $this->form_validation->set_rules('edificio', 'Edificio', 'callback_custom_required[edificio]');
                if($this->form_validation->run() === FALSE){
                    $this->load->view('header');
		            $this->load->view('register');
		            $this->load->view('footer');          
                }else{
                    $enc_password = md5($this->input->post('password'));
                    $this->user_model->register($enc_password);
                    $this->session->set_flashdata('user_registered', 'Se ha registrado con exito! Un administrador le activará la cuenta en breve, para que pueda iniciar sesión.');
                    $this->sendEmailNotification();
                    redirect(base_url());
                }
            }
        }
        public function sendEmailNotification(){
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'mail.indebc.gob.mx',
                'smtp_port' => 465,
                'smtp_user' => 'sistemas@indebc.gob.mx',
                'smtp_pass' => 'jias19arenas',
                'mailtype'  => 'html', 
                'charset'   => 'utf-8'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            
            $this->email->from('sistemas@indebc.gob.mx', 'Solicitante');
            $this->email->to('soporte@indebc.gob.mx');
            $this->email->subject('Sistema de soporte técnico: Nueva cuenta creada!');
            $this->email->message('Se ha creado una nueva cuenta. Entre al sistema para activar la nueva cuenta del solicitante y asignarle un rol.');
            $this->email->send();
        }
        public function login(){
            if(isset($_POST['registro'])){
                redirect(base_url().'index.php/users/view_register');
            }else{
                $this->form_validation->set_rules('rfc', 'RFC', 'callback_custom_required[rfc]');
                $this->form_validation->set_rules('password', 'Password', 'callback_custom_required[password]');
                if($this->form_validation->run() === FALSE){
                    $this->load->view('header');
		            $this->load->view('login');
		            $this->load->view('footer');
                }else{
                    // Obtener rfc
                    $rfc = $this->input->post('rfc');
                    // Obtener password y cifrar
                    $password = md5($this->input->post('password'));
                    // Iniciar usuario
                    $user_id = $this->user_model->login($rfc, $password);
                    // Revisar si la cuenta está activa
                    $active_user = $this->user_model->getUserStatus($user_id);
                    if(!$user_id){
                        $this->session->set_flashdata('login_failed', 'Su información no es válida. Intente de nuevo.');
                        redirect(base_url());
                    }
                    if($active_user == 0){
                        $this->session->set_flashdata('inactive_account', 'Su cuenta aún no ha sido activada o fue suspendida por un administrador.');
                        redirect(base_url());
                    }
                    if($user_id){
                        $user = $this->user_model->getUsuarioId($rfc);
                        //$GLOBALS['id'] = $user[0]->idUsuario;
                        $user_data = array(
                            'user_id' => $user[0]->idUsuario,
                            'logged_in' => true,
                            'currentReporte' => 0
                        );
                        $this->session->set_userdata($user_data);
                        $this->user_model->updateLogin($this->session->userdata['user_id']);
                        if($user[0]->tipoUsuario == '2'){
                            redirect(base_url().'index.php/solicitante/iniciar/'.$this->session->userdata['user_id']);
                        }else{
                            redirect(base_url().'index.php/admin/iniciar/'.$this->session->userdata['user_id']);
                        }
                    }
                }
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
                case 'area':
                    $this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo Área o Departamento.');
                    return (trim($str) == '') ? FALSE : TRUE;
                    break;
                case 'edificio':
                    $this->form_validation->set_message('custom_required', 'Se requiere un valor en el campo Edificio.');
                    return (trim($str) == '') ? FALSE : TRUE;
                    break;    
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
    }
