<?php
    class User_model extends CI_Model{
        public function register($enc_password){
            // Crear arreglo con datos del form para registrar usuario
            $nombre = $this->input->post('nombre');
            $apellido = $this->input->post('apellido');
            $nombre_completo = $nombre.' '.$apellido;
            $data = array(
                'accountName' => $this->input->post('correo'),
                'displayName' => $nombre_completo,
                'password' => $enc_password,
                'area' => $this->input->post('area'),
                'direccion' => $this->input->post('direccion'),
                'idInstalacion' => $this->input->post('instalaciones'),
                'edificio' => $this->input->post('edificio'),
                'estatus' => $this->input->post('estatus'),
                'tipoUsuario' => $this->input->post('tipoUsuario')
            );
            // Insertar datos de usuario a la base de datos
            return $this->db->insert('usuario', $data);
        }
        public function login($rfc, $password){
            // Validar
            $this->db->where('accountName', $rfc);
            $this->db->where('password', $password);
            $result = $this->db->get('usuario');
            if($result->num_rows()==1){
                return $result->row(0)->idUsuario;
            }else{
                return false;
            }
        }
        public function setPassword($id, $password){
            $q = $this->db->get_where('usuario', array('idUsuario' => $id));
            $result = $q->result();
            $data = array('password' => $password);
            $this->db->where('idUsuario', $id);
            $this->db->update('usuario', $data);
        }
        public function getUsuarioId($rfc){
            $query = $this->db->get_where('usuario', array('accountName' => $rfc));
            if($query->num_rows()==1){
                return $query->result();
            }else{
                return false;
            }
        }
        public function getUsuarioInfo($id){
            $q = $this->db->get_where('usuario', array('idUsuario' => $id));
            if($q->num_rows()==1){
                return $q->result();
            }else{
                return false;
            }
        }
        public function getUserStatus($id){
            $q = $this->db->select('*')->from('usuario')->where('idUsuario', $id)->get();
            if($q->num_rows()==1){
                $r = $q->result_array();
                return $r[0]['estatus'];
            }else{
                return false;
            }
        }
        public function check_correo_exists($correo){
            $query = $this->db->get_where('usuario', array('accountName' => $correo));
            if(empty($query->row_array())){
                return true;
            }else{
                false;
            }
        }
        public function updateLogin($id){
            $newData = array('ultimoInicioSesion' => date('Y-m-d H:i:s'));
            $this->db->where('idUsuario', $id);
            $this->db->update('usuario', $newData);
        }
    }