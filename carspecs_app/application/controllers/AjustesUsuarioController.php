<?php
defined('BASEPATH') or exit('No direct script access allowed');


class AjustesUsuarioController extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->model("DatosUsuariosModel");
    $this->login_id =  $this->session->userdata('login_id');
  }

// const LOGIN_ID = $this->session->userdata('login_id');

//Cargar la inforacion inicial en la pagina

  function displayAjustesUsuario()
  {
    
    $datosUsuario = $this->DatosUsuariosModel->infoUsuario($this->login_id);

    $data['datosUsuario']=$datosUsuario;
    $this->load->view('header');
    $this->load->view('vistaAjustesUsuario',$data);
    $this->load->view('footer');

  }

  //Enviar al informacion del formulario email al model 
  /* cambiarDatosUsuario() esta esperando ($intUsuarioLogeado,$nuevoNombreUsuario,$email,$nuevaContrasena)  */
  function cambiarEmail()
  {
    $strEmail = $this->input->post('email');
    $emailDisponible = $this->DatosUsuariosModel->verificarEmail($strEmail);
    if($emailDisponible==true)
    {
    $this->DatosUsuariosModel->cambiarDatosUsuario($this->login_id,null,$strEmail,null);

    }
    else
    {
      echo "El correo ya esta en uso ";
    }

    $this->refresh();

  }

    //Enviar al informacion del formulario nombreUsuario al model
  /* cambiarDatosUsuario() esta esperando ($intUsuarioLogeado,$nuevoNombreUsuario,$email,$nuevaContrasena)  */
    function cambiarNombreUsuario()
    {
      $strnuevoNombreUsuario = $this->input->post('nuevoNombreUsuario');
      $usuarioDisponible = $this->DatosUsuariosModel->verificarUsername($strnuevoNombreUsuario);
      if($usuarioDisponible==true)
      {
        $this->DatosUsuariosModel->cambiarDatosUsuario($this->login_id,$strnuevoNombreUsuario,null,null);
        
      }
      else
      {
        echo "Nombre no disponible";
      }  
      $this->refresh();
    }


    //Enviar al informacion del formulario contrasena al model
  /* cambiarDatosUsuario() esta esperando ($intUsuarioLogeado,$nuevoNombreUsuario,$email,$nuevaContrasena)  */
    function cambiarContrasena()
    {
      $strnuevaContrasena = md5($this->input->post('contrasena'));

      $this->DatosUsuariosModel->cambiarDatosUsuario($this->login_id,null,null,$strnuevaContrasena);

      $this->refresh();
    }



// Cargar la informacion nueva en la pagina
  function refresh()
  {
    $datosUsuario = $this->DatosUsuariosModel->infoUsuario($this->login_id);

    $data['datosUsuario']=$datosUsuario;

    $this->load->view('vistaRefreshDatosUsuario',$data);
  }
}