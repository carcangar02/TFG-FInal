<?php  

//Uso el id de session para mostrar alternativamente el boton de inicio de sesion o el del menu del perfil
$intUsuarioLogueado=$this->session->userdata('login_id');
if(isset($intUsuarioLogueado) && $intUsuarioLogueado !="")
{
    $intLogged=1;
}
else
{
    $intLogged=0;
}
?>
<div class="buscadorDisplay" >
    <input type="hidden" id="isLogged" value= <?php echo $intLogged?>>
    <div class="contenedorBuscador">
        <button class="filter button btn" type="button" data-bs-toggle="modal" data-bs-target="#modalFiltros">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
            </svg>
        </button>
        <form class="formBuscador">
            <input class="input" id="valorBusqueda"  type="text" placeholder="Buscar">
            <button class="button btnBusqueda" type="button" onclick=busqueda()>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </form>

        <!-- Tengo que hacerque salga en formato (444)
                                                 (444)etc -->
            <div class="row divContenedorCoches divContenedorCocheStyle divContenedorCocheStyle2" id="divContendorCochesBuscador" >
                <?php
                foreach($displayCoches as $coche){
                ?>
                    <div class="contenedorCoche idCoche=<?php echo $coche['id_car'];?>"> 
                            <img class="imagen" src=<?php $http='http'; $testRuta = strpos($coche['rutaFoto'],$http);   if($testRuta===0){echo $coche['rutaFoto'];}else {echo base_url().''.$coche['rutaFoto'].'';} ?>>
                                <div class="contenedorCarInfo">
                                    <div class="coche">
                                    <?php echo "<u>Marca:</u> ".$coche['brand']."<br>"."<u>Modelo:</u> ".$coche['model']."<br>"."<u>Version:</u> ".$coche['version']; ?> 
                                    </div>
                                    <div class="divBtn">
                                            <button id="infoBtn" class="button col-md-12 col-lg-6" onclick=abrirModalInfo(<?php echo $coche['id_car']?>) data-bs-toggle="modal" data-bs-target="#modalInfo">+info</button>
                                            <button id="agregarListaBtn" class="button col-md-12 col-lg-6" data-bs-toggle="modal" data-bs-target="#agregarCocheLista" onclick="cambiarOnclickModalListas(<?php echo $coche['id_car']; ?>)">Agregar a mi lista</button>
                                    </div>
                                </div>
                        </div>                       
                <?php
                    }
                ?>
            </div>
    </div>



          
                <a href="<?php echo base_url();?>LoginController/login"><button type="button" class="btnLogin<?php echo $intLogged ?> button">Iniciar Sesion</button></a>
                <a href="<?php echo base_url();?>MenuController/menu"><button type="button" class="btnPerfil<?php echo $intLogged ?> button">Perfil</button></a>
       
            





                                 <!-- Modal de los filtros -->

            <div class="modal " id="modalFiltros" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content"  id="modalFiltros">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalFiltrosLabel">Filtros</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <ul>
                                    <li class="elementoFiltros">
                                    Combustible
                                    <select name="tipo_combustible" id="tipo_combustible">
                                    <option value="">Todos</option>

                                    <?php
                                            foreach($combustibles as $filtroCombustible)
                                            {
                                                ?>
                                            <option value=<?php echo $filtroCombustible['id_combustible'] ?>><?php echo $filtroCombustible['CombustionType'] ?></option>
                                                <?php
                                            }
                                    ?>
                                    </select>
                                    </li>
                                    <li class="elementoFiltros">
                                        Potencia:
                                        <input type="number" class="input"id="potencia_min" name="potencia_min" placeholder="Potencia mínima (cv)">
                                        <input type="number" class="input" id="potencia_max" name="potencia_max" placeholder="Potencia máxima (cv)">
                                    </li>
                                    <li class="elementoFiltros">
                                        Etiqueta
                                        <select id="etiqueta" name="etiqueta">
                                            <option value="">Todos</option>
                                            <?php
                                            foreach($etiquetas as $filtroEtiqueta)
                                            {
                                                ?>
                                            <option value=<?php echo $filtroEtiqueta['id_etiqueta'] ?>><?php echo $filtroEtiqueta['etiqueta'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </li>
                                    <li class="elementoFiltros">
                                        Ordenar por:
                                        <select id="ordenar" name="ordenar">
                                            <option value="">Todos</option>
                                            <option value="averageConsumption">Consumo medio</option>
                                            <option value="weight">Peso</option>
                                            <option value="likes">Likes</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn button" onclick=busqueda()>Aplicar Filtros</button>
                            </div>
                        </form>
                        </div>
                    </div>
            </div>


    </div>




                                        <!-- Modal Agregar Coche a lista -->

                    <div class="modal fade" id="agregarCocheLista" tabindex="-1" aria-labelledby="agregarCocheListaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="agregarCocheListaLabel">Seleccione la lista</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary dropdown-toggle button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Listas
                                        </button>
                                        <ul class="dropdown-menu">
                                        <input class="id_carInput" type="hidden" value=0>

                                            <?php 
                                            if($intLogged==1)
                                            {
                                                foreach ($datosListas as $lista)
                                                {
                                            ?>
                                            <li>
                                                <button id="btnOnclickModalListaCoches" style= "border:none; background-color:rgba(0,0,0,0);" onclick=pasoDeDatosAGuardarCoches(<?php echo $lista['id_lista']?>)><a class="dropdown-item"><?php echo $lista['nombreLista'];?></a></button>
                                            </li>
                                            <?php
                                                }
                                            }
                                            else
                                            {
                                            ?>
                                            <li>No has iniciado Sesion</li>
                                            <?php
                                            }
                                            ?>                                  
                                        </ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    

                                                <!-- Modal Info -->
                    <div class="modal modalInfo " id="modalInfo" tabindex="-1" aria-labelledby="modalinfoLabel" aria-hidden="true">
                        <div class="modal-dialog">
                             <div class="modal-content"  id="modalinfoLabel">
                                <div class="modal-header">
                                    <h1>Informacion del Coche</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-bodyInfo" id="contenidoModalInfo">    
                                </div>
                            </div>
                        </div>
                    </div>
             

    
</div>
<script>


    

    //Para poder mandar los parametros de busqueda con el enter
    document.getElementById('valorBusqueda').addEventListener('keypress', function (e)
    {   
        
        if (e.key === 'Enter') 
        {    
            e.preventDefault()
            busqueda()
        }
    });

    //pasa los parametros de busqueda y recarga la seccion del contenido
    function busqueda()
    {
        const strBusquedaInput = document.getElementById('valorBusqueda').value
        const tipo_combustible = document.getElementById('tipo_combustible').value
        const potencia_min = document.getElementById('potencia_min').value
        const potencia_max = document.getElementById('potencia_max').value
        const etiqueta = document.getElementById('etiqueta').value
        const ordenar = document.getElementById('ordenar').value

        //Aqui añadir un try catch
        $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>BuscadorController/refresh",
            data: { 'strBusquedaInput': strBusquedaInput,'tipo_combustible': tipo_combustible,'potencia_min': potencia_min,'potencia_max': potencia_max,'etiqueta': etiqueta,'ordenar': ordenar }
        })
        .done(function (e){
            // cierro modales activos
            $('.modal').modal('hide');

            // vacio contenedor de listas coches
            $(".divContenedorCoches").empty();

            // lo cargo con el nuevo contenido desde el controller
            $(".divContenedorCoches").append(e);
        });
        
    }

    //estas funciones sirven para ir pasando la informacion de id_car y id_lista desde el contenedro del coche hasta el boton de guardar coche
    function cambiarOnclickModalListas(id_car)
    {
        document.querySelector('.id_carInput').value = id_car
    }

    //funcion que recoje el id_car el id_lista y se las pasa a la funcion guardar coches
    function pasoDeDatosAGuardarCoches(id_lista)
    {
        var id_car = document.querySelector('.id_carInput').value
        guardarCoches(id_car,id_lista)
    }


         
    //Recibe el id_coche y el id_lista y los pasa al controller donde se mandan al model y se ejecuta
    function guardarCoches(intId_coche,intId_lista)
    {
        alert('Coche Agregado')
        
        $.ajax({
            method: "POST",
            url: "guardarCoches",
            data: { 'intId_coche': intId_coche, 'intId_lista': intId_lista }
        })
        .done(function (){
            // cierro modales activos
            $('.modal').modal('hide');
           
        });

       

    }
    //Funcion que manda la id del coche cuyo modal de info se va a mostrar
    function abrirModalInfo(intId_coche)
        {
            $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>BuscadorController/abrirModalInfo",
            data: { 'intId_coche': intId_coche}
            })
            .done(function (e)
            {
            $(".modal-bodyInfo").empty();
            //Cargo el modalInfo
            $(".modal-bodyInfo").append(e);

            
            });
        }


        


</script>