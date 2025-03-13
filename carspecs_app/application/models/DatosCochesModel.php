<?php
class DatosCochesModel extends CI_Model {

    function __construct()
    {
        parent:: __construct();
        $this->load->database(); //cargamos la configuracion de bbdd
    }


    //Display predeterminado, resultado de la busqueda y predeterminado en caso de busqueda en blanco
    function DatosCoches($strBusquedaInput = NULL,$combustionType = NULL,$potenciaMinima = NULL,$potenciaMaxima = NULL,$etiqueta = NULL,$ordenar = NULL)
    {
                //Viene una busqueda
                if(isset($strBusquedaInput) && $strBusquedaInput != "")
                {
                    $strQueryBusqueda= "WHERE brands.brand LIKE ? OR models.model LIKE ? OR version LIKE ?";
                }
                // No viene una busqueda o se carga la pagina
                else
                {
                    $strQueryBusqueda="";
                }
                /*-----------------------------------------*/
                //Filtro Combustible
                if(isset($combustionType) && $combustionType != "")
                {   
                    if(isset($strBusquedaInput) && $strBusquedaInput != "")
                    {
                        $andWhere="AND";
                    }else
                    {
                        $andWhere="WHERE";
                    }
                    $combustionTypeQuery= "".$andWhere." cars.id_combustible = ".$combustionType." ";
                }
                else
                {
                    $combustionTypeQuery="";
                }
                /*-----------------------------------------*/


                       //Filtro Potencia Min
                if(isset($potenciaMinima) && $potenciaMinima != "")
                {
                    if(isset($combustionType) && $combustionType != ""||isset($strBusquedaInput) && $strBusquedaInput != "")
                    {
                        $andWhere="AND";
                    }else
                    {
                        $andWhere="WHERE";
                    }
                    $potenciaMinimaQuery= "".$andWhere."  horsePower > ".$potenciaMinima." ";
                }
                else
                {
                    $potenciaMinimaQuery="";
                }
                /*-----------------------------------------*/


                                       //Filtro Potencia Max
                if(isset($potenciaMaxima) && $potenciaMaxima != "")
                {
                    if(isset($combustionType) && $combustionType != ""||isset($strBusquedaInput) && $strBusquedaInput != ""||isset($potenciaMinima) && $potenciaMinima != "")
                    {
                        $andWhere="AND";
                    }else
                    {
                        $andWhere="WHERE";
                    }
                    $potenciaMaximaQuery= "".$andWhere."  horsePower < ".$potenciaMaxima." ";
                }
                else
                {
                    $potenciaMaximaQuery="";
                }
                /*-----------------------------------------*/

                                       //Filtro Etiqueta
                if(isset($etiqueta) && $etiqueta != "")
                {
                    if(isset($combustionType) && $combustionType != ""||isset($strBusquedaInput) && $strBusquedaInput != ""||isset($potenciaMinima) && $potenciaMinima != ""||isset($potenciaMaxima) && $potenciaMaxima != "")
                    {
                        $andWhere="AND";
                    }else
                    {
                        $andWhere="WHERE";
                    }
                    $etiquetaQuery= "".$andWhere."  etiqueta.id_etiqueta = ".$etiqueta." ";
                }
                else
                {
                    $etiquetaQuery="";
                }
                /*-----------------------------------------*/

                                       //Filtro Ordenar
                if(isset($ordenar) && $ordenar != "")
                {
                    $ordenarQuery= "Order By ".$ordenar." DESC";
                }
                else
                {
                    $ordenarQuery="";
                }
                /*-----------------------------------------*/


       $strQuery= "SELECT cars.id_car, rutaFoto, brand, model, version, combustionType, averageConsumption, horsePower, engineTorque, weight, cars.id_etiqueta, likes, safetyPoints, mostBought
                   from cars 
                   JOIN combustibles on cars.id_combustible = combustibles.Id_combustible
                   JOIN brands on cars.id_brand = brands.id_brand
                   JOIN models on cars.id_model= models.id_model
                   JOIN etiqueta on cars.id_etiqueta = etiqueta.id_etiqueta
                 ".$strQueryBusqueda."".$combustionTypeQuery."".$potenciaMinimaQuery."".$potenciaMaximaQuery."".$etiquetaQuery."".$ordenarQuery.";";

                /*-----------------------------------------*/

                //Busqueda
        if($strBusquedaInput)
        {
            $strSearch = '%'.$strBusquedaInput.'%';
            $aResultado = $this->db->query($strQuery,array($strSearch,$strSearch,$strSearch))->result_array();
        }
        else
        {
            $aResultado = $this->db->query($strQuery)->result_array();
        }
                /*-----------------------------------------*/
         
     return $aResultado; 
    }


