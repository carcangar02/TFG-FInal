<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require $_SERVER['DOCUMENT_ROOT'].'/application/libraries/Excel\PHPExcel.php';
// require $_SERVER['DOCUMENT_ROOT'].'/application/libraries/Excel\PHPExcel\Autoloader.php';


class AdminController extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('pagination');
    $this->load->model("DatosUsuariosModel");
    $this->load->model("DatosRegistrosModel");
    $this->load->model("DatosCochesModel");
  }


   
/*------------------------------------------------MENU ADMIN-----------------------------------------------------------*/
    function menu()
    {

        $this->load->view('header');
        $this->load->view('vistaMenuAdmin');
        $this->load->view('footer');

    }
    
    function cerrarSesion()
    {
        $this->session->sess_destroy();
        redirect('LoginController/login');
    }




/*--------------------------------------------GESTION DE USUARIOS------------------------------------------------------*/
    function DisplayGestionUsuarios()
    {
        $roles= $this->DatosUsuariosModel->roles();
        $statuses= $this->DatosUsuariosModel->statuses();


        /*-------------------------------------Grafica----------------------------------------*/
            $infoRegistros = $this->DatosRegistrosModel->sacarRegistros();
            $numRegistrosSubs = count($infoRegistros);

            //Meter la informacion en array agrupados por tipos y ordenado por registro para enviarlo a la grafica
            $n_subs=array();
            $n_usuarios=array();
            $periodo=array();
            $n_no_subs=array();

            for($i=0;$i<$numRegistrosSubs;$i++)
            {
                //organizo la informacion para introducir en el array
                $n_subs[$i]=intval($infoRegistros[$i]['n_subs']);
                $n_usuarios[$i]=intval($infoRegistros[$i]['n_usuarios']);
                $periodo[$i]=$infoRegistros[$i]['periodo'];
                $n_no_subs[$i]=$infoRegistros[$i]['n_usuarios'] - $infoRegistros[$i]['n_subs'];


            }
            $json_n_subs=json_encode($n_subs);
            $json_n_usuarios=json_encode($n_usuarios);
            $json_periodo=json_encode($periodo);
            $json_n_no_subs=json_encode($n_no_subs);




            $data['json_n_subs'] = $json_n_subs;
            $data['json_n_usuarios'] = $json_n_usuarios;
            $data['json_periodo'] = $json_periodo;
            $data['json_n_no_subs'] = $json_n_no_subs;

        /**------------------------------------------------------------------- */

        /**-----------------------------PAGINACION----------------------------------*/
            $infoUsuario = $this->DatosUsuariosModel->DatosUsuariosAdmin();
            $numRegistros = count($infoUsuario);
            $config['base_url'] = base_url().'AdminController/DisplayGestionUsuarios';
            $config['total_rows'] = $numRegistros;
            $config['per_page'] = 18;
            $config["uri_segment"] = 3;
            
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['usuarios'] = $this->DatosUsuariosModel->DatosUsuariosAdmin($config['per_page'], $page,null,null,null,null,null);
        /**----------------------------------------------------------------------------*/

        $data['roles']=$roles;
        $data['statuses']=$statuses;
    
        $this->load->view('header');
        $this->load->view('vistaGestionUsuariosAdmin',$data);
        $this->load->view('footer');
    }



    //envia la informacion de los inputs y refresca los resultados
    function DisplayGestionUsuariosRefresh()
    {
        $id_usuario = $this->input->post('id_usuario');
        $nombreUsuario = $this->input->post('nombreUsuario');
        $email = $this->input->post('email');
        $id_rol = $this->input->post('id_rol');
        $id_status = $this->input->post('id_status');




        /*-----------PAGINACION-------------------*/

            $infoUsuario = $this->DatosUsuariosModel->DatosUsuariosAdmin(null,null,$id_usuario,$nombreUsuario,$email,$id_rol,$id_status);
            $numRegistros = count($infoUsuario);
            $config['base_url'] = base_url().'AdminController/DisplayGestionUsuariosRefresh';
            $config['total_rows'] = $numRegistros;
            $config['per_page'] = 18;
            $config["uri_segment"] = 3;
            
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            
        /**-----------------------------------------*/


        $aDatosrefresh= $this->DatosUsuariosModel->DatosUsuariosAdmin($config['per_page'], $page,$id_usuario,$nombreUsuario,$email,$id_rol,$id_status);

        $data['usuarios']=$aDatosrefresh;

        if($numRegistros==0){
            $this->load->view('vistaNoResultados');
            }
            else
            {
            $this->load->view('vistaRefreshUsuariosAdmin',$data);
            }

        



    }
    //establece un usuario como activo o inactivo 
    function Activar_Desactivar()
    {
        $statusCambio = $this->input->post('status');
        $id_usuarioCambio = $this->input->post('id_usuario');
        
        $this->DatosUsuariosModel->cambiarStatus($statusCambio,$id_usuarioCambio);

        /*-----------PAGINACION-------------------*/
            $infoUsuario = $this->DatosUsuariosModel->DatosUsuariosAdmin();
            $numRegistros = count($infoUsuario);
            $config['base_url'] = base_url().'AdminController/DisplayGestionUsuarios';
            $config['total_rows'] = $numRegistros;
            $config['per_page'] = 18;
            $config["uri_segment"] = 3;
            
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['usuarios'] = $this->DatosUsuariosModel->DatosUsuariosAdmin($config['per_page'], $page,null,null,null,null,null);
        /*-----------------------------------------*/
        $this->load->view('vistaRefreshUsuariosAdmin',$data);
    }





    //funcion para mandar al model la informcaion necesaria para cambiar el rol de vip
    function cambioVIP()
    {
        $fechaVIP= $this->input->post('fechaCambioVIP');
        $id_usuario= $this->input->post('id_usuario');
        echo $fechaVIP;

        $this->DatosUsuariosModel->cambioVIP($id_usuario,$fechaVIP);

        /*-----------PAGINACION-------------------*/
            $infoUsuario = $this->DatosUsuariosModel->DatosUsuariosAdmin();
            $numRegistros = count($infoUsuario);
            $config['base_url'] = base_url().'AdminController/DisplayGestionUsuarios';
            $config['total_rows'] = $numRegistros;
            $config['per_page'] = 18;
            $config["uri_segment"] = 3;
            
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['usuarios'] = $this->DatosUsuariosModel->DatosUsuariosAdmin($config['per_page'], $page,null,null,null,null,null);
        /*-----------------------------------------*/

        $this->load->view('vistaRefreshUsuariosAdmin',$data);
    }



