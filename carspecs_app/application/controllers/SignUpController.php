<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class SignUpController extends CI_Controller {



    function __construct(){
        parent:: __construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('DatosUsuariosModel');
    }




   /*
        REGISTRO DE USUARIO
        
        ParamEntrada: $username, $password, $email.
        Salida: N/A

        Introduce los datos del usuario y lo redirige al LOGIN

        Dependencia/Referencias:
           DatosUsuariosModel->verificarEmail($email);,
           DatosUsuariosModel->verificarUsername($username);. 
            

    */



    public function signUp(){
        $this->load->view("header");
        $this->load->view('SignUpView');
        $this->load->view("footer");

        // Definir las reglas de validación
        $this->form_validation->set_rules('signUsername', 'username', 'required');
        $this->form_validation->set_rules('signPassword', 'password', 'required');
        $this->form_validation->set_rules('signEmail', 'email', 'required|valid_email'); 

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            return; // Detener la ejecución si hay errores
        };

        // Obtenemos los datos del formulario
        $email = $this->input->post('signEmail');
        $username = $this->input->post('signUsername');
        $password = $this->input->post('signPassword');

        // Verificamos si el email o el username ya existen
        $verificacionEmail = $this->DatosUsuariosModel->verificarEmail($email);
        $verificacionUsername = $this->DatosUsuariosModel->verificarUsername($username);
        //retorna true si la informacion introducida no esta duplicada


        // Verificamos ambos resultados
        if ($verificacionEmail == true && $verificacionUsername == true) 
        {
            echo "guardamos datos ";
            // Si el email y el username son únicos, procedemos a registrar al usuario
            $data = array(
                'username' => $username,
                'password' => md5($this->input->post('signPassword')), // Hasheamos la contraseña
                'email' => $email,
                'id_rol'=> '1',
                'id_status'=>'1'
            );

            // Intentamos insertar los datos del usuario en la base de datos
            if ($this->DatosUsuariosModel->guardarDatos($data)) {
                echo "Registro exitoso";
                redirect(base_url().'LoginController/login');
            } else {
                echo "Error al registrar: " . $this->db->last_query(); // Muestra el último query para debugging
            }

        } else {
            echo"No guardamos ";
            if ($verificacionUsername == false){
                echo "El usuario ". $username. " ya existe.    ";
            }
            if ($verificacoinEmail ==false){
                echo "El correo ". $email. " ya esta en uso";
            }
        } 

       
 }
}