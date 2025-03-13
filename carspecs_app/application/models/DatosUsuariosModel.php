<?php
class DatosUsuariosModel extends CI_Model {

    function __construct(){
        parent:: __construct();
        $this->load->database(); //cargamos la configuracion de bbdd
    }

    


    function comprobarPassword($username,$password){
        $passwordHash = md5($password);
        $contrasenaCorrecta = false;
        $query = "SELECT password FROM usuarios WHERE nombreUsuario = ?;";
        $resultadoBusqueda = $this->db->query($query,array($username))->result_array();
        if ($resultadoBusqueda[0]['password'] === $passwordHash){
        //La contrasena es correcta
            $contrasenaCorrecta = true;
        }
        else
        {
         echo"al palo ";
        }
       return $contrasenaCorrecta;
    }

            //funciones exclusivas del signUp 




    function verificarEmail($email){
        $emailDisponible = false;
        $query = "SELECT * FROM usuarios WHERE email = ?;";
        $resultadoBusqueda = $this->db->query($query,array($email))->result_array();
        if (empty($resultadoBusqueda)){
            
            //El email no esta en la base de datos y esta disponible
            $emailDisponible = true;
             }
           
       return $emailDisponible;

    }
    // Verificar los datos del input del signUp
    function verificarUsername($username){
        $usernameDisponible = false;
        $query = "SELECT * FROM usuarios WHERE nombreUsuario = ?;";
        $resultadoBusqueda = $this->db->query($query,array($username))->result_array();
        if (empty($resultadoBusqueda))
        {
            
            //El email no esta en la base de datos y esta disponible
            $usernameDisponible = true;
        }

       return $usernameDisponible;
    }

    // Guardar los datos de un nuevo usuario
    function guardarDatos($data)
    {
        $query="INSERT INTO usuarios (nombreUsuario,password,email,id_rol,id_status) VALUES (?,?,?,?,?);";
     
        return $this->db->query($query,array($data['username'],$data['password'],$data['email'],$data['id_rol'],$data['id_status']));
       
    }

    //Saca la id del usuario para pasarlo al session y poder acceder a los menus entre otras funciones
    function sacarId($username)
    {

        $query="SELECT id_usuario FROM usuarios WHERE nombreUsuario =?;";
        // $query="SELECT * FROM usuarios;";

        $idUsuarioCopy = $this->db->query($query,array($username))->row()->id_usuario;

        return $idUsuarioCopy;

    }
    // Sacar el rol del usuario para ver si es vip o no
    function sacarRol($username)
    {

        $query="SELECT id_rol FROM usuarios WHERE nombreUsuario =?;";
        

        $id_rolCopy = $this->db->query($query,array($username))->row()->id_rol;

        return $id_rolCopy;

    }

    function sacarStatus($username)
    {

        $query="SELECT id_status FROM usuarios WHERE nombreUsuario =?;";
        

        $id_statusCopy = $this->db->query($query,array($username))->row()->id_status;

        return $id_statusCopy;

    }


    //Crear listas en el menu del usuario
    function crearLista($nombreNuevaLista,$intUsuarioLogueado)
    {
        $query="INSERT INTO listas_usuario (id_usuario,nombreLista) VALUES (?,?);";
        return $this->db->query($query,array($intUsuarioLogueado,$nombreNuevaLista));

    }


    //eliminar listas completas en el menu del usuario
    function eliminarLista($intId_lista,$intUsuarioLogueado)
    {
        $query="DELETE FROM listas_usuario WHERE id_lista=? AND id_usuario=?;";
        return $this->db->query($query,array($intId_lista,$intUsuarioLogueado));
    }


    // Sacar los nombres de las listas y sus id para dar a elegir al usuario donde guardar el coche seleccionado
    function sacarNombreListas($intUsuarioLogueado)
    {
        $query="SELECT id_lista,nombreLista
                from listas_usuario
                WHERE id_usuario = ?;"; 
        $aResultado = $this->db->query($query,array($intUsuarioLogueado))->result_array();
        return $aResultado;
    }



    //Saco informacion del usuario para mostrarla en la vista de ajustes de usuario
    function infoUsuario($intUsuarioLogueado)
    {
        $query="SELECT nombreUsuario, email, roles.rol, status.status, fecha_VIP
                FROM usuarios
                JOIN roles on roles.id_rol = usuarios.id_rol
                JOIN status on status.id_status = usuarios.id_status
                WHERE id_usuario = ? ;";
        $aResultado = $this->db->query($query,array($intUsuarioLogueado))->result_array();
        return $aResultado;
    }