/*---------------------------------------------GESTION DE COCHES-------------------------------------------------------*/
    function DisplayGestionCoches()
    {


       
        $opcionesFiltrosCombustibles = $this->DatosCochesModel->opcionesFiltrosCombustibles();
        $opcionesFiltrosEtiquetas = $this->DatosCochesModel->opcionesFiltrosEtiquetas();
        $opcionesMarcas = $this->DatosCochesModel->obtenerMarca();
        $opcionesModelo = $this->DatosCochesModel->obtenerModelo();
        $data['combustibles'] = $opcionesFiltrosCombustibles;
        $data['etiquetas'] = $opcionesFiltrosEtiquetas;
        $data['opcionesMarcas'] = $opcionesMarcas;
        $data['opcionesModelo'] = $opcionesModelo;
        
    /*-----------PAGINACION-------------------*/

    $infoCoches = $this->DatosCochesModel->DatosCochesAdmin();
    $numRegistros = count($infoCoches);
    $config['base_url'] = base_url().'AdminController/DisplayGestionCoches';
    $config['total_rows'] = $numRegistros;
    $config['per_page'] = 17;
    $config["uri_segment"] = 3;
    


    $this->pagination->initialize($config);
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    /**-----------------------------------------*/
    $aDatosrefresh= $this->DatosCochesModel->DatosCochesAdmin($config['per_page'], $page);

    $data['displayCoches']=$aDatosrefresh;

        $this->load->view('header');
        $this->load->view('vistaGestionCochesAdmin',$data);
        $this->load->view('footer');
    }

    
        //envia la informacion de los inputs y refresca los resultados
    function DisplayGestionCochesRefresh()
    {
            $id_car = $this->input->post('id_car');
            $strBusqueda = $this->input->post('strBusqueda');
            $id_combustible = $this->input->post('id_combustible');
            $id_etiqueta = $this->input->post('id_etiqueta');




            /*-----------PAGINACION-------------------*/

                $infoCoches = $this->DatosCochesModel->DatosCochesAdmin(null,null,$id_car,$strBusqueda,$id_combustible, $id_etiqueta);
                $numRegistros = count($infoCoches);
                $config['base_url'] = base_url().'AdminController/DisplayGestionCochesRefresh';
                $config['total_rows'] = $numRegistros;
                $config['per_page'] = 18;
                $config["uri_segment"] = 3;
                
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                
            /**-----------------------------------------*/


            $aDatosrefresh= $this->DatosCochesModel->DatosCochesAdmin($config['per_page'], $page,$id_car,$strBusqueda,$id_combustible, $id_etiqueta);

            $data['displayCoches']=$aDatosrefresh;
            if($numRegistros==0){
            $this->load->view('vistaNoResultados');
            }
            else
            {
            $this->load->view('vistaRefreshCochesAdmin',$data);
            }



    }

    function modalCambioInfo()
    {
        $id_car = $this->input->post('id_car');
        $resultado = $this->DatosCochesModel->DatosCochesInfoModal($id_car);
        $opcionesFiltrosCombustibles = $this->DatosCochesModel->opcionesFiltrosCombustibles();
        $opcionesFiltrosEtiquetas = $this->DatosCochesModel->opcionesFiltrosEtiquetas();
        $opcionesMarcas = $this->DatosCochesModel->obtenerMarca();
        $opcionesModelo = $this->DatosCochesModel->obtenerModelo();
        $data['opcionesMarcas'] = $opcionesMarcas;
        $data['opcionesModelo'] = $opcionesModelo;
        $data['carInfo'] = $resultado;
        $data['combustibles'] = $opcionesFiltrosCombustibles;
        $data['etiquetas'] = $opcionesFiltrosEtiquetas;



        

        $this->load->view('vistaModalCambioInfo',$data);
    }
    function cambiarInfo()
    {
        $marcaCambio= $this->input->post('marcaCambio');
        $modeloCambio= $this->input->post('modeloCambio');
        $versionCambio= $this->input->post('versionCambio');
        $id_combustibleCambio= $this->input->post('id_combustibleCambio');
        $consumoMedioCambio= $this->input->post('consumoMedioCambio');
        $potenciaCambio= $this->input->post('potenciaCambio');
        $torqueCambio= $this->input->post('torqueCambio');
        $pesoCambio= $this->input->post('pesoCambio');
        $id_etiquetaCambio= $this->input->post('id_etiquetaCambio');
        $likesCambio= $this->input->post('likesCambio');
        $puntosSeguridadCambio= $this->input->post('puntosSeguridadCambio');
        $comprasCambio= $this->input->post('comprasCambio');
        $rutaFotoCambio= $this->input->post('rutaFotoCambio');
        $id_carCambio= $this->input->post('id_carCambio');


        $this->DatosCochesModel->cambiarInfo($id_carCambio,$marcaCambio,$modeloCambio,$versionCambio,$id_combustibleCambio,$consumoMedioCambio,$potenciaCambio,$torqueCambio,$pesoCambio,$id_etiquetaCambio,$likesCambio,$puntosSeguridadCambio,$comprasCambio,$rutaFotoCambio);
        $datosCoches=$this->DatosCochesModel->DatosCoches();
        $data['displayCoches'] = $datosCoches;
        $this->load->view('vistaRefreshCochesAdmin',$data);


    }

    function crearModelo()
    {
        $nuevoModelo = $this->input->post('inputModelo');
        $marcaModelo = $this->input->post('id_marca');

        $this->DatosCochesModel->crearModelo($marcaModelo,$nuevoModelo);

    }

    function crearMarca()
    {
        $nuevaMarca = $this->input->post('inputMarca');

        $this->DatosCochesModel->crearMarca($nuevaMarca);

        
    }

    function crearCoche()
    {
        $marcaCrear= $this->input->post('marcaCrear');
        $modeloCrear= $this->input->post('modeloCrear');
        $versionCrear= $this->input->post('versionCrear');
        $id_combustibleCrear= $this->input->post('id_combustibleCrear');
        $consumoMedioCrear= $this->input->post('consumoMedioCrear');
        $potenciaCrear= $this->input->post('potenciaCrear');
        $torqueCrear= $this->input->post('torqueCrear');
        $pesoCrear= $this->input->post('pesoCrear');
        $id_etiquetaCrear= $this->input->post('id_etiquetaCrear');
        $likesCrear= $this->input->post('likesCrear');
        $puntosSeguridadCrear= $this->input->post('puntosSeguridadCrear');
        $comprasCrear= $this->input->post('comprasCrear');
        $rutaFotoCrear= $this->input->post('rutaFotoCrear'); 
        if(isset($_FILES['fotoCrear']) && $_FILES['fotoCrear']['full_path']!="") 
        { 
            $config['upload_path'] = "./img/";
            $config['allowed_types'] = 'jpg|jpeg|png'; 
            $config['max_size'] = '20'; 
            

            list($nombreDesechable,$extensionFoto) = explode('.',$_FILES['fotoCrear']['full_path']);
            $rutaFullPath = $rutaFotoCrear.".".$extensionFoto;
            $_FILES['fotoCrear']['full_path']=$rutaFullPath;
            $_FILES['fotoCrear']['name'] = $rutaFullPath;
            $rutaBBDD = "http://carspecs.desa.com/img/".$rutaFullPath;
            $this->load->library('upload', $config); 

            // si hay error 
            if (!$this->upload->do_upload('fotoCrear'))
            { //do_upload para subir el archivo

                $data['uploadError'] = $this->upload->display_errors();
                echo  $this->upload->display_errors();  
                die(); 
            
            }
            else
            {
                $this->DatosCochesModel->crearCoches($marcaCrear,$modeloCrear,$versionCrear,$id_combustibleCrear,$consumoMedioCrear,$potenciaCrear,$torqueCrear,$pesoCrear,$id_etiquetaCrear,$likesCrear,$puntosSeguridadCrear,$comprasCrear,$rutaBBDD);
                redirect('/AdminController/DisplayGestionCoches');
                
            }
        }
        else
        {
            $this->DatosCochesModel->crearCoches($marcaCrear,$modeloCrear,$versionCrear,$id_combustibleCrear,$consumoMedioCrear,$potenciaCrear,$torqueCrear,$pesoCrear,$id_etiquetaCrear,$likesCrear,$puntosSeguridadCrear,$comprasCrear,$rutaFotoCrear);
                redirect('/AdminController/DisplayGestionCoches');
        }

        



        
    }

    function eliminarCoche()
    {
        $id_car = $this->input->post('id_car');
        $this->DatosCochesModel->eliminarCocheAdmin($id_car);

        $datosCoches=$this->DatosCochesModel->DatosCoches();
        $data['displayCoches'] = $datosCoches;
        $this->load->view('vistaRefreshCochesAdmin',$data);

    }
    function selectDinamico()
    {
        $opcionesModelo = $this->DatosCochesModel->obtenerModelo();
        $data['opcionesModelo'] = $opcionesModelo;
        $id_brand = $this->input->post('id_brand');
        $data['id_brand'] = $id_brand;
        $this->load->view('vistaSelectDinamico', $data);
    }



