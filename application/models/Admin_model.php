<?php
class Admin_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
	public function register($enc_password){
		// Crear arreglo con datos del form para registrar usuario
		$nombre = $this->input->post('nombre');
		$apellido = $this->input->post('apellido');
		$nombre_completo = $nombre.' '.$apellido;
		$direccion = 0;
		$data = array(
			'accountName' => $this->input->post('correo'),
			'displayName' => $nombre_completo,
			'password' => $enc_password,
			'area' => '0',
			'direccion' => $direccion,
			'idInstalacion' => $this->input->post('instalaciones'),
			'estatus' => $this->input->post('estatus'),
			'tipoUsuario' => $this->input->post('tipoUsuario'),
			'telefono' => $this->input->post('telefono')
		);
		// Insertar datos de usuario a la base de datos
		return $this->db->insert('usuario', $data);
	}
	public function getUsuarioInfo($id){
		$result = $this->db->get_where('usuario', array('idUsuario' => $id));
        if($result->num_rows()==1){
			$r = $result->result();
			return $r[0];
        }else{
            return false;
        }
	}
	public function getSolicitanteInfo($id){
		$q = $this->db->select('*')->from('usuario')->where('idUsuario', $id)->get();
        if($q->num_rows()==1){
			$r = $q->result_array();
            return $r;
        }else{
            return false;
        }
	}
	public function getAdminInfo(){
		$tipoUsuario = [1,3];
		$q = $this->db->select('*')->from('usuario')->where_in('tipoUsuario', $tipoUsuario)->get();
        $r = $q->result_array();
        return $r;
	}
	public function cambioDeEstado($id, $estado){
		if($estado == 4){
			$q = $this->db->get_where('reporte', array('idReporte' => $id));
			$result = $q->result();
			if(empty($result[0]->solucionSoporte)){
				$data = array(
					'statusReporte' => $estado,
					'fechaSolucion' => date('Y-m-d H:i:s')
				);
			}else{
				$data = array(
					'statusReporte' => $estado
				);
			}
		}
		if($estado == 3){
			$data = array(
				'statusReporte' => $estado,
				'fechaSolucion' => date('Y-m-d H:i:s')
			);
		}
		if($estado == 2){
			$data = array(
				'statusReporte' => $estado
			);
		}
		$this->db->where('idReporte', $id);
		$this->db->update('reporte', $data);
	}
	public function guardarReporte($id){
		// Crear arreglo con datos del form para guardar reporte
		$data = array(
			'idUsuario' => $id,
			'fechaReporte' => date('Y-m-d H:i:s'),
			'reporteUsuario' => $this->input->post('textarea'),
			'statusReporte' => 1,
			'idInstalacion' => $this->input->post('instalacion'),
			'idtipoDeServicio' => $this->input->post('problema')
		);
		/*
		`idReporte` int(11) NOT NULL, --
		`idUsuario` int(11) NOT NULL, --
		`fechaReporte` datetime DEFAULT NULL, --
		`fechaLecturaSoporte` datetime DEFAULT NULL, --
		`fechaSolucion` datetime DEFAULT NULL, --
		`ultimaActualizacion` datetime DEFAULT NULL, --
		`reporteUsuario` longtext, --
		`diagnosticoSoporte` longtext, --
		`solucionSoporte` longtext, --
		`statusReporte` int(11) DEFAULT NULL, --
		`idInstalacion` int(11) NOT NULL, --
		`idtipoDeServicio` int(11) NOT NULL, --
		`UsuarioAtencion` int(11) DEFAULT NULL --
		*/
		// Insertar datos de usuario a la base de datos
		return $this->db->insert('reporte', $data);
	}
	public function lecturaReporte($id){
		$data = array(
			'fechaLecturaSoporte' => date('Y-m-d H:i:s'),
			'ultimaActualizacion' => date('Y-m-d H:i:s')
		);
		$this->db->where('idReporte', $id);
		$this->db->update('reporte', $data);
	}
	public function actualizarReporte($id, $diag, $sol, $admin){
		$data = array(
			'diagnosticoSoporte' => $diag,
			'solucionSoporte' => $sol,
			'UsuarioAtencion' => $admin,
			'ultimaActualizacion' => date('Y-m-d H:i:s')
		);
		$seguimiento = array(
			'folio' => $id,
			'soporte' => $admin,
			'fechaSeguimiento' => date('Y-m-d H:i:s')
		);
		if($diag != null){
			$this->cambioDeEstado($id, 2);
		}
		if($sol != null){
			$this->cambioDeEstado($id, 3);
		}
		$this->db->where('idReporte', $id);
		$this->db->update('reporte', $data);
		$this->db->insert('seguimiento', $seguimiento);
	}
	public function actualizarSolicitante($id, $rol, $estatus){
		$data = array(
			'rol' => $rol,
			'estatus' => $estatus
		);
		$this->db->where('idUsuario', $id);
		$this->db->update('usuario', $data);
	}
	public function actualizarSoporte($id, $correo, $nombre, $instalacion, $telefono, $estatus){
		$data = array();
		if(trim($correo, "\x00..\x1F") != null && trim($correo, "\x00..\x1F") != ''){
			$data['accountName'] = $correo;
		}
		if(trim($nombre, "\x00..\x1F") != null && trim($nombre, "\x00..\x1F") != ''){
			$data['displayName'] = $nombre;
		}
		if(trim($telefono, "\x00..\x1F") != null && trim($telefono, "\x00..\x1F") != ''){
			$data['telefono'] = $telefono;
		}
		$data['idInstalacion'] = $instalacion;
		$data['estatus'] = $estatus;
		/*
			'accountName' => $correo,
			'displayName' => $nombre,
			'idInstalacion' => $instalacion,
			'telefono' => $telefono,
			'estatus' => $estatus
		*/
		$this->db->where('idUsuario', $id);
		$this->db->update('usuario', $data);
	}
    public function getReporte($folio){
        $q = $this->db->select('*')->from('reporte')->where('idReporte', $folio)->get();
        if($q->num_rows()==1){
			$r = $q->result_array();
            return $r;
        }else{
            return false;
        }
	}
	public function getSolicitantes(){
        $q = $this->db->select('*')->from('usuario')->where_in('tipoUsuario', 2)->get();
        $r = $q->result_array();
        return $r;
	}
	public function getSoporte(){
        $q = $this->db->select('*')->from('usuario')->where_in('tipoUsuario', 3)->get();
        $r = $q->result_array();
        return $r;
	}
	public function getHistorial(){
        $q = $this->db->select('*')->from('seguimiento')->get();
        $r = $q->result_array();
        return $r;
	}
	public function getReportes(){
        $q = $this->db->select('*')->from('reporte')->order_by('idReporte', 'desc')->get();
        $r = $q->result_array();
        return $r;
	}
	public function getByDate($filtrar, $inst, $d1, $d2){
		if($filtrar == 1){
			if($inst == 0){
				$q = $this->db->select('*')->from('reporte')->where('fechaSolucion >=', $d1)->where('fechaSolucion <', $d2)->order_by('idReporte', 'desc')->get();
			}else{
				$q = $this->db->select('*')->from('reporte')->where_in('idInstalacion', $inst)->where('fechaSolucion >=', $d1)->where('fechaSolucion <', $d2)->order_by('idReporte', 'desc')->get();
			}
		}else{
			if($inst == 0){
				$q = $this->db->select('*')->from('reporte')->where('fechaReporte >=', $d1)->where('fechaReporte <', $d2)->order_by('idReporte', 'desc')->get();
			}else{
				$q = $this->db->select('*')->from('reporte')->where_in('idInstalacion', $inst)->where('fechaReporte >=', $d1)->where('fechaReporte <', $d2)->order_by('idReporte', 'desc')->get();
			}
		}
		$r = $q->result_array();
        return $r;
	}
}