    //Recibe la informacion de AjustesUsuarioController
    function cambiarDatosUsuario($intUsuarioLogueado=NULL,$strnuevoNombreUsuario=NULL,$strEmail=NULL,$strNuevaContrasena=NULL,$email=NULL)
    {
        if(isset($intUsuarioLogueado) && $intUsuarioLogueado != "")
        {
            $campo_busqueda="id_usuario";
            $parametro_busqueda = $intUsuarioLogueado;
            
        }
        else
        {
            $campo_busqueda="email";
            $parametro_busqueda = "'".$email."'";
        }
        


        if(isset($strnuevoNombreUsuario) && $strnuevoNombreUsuario != "")
        {
            $querySection="nombreUsuario";
            $nuevoCambio = $strnuevoNombreUsuario;
        }


        if(isset($strEmail) && $strEmail != "")
        {
            $querySection="email";
            $nuevoCambio = $strEmail;
        }
        if(isset($strNuevaContrasena) && $strNuevaContrasena != "")
        {
            $querySection="usuarios.password";
            $nuevoCambio = $strNuevaContrasena;
        }

        $query="UPDATE usuarios
                SET ".$querySection." = ?
                WHERE ".$campo_busqueda." = ".$parametro_busqueda." ;";

        return $this->db->query($query,array($nuevoCambio));


    }
    /*-----------------------------------------ADMIN---------------------------------------------------------*/




    //saco todos los roles para filtros                 
    function roles()
    {
        $query="SELECT * 
                FROM roles";

        $resultado= $this->db->query($query)->result_array();
        return $resultado;
    }
    //saco todos los statuses para filtros
    function statuses()
    {
        $query="SELECT * 
                FROM status";

        $resultado= $this->db->query($query)->result_array();
        return $resultado;
    }



    function DatosUsuariosAdmin( $start=NULL,$limit=NULL, $id_usuario=NULL,$nombreUsuario=NULL,$email=NULL,$id_rol=NULL,$id_status=NULL)
    {
        if(isset($id_usuario) && $id_usuario!="")
        {
            $id_usuarioQuery="WHERE id_usuario like '%".$id_usuario."%'";
        }
        else
        {
            $id_usuarioQuery="";

        }


        if(isset($nombreUsuario) && $nombreUsuario!="")
        {
            if(($id_usuario) && $id_usuario!="")
            {
                $andWhere = " AND";
            }
            else
            {
                $andWhere = " WHERE";
            }
            $nombreUsuarioQuery="".$andWhere." nombreUsuario LIKE '%".$nombreUsuario."%'";

        }
        else
        {
            $nombreUsuarioQuery="";
            
        }


        if(isset($email) && $email!="")
        {
            if(($id_usuario) && $id_usuario!=""||isset($nombreUsuario) && $nombreUsuario!="")
            {
                $andWhere = " AND";
            }
            else
            {
                
                $andWhere = " WHERE";
            }
            $emailQuery= "".$andWhere." email LIKE '%".$email."%'";

        }
        else
        {
            $emailQuery="";
            
        }


        if(isset($id_rol) && $id_rol!="")
        {
            if(($id_usuario) && $id_usuario!=""||isset($nombreUsuario) && $nombreUsuario!=""||isset($email) && $email!="")
            {
                $andWhere = " AND";
            }
            else
            {
                $andWhere = " WHERE";
            }
            $id_rolQuery="".$andWhere." usuarios.id_rol = ".$id_rol."";

        }
        else
        {
            $id_rolQuery="";
            
        }


        if(isset($id_status) && $id_status!="")
        {
            if(($id_usuario) && $id_usuario!=""||isset($nombreUsuario) && $nombreUsuario!=""||isset($email) && $email!=""||isset($id_rol) && $id_rol!="")
            {
                $andWhere = " AND";
            }
            else
            {
                
                $andWhere = " WHERE";
            }
            $id_statusQuery="".$andWhere." usuarios.id_status = ".$id_status."";
        }
        else
        {
            $id_statusQuery="";
            
        }

       if(isset($limit) && $limit!="")
       {
            $limitQuery = "LIMIT ".$limit.", ".$start."";
       } 
       else
       {
        $limitQuery = "";
       }


        

        $query="SELECT id_usuario, nombreUsuario, email, roles.rol, fecha_VIP, status.status 
                FROM usuarios
                JOIN status on status.id_status = usuarios.id_status
                JOIN roles on roles.id_rol = usuarios.id_rol 
                ".$id_usuarioQuery."".$nombreUsuarioQuery."".$emailQuery."".$id_rolQuery."".$id_statusQuery."
                 ORDER BY id_usuario ASC
                 ".$limitQuery.";";
        
        $resultado = $this->db->query($query)->result_array();
        
        return $resultado;



    }



    //CAmbiar el status del usuario
    function cambiarStatus($status,$id_usuario)
    {
        $query='UPDATE usuarios
                SET id_status = ?
                WHERE id_usuario = ?';
                
        return $this->db->query($query,array($status,$id_usuario));
    }


    //Cambiar el estado de VIP
    function cambioVIP($id_usuario,$fechaVIP=NULL)
    {
        if(isset($fechaVIP) && $fechaVIP!="")
        {
            $query="UPDATE usuarios
                    SET id_rol = 2, fecha_VIP = '".$fechaVIP."'
                    WHERE id_usuario = ?;";
             return $this->db->query($query,array($id_usuario)); 
          
        }
        else
        {
            $query="UPDATE usuarios
                    SET id_rol = 1, fecha_VIP = NULL
                    WHERE id_usuario = ?;";
            return $this->db->query($query,array($id_usuario));  
        }
    }
    
}
?>