    //de aqui saco la informacion que va a ir al modal de info
    function DatosCochesInfoModal($intId_coche = NULL)
    {



                /*Agrego condicional para poder usar como parametro de entrada el id solo en casos especificos*/
                if(isset($intId_coche) && $intId_coche != "")
                {
                    $strQueryBusqueda2 = "WHERE cars.id_car = ?";
                }
                else
                {
                    $strQueryBusqueda2="";
                }
                /*-----------------------------------------*/



       
       $strQuery= "SELECT cars.id_car, rutaFoto, brand, brands.id_brand, model, models.id_model, version, combustibles.id_combustible ,combustibles.combustionType, averageConsumption, horsePower, engineTorque, weight, etiqueta.etiqueta, etiqueta.id_etiqueta, likes, safetyPoints, mostBought
                   from cars 
                   JOIN combustibles on cars.id_combustible = combustibles.Id_combustible
                   JOIN brands on cars.id_brand = brands.id_brand
                   JOIN models on cars.id_model= models.id_model
                   JOIN etiqueta on cars.id_etiqueta = etiqueta.id_etiqueta
                 ".$strQueryBusqueda2.";";



                /*-----------------------------------------*/
        if($intId_coche)
        {
            $strSearch = $intId_coche;
            $aResultado = $this->db->query($strQuery,array($strSearch))->result_array();
        }
                /*-----------------------------------------*/
                
     return $aResultado; 
    }


   



    function obtenerDatosListasPrevia($usuarioLogueado)
    {
        $query= "SELECT  listas_usuario.id_lista, lista_cars.id_car, nombreLista, brand, model, version, rutaFoto
        from usuarios                                
        JOIN listas_usuario ON listas_usuario.id_usuario = usuarios.id_usuario
        left jOIN lista_cars on lista_cars.id_lista = listas_usuario.id_lista
        left JOIN  cars on lista_cars.id_car = cars.id_car
        left JOIN brands on cars.id_brand = brands.id_brand
        left JOIN models on cars.id_model = models.id_model
        where usuarios.id_usuario = ?;" ;
        $resultado = $this->db->query($query,array($usuarioLogueado))->result_array();
        

        return $resultado;
    }
    
    //eliminar coches de las listas
    function eliminarCoche($id_lista, $id_car){
        $query = "DELETE FROM lista_cars WHERE lista_cars.id_lista = ? AND lista_cars.id_car = ?";
       
        return $this->db->query($query,array($id_lista,$id_car));
    }

    //Guardar coches en listas
    function guardarCoches($intId_coche,$intId_lista)
    {
        $query="INSERT INTO lista_cars (id_lista,id_car) 
                VALUES (?,?);";
       
        return $this->db->query($query,array($intId_lista,$intId_coche));
    }

    //funcion para sacar las opciones de los filtros
    function opcionesFiltrosCombustibles()
    {
        $query="SELECT  id_combustible, CombustionType
                FROM combustibles ;";
        $aResultado = $this->db->query($query)->result_array();
        return $aResultado;
    }

    function opcionesFiltrosEtiquetas()
    {
        $query="SELECT id_etiqueta, etiqueta
                FROM etiqueta ;";
        $aResultado = $this->db->query($query)->result_array();
        return $aResultado;
    }



    /**-------------------------ADMIN--------------------------------- */




    function DatosCochesAdmin( $start=NULL,$limit=NULL,$id_car = NULL, $strBusquedaInput = NULL,$combustionType = NULL,$etiqueta = NULL)
    {
                //Viene una busqueda
                if(isset($strBusquedaInput) && $strBusquedaInput != "")
                {
                    $strQueryBusqueda= "WHERE brands.brand LIKE ? OR models.model LIKE ? OR version LIKE ?";
                }
                // No viene una busqueda o se carga la pagina
                else
                {
                    $strQueryBusqueda="";
                }
                /*-----------------------------------------*/
                //Filtro Combustible
                if(isset($combustionType) && $combustionType != "")
                {   
                    if(isset($strBusquedaInput) && $strBusquedaInput != "")
                    {
                        $andWhere="AND";
                    }else
                    {
                        $andWhere="WHERE";
                    }
                    $combustionTypeQuery= "".$andWhere." cars.id_combustible = ".$combustionType." ";
                }
                else
                {
                    $combustionTypeQuery="";
                }
                /*-----------------------------------------*/


                                       //Filtro Etiqueta
                if(isset($etiqueta) && $etiqueta != "")
                {
                    if(isset($combustionType) && $combustionType != ""||isset($strBusquedaInput) && $strBusquedaInput != ""||isset($potenciaMinima) && $potenciaMinima != ""||isset($potenciaMaxima) && $potenciaMaxima != "")
                    {
                        $andWhere="AND";
                    }else
                    {
                        $andWhere="WHERE";
                    }
                    $etiquetaQuery= "".$andWhere."  etiqueta.id_etiqueta = ".$etiqueta." ";
                }
                else
                {
                    $etiquetaQuery="";
                }
                /*-----------------------------------------*/
                //Filtro Etiqueta
                if(isset($id_car) && $id_car != "")
                {
                    if(isset($combustionType) && $combustionType != ""||isset($strBusquedaInput) && $strBusquedaInput != ""||isset($etiqueta) && $etiqueta != "")
                    {
                        $andWhere="AND";
                    }else
                    {
                        $andWhere="WHERE";
                    }
                    $id_carQuery= "".$andWhere."  cars.id_car = ".$id_car." ";
                }
                else
                {
                    $id_carQuery="";
                }
                /*-----------------------------------------*/


                if(isset($limit) && $limit!="")
                {
                     $limitQuery = "LIMIT ".$limit.", ".$start."";
                } 
                else
                {
                 $limitQuery = "";
                }
                /*-----------------------------------------*/


       $strQuery= "SELECT cars.id_car, rutaFoto, brand, model, version, combustionType, averageConsumption, horsePower, engineTorque, weight, etiqueta, likes, safetyPoints, mostBought
                   from cars 
                   JOIN combustibles on cars.id_combustible = combustibles.Id_combustible
                   JOIN brands on cars.id_brand = brands.id_brand
                   JOIN models on cars.id_model= models.id_model
                   JOIN etiqueta on cars.id_etiqueta = etiqueta.id_etiqueta
                    ".$strQueryBusqueda."".$combustionTypeQuery."".$etiquetaQuery."".$id_carQuery."
                    ".$limitQuery.";";

                /*-----------------------------------------*/

                //Busqueda
        if($strBusquedaInput)
        {
            $strSearch = '%'.$strBusquedaInput.'%';
            $aResultado = $this->db->query($strQuery,array($strSearch,$strSearch,$strSearch))->result_array();
        }
        else
        {
            $aResultado = $this->db->query($strQuery)->result_array();
        }
                /*-----------------------------------------*/
         
     return $aResultado; 
    }