/*---------------------------------------------------API---------------------------------------------------------------*/
    function pruebaAPI()
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://carapi.app/api/makes?sort=id&direction=asc&year=2020',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjYXJhcGkuYXBwIiwic3ViIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiYXVkIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiZXhwIjoxNzMyMDk0MTA4LCJpYXQiOjE3MzE0ODkzMDgsImp0aSI6IjE0MjBkYjAzLWRiOTAtNGI3Ny04YjcyLTYzMDFjZmQzMDYzMyIsInVzZXIiOnsic3Vic2NyaWJlZCI6ZmFsc2UsInN1YnNjcmlwdGlvbiI6bnVsbCwicmF0ZV9saW1pdF90eXBlIjoiaGFyZCIsImFkZG9ucyI6eyJhbnRpcXVlX3ZlaGljbGVzIjpmYWxzZSwiZGF0YV9mZWVkIjpmYWxzZX19fQ.2IEe9pC-wJLr-gwTklX7JGy7oaxYY5OdhB_i7wLY1fs'
          ),
        ));
        $infoBrands = json_decode(curl_exec($curl),true);
        
  
        if(curl_errno($curl))
        {
            echo "Error en la peticion:". curl_error($curl);
        }
        else
        {

        }
        curl_close($curl);
        


        $models = curl_init();
        
        curl_setopt_array($models, array(
          CURLOPT_URL => 'https://carapi.app/api/models?limit=384&sort=id&direction=asc&verbose=no&year=2020',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjYXJhcGkuYXBwIiwic3ViIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiYXVkIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiZXhwIjoxNzMyMDk0MTA4LCJpYXQiOjE3MzE0ODkzMDgsImp0aSI6IjE0MjBkYjAzLWRiOTAtNGI3Ny04YjcyLTYzMDFjZmQzMDYzMyIsInVzZXIiOnsic3Vic2NyaWJlZCI6ZmFsc2UsInN1YnNjcmlwdGlvbiI6bnVsbCwicmF0ZV9saW1pdF90eXBlIjoiaGFyZCIsImFkZG9ucyI6eyJhbnRpcXVlX3ZlaGljbGVzIjpmYWxzZSwiZGF0YV9mZWVkIjpmYWxzZX19fQ.2IEe9pC-wJLr-gwTklX7JGy7oaxYY5OdhB_i7wLY1fs'
          ),
        ));
        $infoModels = json_decode(curl_exec($models),true);
        
  
        if(curl_errno($models))
        {
            echo "Error en la peticion:". curl_error($models);
        }
        else
        {

        }
        curl_close($models);

    



                /**---------------------------------------------------------- */
        $engines = curl_init();
        $limit = 300;
        curl_setopt_array($engines, array(
          CURLOPT_URL => 'https://carapi.app/api/engines?limit='.$limit.'&verbose=yes&year=2020',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjYXJhcGkuYXBwIiwic3ViIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiYXVkIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiZXhwIjoxNzMyMDk0MTA4LCJpYXQiOjE3MzE0ODkzMDgsImp0aSI6IjE0MjBkYjAzLWRiOTAtNGI3Ny04YjcyLTYzMDFjZmQzMDYzMyIsInVzZXIiOnsic3Vic2NyaWJlZCI6ZmFsc2UsInN1YnNjcmlwdGlvbiI6bnVsbCwicmF0ZV9saW1pdF90eXBlIjoiaGFyZCIsImFkZG9ucyI6eyJhbnRpcXVlX3ZlaGljbGVzIjpmYWxzZSwiZGF0YV9mZWVkIjpmYWxzZX19fQ.2IEe9pC-wJLr-gwTklX7JGy7oaxYY5OdhB_i7wLY1fs'
          ),
        ));
        $infoEngine = json_decode(curl_exec($engines),true);
        
  
        if(curl_errno($engines))
        {
            echo "Error en la peticion:". curl_error($engines);
        }

        curl_close($engines);






        $carBody = curl_init();
        curl_setopt_array($carBody, array(
          CURLOPT_URL => 'https://carapi.app/api/bodies?limit='.$limit.'&sort=id&direction=asc&verbose=yes&year=2020',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjYXJhcGkuYXBwIiwic3ViIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiYXVkIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiZXhwIjoxNzMyMDk0MTA4LCJpYXQiOjE3MzE0ODkzMDgsImp0aSI6IjE0MjBkYjAzLWRiOTAtNGI3Ny04YjcyLTYzMDFjZmQzMDYzMyIsInVzZXIiOnsic3Vic2NyaWJlZCI6ZmFsc2UsInN1YnNjcmlwdGlvbiI6bnVsbCwicmF0ZV9saW1pdF90eXBlIjoiaGFyZCIsImFkZG9ucyI6eyJhbnRpcXVlX3ZlaGljbGVzIjpmYWxzZSwiZGF0YV9mZWVkIjpmYWxzZX19fQ.2IEe9pC-wJLr-gwTklX7JGy7oaxYY5OdhB_i7wLY1fs'
          ),
        ));
        $infoCarBody = json_decode(curl_exec($carBody),true);
        
  
        if(curl_errno($carBody))
        {
            echo "Error en la peticion:". curl_error($carBody);
        }

        curl_close($carBody);



        $consumo = curl_init();
        curl_setopt_array($consumo, array(
          CURLOPT_URL => 'https://carapi.app/api/mileages?limit='.$limit.'&sort=id&direction=asc&verbose=yes&year=2020',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjYXJhcGkuYXBwIiwic3ViIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiYXVkIjoiNzc0ZjhlYzQtNzI5NS00NjBjLTlkZTYtODg3OGQ3ZTRkYmQ0IiwiZXhwIjoxNzMyMDk0MTA4LCJpYXQiOjE3MzE0ODkzMDgsImp0aSI6IjE0MjBkYjAzLWRiOTAtNGI3Ny04YjcyLTYzMDFjZmQzMDYzMyIsInVzZXIiOnsic3Vic2NyaWJlZCI6ZmFsc2UsInN1YnNjcmlwdGlvbiI6bnVsbCwicmF0ZV9saW1pdF90eXBlIjoiaGFyZCIsImFkZG9ucyI6eyJhbnRpcXVlX3ZlaGljbGVzIjpmYWxzZSwiZGF0YV9mZWVkIjpmYWxzZX19fQ.2IEe9pC-wJLr-gwTklX7JGy7oaxYY5OdhB_i7wLY1fs'
          ),
        ));
        $infoConsumo = json_decode(curl_exec($consumo),true);
        
  
        if(curl_errno($consumo))
        {
            echo "Error en la peticion:". curl_error($consumo);
        }

        curl_close($consumo);
        



      




        $modelos = $this->DatosCochesModel->obtenerModelo();
        $compararId=-1;
       
        for($i=0;$i<$limit;$i++)
        {
           
            if($infoEngine['data'][$i]["make_model_trim"]['make_model_id'] != $compararId)
            {
                $compararId = $infoEngine['data'][$i]["make_model_trim"]['make_model']['id'];
                $engineAlias=$infoEngine['data'][$i];
                $carBodyAlias=$infoCarBody['data'][$i];
                $consumoAlias=$infoConsumo['data'][$i];
                         	



                $marcaCrear=$engineAlias["make_model_trim"]['make_model']['make_id'];	
                $modeloCrear=$engineAlias["make_model_trim"]['make_model']['id'];	
                $versionCrear=$engineAlias['size']." ".$engineAlias['cylinders'];

                if($engineAlias['engine_type']=='gas')
                {
                    $id_combustibleCrear=1;	
                }
                if($engineAlias['engine_type']=='diesel')
                {
                    $id_combustibleCrear=2;	
                }
                if($engineAlias['engine_type']=='electric')
                {
                    $id_combustibleCrear=4;	
                }
                if($engineAlias['engine_type']=='electric (fuel cell)')
                {
                    $id_combustibleCrear=4;	
                }
                if($engineAlias['engine_type']=='flex-fuel (FFV)')
                {
                    $id_combustibleCrear=3;	
                }
                if($engineAlias['engine_type']=='hybrid')
                {
                    $id_combustibleCrear=3;	
                }
                if($engineAlias['engine_type']=='mild hybrid')
                {
                    $id_combustibleCrear=3;	
                }
                if($engineAlias['engine_type']=='natural gas (CNG)')
                {
                    $id_combustibleCrear=5;	
                }
                if($engineAlias['engine_type']=='plug-in hybrid')
                {
                    $id_combustibleCrear=3;	
                }            
                if($id_combustibleCrear==4)
                {
                    $consumoMedioCrear= $consumoAlias['epa_kwh_100_mi_electric'];	
                }  
                else
                {           
                    $cMCrear	=  100/(($consumoAlias['combined_mpg'] * 1.609)/3.785);
                    $consumoMedioCrear = round($cMCrear, 0, PHP_ROUND_HALF_UP);   
                }
                $potenciaCrear	=$engineAlias['horsepower_hp'];
                $torqueCrear = $engineAlias['torque_ft_lbs'];
                if(!isset($carBodyAlias['curb_weight']) && $carBodyAlias['curb_weight']="")
                {
                   $pesoCrear=1300; 
                }	
                else
                {
                    $pesoCrear = $carBodyAlias['curb_weight'];
                }
                $pSCrear= (($engineAlias["make_model_trim"]['invoice']/strlen($engineAlias["make_model_trim"]['description']))/100)*3;	
                $puntosSeguridadCrear = round($pSCrear, 0, PHP_ROUND_HALF_UP);   
                $comprasCrear= $engineAlias["make_model_trim"]['invoice'];	
                if($engineAlias["make_model_trim"]['year']>2006 && $engineAlias['engine_type']=='diesel')
                {
                    $id_etiquetaCrear=1;
                }
                if($engineAlias["make_model_trim"]['year']>2005 && $engineAlias['engine_type']=='gas')
                {
                    $id_etiquetaCrear=1;
                }
                if($engineAlias["make_model_trim"]['year']<2006 && $engineAlias['engine_type']=='diesel')
                {
                    $id_etiquetaCrear=2;
                }
                if($engineAlias["make_model_trim"]['year']<2005 && $engineAlias['engine_type']=='gas')
                {
                    $id_etiquetaCrear=3;
                }
                if($id_combustibleCrear==3||$id_combustibleCrear==5)
                {
                    $id_etiquetaCrear=4;
                }
                if($id_combustibleCrear==4)
                {
                    $id_etiquetaCrear=5; 
                }
                

                
                $rutas = array("img/2.jpg","img/3.jpg","img/4.jpg","img/5.jpg");
                $indiceRutas = array_rand($rutas,1);
                $rutaFotoCrear=$rutas[$indiceRutas];	
                

                $likesCrear	= 0;
                if(array_key_exists($modeloCrear,$modelos) == false)
                {
                    $modeloCrear = 2;
                }
                if($modeloCrear == 138)
                {
                    $modeloCrear = 2;
                }
                

                $g = array($marcaCrear,$modeloCrear,$versionCrear,$id_combustibleCrear,$consumoMedioCrear,$potenciaCrear,$torqueCrear,$pesoCrear,$id_etiquetaCrear,$likesCrear,$puntosSeguridadCrear,$comprasCrear,$rutaFotoCrear);
                $data[$i]=$g;


                if(!isset($data[$i]) && $data[$i]!="")
                {
                    echo 'no hay datos';
                }
                
               $this->DatosCochesModel->crearCoches($marcaCrear,$modeloCrear,$versionCrear,$id_combustibleCrear,$consumoMedioCrear,$potenciaCrear,$torqueCrear,$pesoCrear,$id_etiquetaCrear,$likesCrear,$puntosSeguridadCrear,$comprasCrear,$rutaFotoCrear);
                
                
                
                
                





            }
        }
        unset($infoBrands['collection']);
        unset($infoModels['collection']); 
        
    }

}



