<?php
class Solicitud_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
	
	public function getUsuarios(){
        $sql = "SELECT * FROM usuario";							
		$query = $this->db->query($sql);		
		
		return $query;		
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
	public function subirArchivos($data = array()){
        $insert = $this->db->insert_batch('files',$data);
        return $insert?true:false;
	}
	public function obtenerArchivos($id){
        $this->db->select('file_name');
        $this->db->from('files');
        $this->db->where('idReporte', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return !empty($result)?$result:false;
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
	public function getReportes($id){
		$result = $this->db->get_where('reporte', array('idUsuario' => $id));
        if($result->num_rows()>0){
			$r = $result->result_array();
			return $r;
        }else{
            return false;
        }
	}
	public function getLastReporteId(){
		$this->db->select('*');
		$this->db->from('reporte');
		$this->db->order_by("idReporte", "desc");
		$this->db->limit(1);
		$query = $this->db->get()->result_array();
		return $query;
	}
}