    function obtenerMarca()
    {
        $query= "SELECT *
                FROM brands;";
        return $this->db->query($query)->result_array();
    }

    function obtenerModelo()
    {
        $query= "SELECT *
                FROM models;";
        return $this->db->query($query)->result_array();
    }

    function cambiarInfo($id_carCambio,$marcaCambio,$modeloCambio,$versionCambio,$id_combustibleCambio,$consumoMedioCambio,$potenciaCambio,$torqueCambio,$pesoCambio,$id_etiquetaCambio,$likesCambio,$puntosSeguridadCambio,$comprasCambio,$rutaFotoCambio)
    {
        $query = "UPDATE cars
                SET id_brand = ?, id_model = ?, version = ?, id_combustible = ?, averageConsumption = ?,horsePower = ?, engineTorque = ?, weight = ?, safetyPoints = ?, mostBought = ?, id_etiqueta = ?, rutaFoto = ?, likes = ?
                WHERE id_car = ?;";
        return $this->db->query($query,array($marcaCambio,$modeloCambio,$versionCambio,$id_combustibleCambio,$consumoMedioCambio,$potenciaCambio,$torqueCambio,$pesoCambio,$puntosSeguridadCambio,$comprasCambio,$id_etiquetaCambio,$rutaFotoCambio,$likesCambio,$id_carCambio));
    }



    function crearModelo($id_brand,$nuevoModelo,$id_model=NULL)
    {
        if(isset($id_model) && $id_model!="")
        {
            $id_modelQuery="".$id_model.",";
            $valueQuery="id_model ,";
        }
        else
        {
            $id_modelQuery='';
            $valueQuery="";
        }
        $query = "INSERT INTO models (".$valueQuery."id_brand,model)
                VALUES (".$id_modelQuery."?,?)";
        return $this->db->query($query,array($id_brand,$nuevoModelo));
    }


    function crearMarca($nuevaMarca)
    {
        $query = "INSERT INTO brands (brand)
                VALUES (?)";
        return $this->db->query($query,array($nuevaMarca));
    }

    function crearCoches($marcaCrear,$modeloCrear,$versionCrear,$id_combustibleCrear,$consumoMedioCrear,$potenciaCrear,$torqueCrear,$pesoCrear,$id_etiquetaCrear,$likesCrear,$puntosSeguridadCrear,$comprasCrear,$rutaFotoCrear)
    {
        $query = "INSERT cars (id_brand, id_model, version, id_combustible, averageConsumption,horsePower, engineTorque, weight, safetyPoints, mostBought,id_etiqueta,rutaFoto,likes)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
                
        return $this->db->query($query,array($marcaCrear,$modeloCrear,$versionCrear,$id_combustibleCrear,$consumoMedioCrear,$potenciaCrear,$torqueCrear,$pesoCrear,$puntosSeguridadCrear,$comprasCrear,$id_etiquetaCrear,$rutaFotoCrear,$likesCrear));
    
    }

    function eliminarCocheAdmin($id_car)
    {
        $query="DELETE 
                FROM cars
                WHERE id_car = ?";
        return $this->db->query($query,array($id_car));
    }


    





}

?>