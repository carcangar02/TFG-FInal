<?php
class DatosRegistrosModel extends CI_Model {

    function __construct()
    {
        parent:: __construct();
        $this->load->database(); //cargamos la configuracion de bbdd
    }

    function sacarRegistros()
    {
        $query="SELECT * 
                FROM registros_subs;";
        return $this->db->query($query)->result_array();
    }


}