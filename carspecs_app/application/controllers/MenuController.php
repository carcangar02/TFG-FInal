<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MenuController extends CI_Controller {


  

    function __construct(){
        parent:: __construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('DatosCochesModel');
        $this->load->model('DatosUsuariosModel');
        $this->login_id = $this->session->userdata('login_id');
        $this->id_rol = $this->session->userdata('id_rol');

    }

    /*
        LISTA COCHES
        
        ParamEntrada: N/A
        Salida: N/A

        Muestra el listado de coches y los coches dentro de las mismas
        por usuario logueado.

        Dependencia/Referencias:
            DatosCochesModel->obtenerDatosListas($this->login_id), 
            requiere id login para obtener datos relacionados

    */



    function menu()
    {
       
            if($this->id_rol==2)
            {
                $VIP = 1;
            }
            else
            {
                $VIP = 0;
            }
            $data['VIP']=$VIP;
            
            if(isset($this->login_id) && $this->login_id !="")
            {
            $datosListas=$this->DatosCochesModel->obtenerDatosListasPrevia($this->login_id);
            $cochesOrdered=[];
            foreach ($datosListas as $info) 
            {

            //Necesito id_lista como key junto a nombreLista asi que uno los dos string en uno y los separo en origen
             $info['nombreLista']= $info['nombreLista']."|".$info['id_lista'];    

             $cochesOrdered[$info['nombreLista']][]=$info;
            }
            
            $data['listasCoches'] = $cochesOrdered;
            
            $this->load->view("header");
            $this->load->view("vistaCoches",$data);
            $this->load->view("footer");
            }
            else
            {
                redirect('LoginController/login');
            }
    }


    function eliminarCoche()
    {     
        $id_car = $this->input->post('id_car');
        $id_lista = $this->input->post('id_lista');
        
       
            
        $this->DatosCochesModel->eliminarCoche($id_lista, $id_car);
        $id_car=null;
        $id_lista=-1;            
        

        $this->refreshDivContainer();

    }


    // Funcion para cerrar la sesion 
    function cerrarSesion()
    {
        $this->session->sess_destroy();
        redirect('LoginController/login');
    }

    // Funcion para crear listas
    function crearLista()
    {
        
        $strNombreNuevaLista = $this->input->post('strNombreNuevaLista');
        $this->DatosUsuariosModel->crearLista($strNombreNuevaLista,$this->login_id);

        
        $this->refreshDivContainer();
    
    }

    function eliminarLista()
    {
        
        $intId_lista = $this->input->post('intId_lista');
        $this->DatosUsuariosModel->eliminarLista($intId_lista,$this->login_id);



        $this->refreshDivContainer();
    


    }

    //recarga el contenido del div de las listas
    function refreshDivContainer()
    {
        
        $datosListas=$this->DatosCochesModel->obtenerDatosListasPrevia($this->login_id);
        $cochesOrdered=[];
        foreach ($datosListas as $info)
        {

            //Necesito id_lista como key junto a nombreLista asi que uno los dos string en uno y los separo en origen
             $info['nombreLista']= $info['nombreLista']."|".$info['id_lista'];    

             $cochesOrdered[$info['nombreLista']][]=$info;
        }
        
        // hago el borrado completo, obtengo el nuevo listado de coches y pinto la vista

        $data['listasCoches'] = $cochesOrdered;
        $this->load->view("vistaContainerListasCoches", $data);

    }
}