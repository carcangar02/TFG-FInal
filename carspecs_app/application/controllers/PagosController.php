<?php
defined('BASEPATH') or exit('No direct script access allowed');
// setcookie("idUsuario",$idUsuario, time() +15000);

class PagosController extends CI_Controller
{
    

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->model("DatosSubscripcionesModel");
    $this->login_id = $this->session->userdata('login_id');
  }
  //funcion para mostrar las opciones de pago
  function displayOpcionesPago()
  {
    $aDatosSubs = $this->DatosSubscripcionesModel->ObtenerSubs();
    $data['aDatosSubs'] = $aDatosSubs;

    $this->load->view('header');
    $this->load->view('vistaOpcionesPago',$data);
    $this->load->view('footer');
  }
  //Mostrar la pasarela de pago
  function displayPago()
  {

    $jsonInfoSub = $this->input->post('subInfo');
    $aInfoSub = json_decode($jsonInfoSub,true);
    $base64InfoSub = "?infoSub=".base64_encode($jsonInfoSub);
    $data['aInfoSub'] = $aInfoSub;
    $data['jsonInfoSub'] = $jsonInfoSub;

    $order= rand(0,999999);
    $amount = $aInfoSub['precioSubs'] *100;
    $urlOk = base_url().'PagosController/vistaPagoExito/'.$base64InfoSub;
    $urlKo = base_url().'PagosController/vistaPagoError';
    $urlVistaPagoRespuesta = base_url().'vistaPagoRespuesta';



    /* Importar el fichero principal de la librería, tal y como se muestra a
    continuación: */
    include_once 'redsys_api/redsysHMAC256_API_PHP_7.0.0/apiRedsys.php';
    //El comercio debe decidir si la importación desea hacerla con la función
    //“include” o “required”, según los desarrollos realizados.
    /* Definir un objeto de la clase principal de la librería, tal y como se
    muestra a continuación: */
    $miObj = new RedsysAPI;
    /* Calcular el parámetro Ds_MerchantParameters. Para llevar a cabo el cálculo
    de este parámetro, inicialmente se deben añadir todos los parámetros de la
    petición de pago que se desea enviar, tal y como se muestra a continuación: */
    $miObj->setParameter("DS_MERCHANT_AMOUNT", (string)$amount);
    $miObj->setParameter("DS_MERCHANT_ORDER", $order);
    $miObj->setParameter("DS_MERCHANT_MERCHANTCODE", "999008881");
    $miObj->setParameter("DS_MERCHANT_CURRENCY", "978");
    $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", "0");
    $miObj->setParameter("DS_MERCHANT_TERMINAL", "001");
    $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$urlVistaPagoRespuesta);
    $miObj->setParameter("DS_MERCHANT_URLOK", $urlOk);
    $miObj->setParameter("DS_MERCHANT_URLKO", $urlKo);
    /*Por último, para calcular el parámetro Ds_MerchantParameters, se debe
    llamar a la función de la librería “createMerchantParameters()”, tal y como
    se muestra a continuación: */
    $params = $miObj->createMerchantParameters();
    /* Calcular el parámetro Ds_Signature. Para llevar a cabo el cálculo de
    este parámetro, se debe llamar a la función de la librería
    “createMerchantSignature()” con la clave SHA-256 del comercio (obteniendola
    en el panel del módulo de administración), tal y como se muestra a
    continuación: */
    $claveSHA256 = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';
    $firma = $miObj->createMerchantSignature($claveSHA256);
    /* Una vez obtenidos los valores de los parámetros Ds_MerchantParameters y
    Ds_Signature , se debe rellenar el formulario de pago con dichos valores, tal
    y como se muestra a continuación: */
    $data['firma']=$firma;
    $data['params']=$params;
    
    $this->load->view('header');
    $this->load->view('vistaPagos',$data);
    $this->load->view('footer');

  }

  // vista de pago realizado con exito. Recibo el json con la info de la subscripcion codeado en base64 para evitar problemas de caracteres
  //  en la URL, lo devuelvo a array
  // tomo la fecha de hoy y le sumo los dias de la subscripcion elegida
  function vistaPagoExito()
  {
    date_default_timezone_set('CET');
    $aInfoSub = json_decode(base64_decode($this->input->get('infoSub')),true);
    
    //sumo a la fecha actual los dias de la subscripcion y lo formateo 
    $fechaSub= date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+$aInfoSub['periodoSubs'], date("Y")));
  

    $this->DatosSubscripcionesModel->hacerVip($this->login_id,$fechaSub);

    $this->load->view('header');
    $this->load->view('vistaPagoExito');
    $this->load->view('footer');

  }
  function vistaPagoError()
  {

    $this->load->view('header');
    $this->load->view('vistaPagoError');
    $this->load->view('footer');

  }


}