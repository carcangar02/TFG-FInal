<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BuscadorController extends CI_Controller
{


  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->model("DatosCochesModel");
    $this->load->model("DatosUsuariosModel");
  }


  function index()
  {
    echo "hola mundo";
  }

  //Display predeterminado del buscador
  function display()
  {
    $intUsuarioLogueado = $this->session->userdata('login_id');

    $datosCoches=$this->DatosCochesModel->DatosCoches();
    $data['displayCoches'] = $datosCoches;



    //Meto los nombreLista y las id_lista 
    $aDatosListas=$this->DatosUsuariosModel->sacarNombreListas($intUsuarioLogueado);
    $data['datosListas']=$aDatosListas;

    $opcionesFiltrosCombustibles = $this->DatosCochesModel->opcionesFiltrosCombustibles();
    $opcionesFiltrosEtiquetas = $this->DatosCochesModel->opcionesFiltrosEtiquetas();
    $data['combustibles'] = $opcionesFiltrosCombustibles;
    $data['etiquetas'] = $opcionesFiltrosEtiquetas;




    $this->load->view("header");
    $this->load->view("vistaBuscador",$data);
    $this->load->view("footer");



  
 
  }


  
  //Recojo los datos del resultado de la busqueda y los mando a la vista que actualizar
  function refresh()
  {
    $strBusquedaInput = $this->input->post('strBusquedaInput');
    $combustionType=$this->input->post('tipo_combustible');
    $potenciaMinima=$this->input->post('potencia_min');
    $potenciaMaxima=$this->input->post('potencia_max');
    $etiqueta=$this->input->post('etiqueta');
    $ordenar=$this->input->post('ordenar');
    
    $aDatosRefresh=$this->DatosCochesModel->DatosCoches($strBusquedaInput,$combustionType,$potenciaMinima,$potenciaMaxima,$etiqueta,$ordenar);
    $numRegistros = count($aDatosRefresh);


 
    
    $data['displayCoches'] = $aDatosRefresh;

    if($numRegistros==0){
      $this->load->view('vistaNoResultados');
      }
      else
      {
      $this->load->view("vistaRefreshBuscador",$data);
      }
    



  }


  
  //Recojo el id_lista y el id_usuario y se los mando a la funcion correspondiente
  function guardarCoches()
  {
    $intId_coche = $this->input->post('intId_coche');
    $intId_lista = $this->input->post('intId_lista'); 

    $this->DatosCochesModel->guardarCoches($intId_coche,$intId_lista);
  }


  //Saco la id_car de la vista y se lo paso al model para que me de la informacion que quiero mostrar en el modal info
  function abrirModalInfo()
  {
    $intId_coche = $this->input->post('intId_coche');
    $aResultado = $this->DatosCochesModel->DatosCochesInfoModal($intId_coche);

    $data['coche'] = $aResultado;
    $this->load->view("vistaModalInfo",$data);
  }
  











}
?>