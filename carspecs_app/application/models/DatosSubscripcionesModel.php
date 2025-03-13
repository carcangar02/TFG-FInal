<?php
class DatosSubscripcionesModel extends CI_Model {

    function __construct()
    {
        parent:: __construct();
        $this->load->database(); //cargamos la configuracion de bbdd
    }

    //Obtiene todas las opciones de subscripcion para mostrarlas
    function ObtenerSubs()
    {
        $query="SELECT id_subs, precioSubs, periodoSubs
                FROM subs ;";

        $aResutado = $this->db->query($query)->result_array();
        return $aResutado;
    }

    //Establece la fecha de fincalizacion de la sub y cambia el rol a VIP
    function hacerVip($intUsuarioLogueado,$fechaSub)
    {
        $query = "UPDATE usuarios 
                  SET fecha_VIP = ?, id_rol = 2
                  WHERE id_usuario = ?;";
        return $this->db->query($query,array($fechaSub,$intUsuarioLogueado));
    }



}
