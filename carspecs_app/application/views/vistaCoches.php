
<div class="menuUser">
        <button type="button" class="button perfilBtn" data-bs-toggle="modal" data-bs-target="#modalDesplegableMenu">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
            </svg>
        </button>
        <a href="<?php echo base_url();?>BuscadorController/display">
            <button class="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </a>
        <button type="button" class="btn  button" data-bs-toggle="modal" data-bs-target="#agregarListaModal">
            + Agregar Lista
        </button>    
     <div class="row divContenedorCoches divContenedorCocheStyle divContenedorCocheStyle1" >
        <?php
        foreach ($listasCoches as $nombreLista => $listaCoches) 
        {   //Vuelvo a separar nomnbreLista de id_lista
            list($nombreLista, $id_lista) = explode('|', $nombreLista);
        ?>
            <div class="col col-lg-2 divListaCoches_ listaCochesStyle">
                
                <h3 class="nombreLista">
                    <?php echo $nombreLista;?>
                    <button class="button"type="button" onclick=eliminarListas(<?php echo $id_lista?>)>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                    </button>
                </h3>
               
                
                <?php
                    if(is_null($listaCoches[0]['id_car']))
                    {
                      echo "<span class = 'emptyList' ><h3>Lista vacia</h3></span>";
                    }else{
                        foreach ($listaCoches as $coche)
                        {
                ?>
                        <div class="contenedorCoche idCoche=<?php echo $coche['id_car'];?> idLista=<?php echo $coche['id_lista'];?>"  >
                            <img class="imagen" src=<?php echo $coche['rutaFoto']; ?>>
                            <div class="contenedorCarInfo">
                                <div class="coche">
                                    <?php echo "<u>Marca:</u> ".$coche['brand']."<br>"."<u>Modelo:</u> ".$coche['model']."<br>"."<u>Version:</u> ".$coche['version']; ?> 
                                </div>
                                <div class="divBtn">
                                    <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#modalBorrarCoche_<?php echo $coche['id_lista'];?>_<?php echo $coche['id_car'];?>">Eliminar</button>
                                    <button id="infoBtn" class="button col-md-12 col-lg-6" onclick=abrirModalInfo(<?php echo $coche['id_car']?>)   data-bs-toggle="modal" data-bs-target="#modalInfo">+info</button>
                                </div>
                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="modalBorrarCoche_<?php echo $coche['id_lista'];?>_<?php echo $coche['id_car'];?>" tabindex="-1" aria-labelledby="modalBorrarCoche" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalBorrarCoche">Eliminar Coche</h1>
                                
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                   Seguro que quieres eliminar el <?php echo $coche['brand']." ".$coche['model']." ".$coche['version'];?> de la lista "<?php echo $nombreLista;?>"
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn button" data-bs-dismiss="modal">No</button>
                                    <button type="button" class="btn button confirmarBorrar" onclick=eliminarCoche(<?php echo $coche['id_lista'];?>,<?php echo $coche['id_car'];?>)>Si</button>
                              </div>
                            </div>
                          </div>
                        </div>
                <?php 
                        } 
                    }
                ?>   

            </div>    
        <?php
        }
        ?>
    </div>

                            <!-- modal perfil -->
                            <div class="modal " id="modalDesplegableMenu" tabindex="-1" aria-labelledby="modalDesplegableMenu" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content"  id="modalFiltros">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="modalDesplegableMenuLabel">Menu</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    <li>
                                                    <a href="<?php echo base_url()?>AjustesUsuarioController/displayAjustesUsuario"><button class="button">Editar Perfil</button></a>
                                                    </li>
                                                    <li class="VIPDisplayNone<?php echo $VIP?>">
                                                    <a href="<?php echo base_url()?>PagosController/displayOpcionesPago"><button class="button">Subscribete</button></a>
                                                    </li>
                                                    <li>
                                                        <form action="cerrarSesion" method="post">
                                                            <button type="submit" class="button">
                                                                Cerrar Sesion
                                                            </button>
                                                         </form>
                                                    </li>
                                                 </ul>
                                            </div>
                                        </div>
                                    </div>
                            </div>




                            <!-- modal agregar listas -->
                            <div class="modal fade" id="agregarListaModal" tabindex="-1" aria-labelledby="agregarListaModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Lista</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="crearLista" method="post">
                                        <div class="modal-body">
                                            <input type="text" class="inputCrearLista input" id="nombreNuevaLista" placeholder="Nombre de la lista">
                                        </div>
                                        <div class="modal-footer">
                                                <button type="button" class="button" onclick=crearNuevaLista()>
                                                     + Agregar
                                                </button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal " id="modalinfo" tabindex="-1" aria-labelledby="modalDesplegableMenu" aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content"  id="modalFiltros">
                                         <div class="modal-header">
                                             <h1>Nombre del Coche</h1>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                         </div>
                                         <div class="modal-body" id="contenidoModalInfo">
                                             
                                         </div>
                                     </div>
                                 </div>
                             </div>



                                                                        <!-- Modal Info -->
                                <div class="modal modalInfo " id="modalInfo" tabindex="-1" aria-labelledby="mmodalinfoLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content"  id="modalinfoLabel">
                                            <div class="modal-header">
                                                <h1>Informacion del Coche</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-bodyInfo">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>






    </div>
</div>



                                                
                                                   
                                                

<script>


    document.getElementById('nombreNuevaLista').addEventListener('keypress', function (e)
        {   
            
            if (e.key === 'Enter') 
            {    
                e.preventDefault()
                crearNuevaLista()
            }
        });

       




    // CREO FUNCION ELIMINAR COCHE

    function eliminarCoche(idLista, idCoche)
    {

        $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>MenuController/eliminarCoche",
            data: { 'id_car': idCoche,'id_lista': idLista }
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




    function crearNuevaLista()
    {
    const strNombreNuevaLista = document.getElementById('nombreNuevaLista').value
    $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>MenuController/crearLista",
            data: { 'strNombreNuevaLista': strNombreNuevaLista }
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


    function eliminarListas(intId_lista)
    {
        
        $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>MenuController/eliminarLista",
            data: { 'intId_lista': intId_lista }
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