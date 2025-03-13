<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('CORREO_HOST','smtp.gmail.com');
define('CORREO_PORT','587');
define('ENVIA_EMAIL','carlos.cantosgarcia@zelenza.com');
define('CORREO_PASS','irqi nugz rtpn mflh');
define('MY_WEB','CarSpecs');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'].'/carspecs_app/application/libraries/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'].'/carspecs_app/application/libraries/phpmailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/carspecs_app/application/libraries/phpmailer/src/SMTP.php';


class LoginController extends CI_Controller
{


  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->library('pagination');
    $this->load->model("DatosUsuariosModel");
  }


  public function login()
  {
    $this->load->view("header");
    $this->load->view("LoginView");
    $this->load->view("footer");


    // Definir las reglas de validación

    $this->form_validation->set_rules('loginUsername', 'username', 'required');
    $this->form_validation->set_rules('loginPassword', 'password', 'required');


    if ($this->form_validation->run() == FALSE) 
    {
      echo validation_errors();
      return; // Detener la ejecución si hay errores
    } 
    else 
    {
      // Obtenemos los datos del formulario
      $username = $this->input->post('loginUsername');
      $password = $this->input->post('loginPassword');
      //Comprobamos que el username exista
      $existeUsername = $this->DatosUsuariosModel->verificarUsername($username);
      //true si el username no existe, si es false, si existe
      if ($existeUsername == true) 
      {
        echo "El usuario no existe. <br>";
        $contraseñaCorrecta = 0;
      } 
      else 
      {
        $contraseñaCorrecta = $this->DatosUsuariosModel->comprobarPassword($username, $password);
      }
      //Comprobamos que la contraseña sea correcta
      if ($contraseñaCorrecta == true && $contraseñaCorrecta != 0) 
      {
        $idUsuarioCopy = $this->DatosUsuariosModel->sacarId($username);
        $id_rolCopy = $this->DatosUsuariosModel->sacarRol($username);
        $id_statusCopy = $this->DatosUsuariosModel->sacarstatus($username);
        $this->session->set_userdata('login_id', $idUsuarioCopy);
        $this->session->set_userdata('id_rol', $id_rolCopy);
        if($id_statusCopy==1)
        {

          if($id_rolCopy==3)
          {
            redirect(base_url().'AdminController/menu');
          }
          else
          {
          redirect(base_url().'MenuController/menu');
          }
        }
        else
        {
          Echo 'Este usuario esta inactivo';
        }
      }
      else
      {
        echo "Contraseña incorrecta. ";
      }
    }

      
  }


      function redireccionMailer()
      {
        $this->load->view("header");
        $this->load->view("vistaRedireccionMailer");
        $this->load->view("footer");
      }

      function mailer()
      {

        $email = $this->input->post('emailInput');
        $resultado = $this->DatosUsuariosModel->verificarEmail($email);
        if($resultado==true)
        {
          echo 'Este correo no esta en la bbdd';
        }
        else
        {

        $emailBase64 = base64_encode($email);
        

        $mail = new PHPMailer(true);
       
        $asunto="Recuperacion Contraseña CarSepcs";
        $body="Acceda a este enlace para recuperar su contraseña http://carspecs.desa.com/LoginController/recuperarContrasenaView/".$emailBase64."";

        try{
        $mail->IsSMTP();
        $mail->SMTPDebug=0;
        $mail->Host= CORREO_HOST;
        $mail->Port= CORREO_PORT;
        $mail->isHTML(true);
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = ENVIA_EMAIL;
        $mail->Password = CORREO_PASS;
        $mail->SetFrom(ENVIA_EMAIL,MY_WEB);
        $mail->addAddress($email,"usuario");
        $mail->Subject = $asunto;
        $mail->CharSet = 'UTF8';
        $mail->Encoding = 'quoted-printable';
        $mail->Body = $body;
        $mail->AltBody = "Error";
        $mail->send();
        
          $this->load->view("header");
          $this->load->view("vistaMailer");
          $this->load->view("footer");
        } 
        catch (phpmailerException $e) 
        {
          echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } 
        catch (Exception $e) {
          echo $e->getMessage(); //Boring error messages from anything else!
        }

      }
      }

      function recuperarContrasenaView()
      {
        $email = base64_decode($this->uri->segment(3));
        $data['email'] = $email;
        
        $this->load->view("header");
        $this->load->view("vistaRecuperarContrasena",$data);
        $this->load->view("footer");

      }


      function recuperarContrasena()
    {
      $strnuevaContrasena = md5($this->input->post('password'));
      $email = $this->input->post('email');


      if($this->DatosUsuariosModel->cambiarDatosUsuario(null,null,null,$strnuevaContrasena,$email))
      {

        redirect('/LoginController/login');
      }
      else
      {

        redirect('/LoginController/login');
      }

    }
}
