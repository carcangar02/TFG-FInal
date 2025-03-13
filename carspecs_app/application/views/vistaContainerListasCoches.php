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
                            <img class="imagen" src=<?php echo base_url($coche['rutaFoto']); ?>>
                            <div class="contenedorCarInfo">
                                <div class="coche">
                                    <?php echo "<u>Marca:</u> ".$coche['brand']."<br>"."<u>Modelo:</u> ".$coche['model']."<br>"."<u>Version:</u> ".$coche['version']; ?> 
                                </div>
                                <div class="divBtn">
                                    <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#modalBorrarCoche_<?php echo $coche['id_lista'];?>_<?php echo $coche['id_car'];?>">Eliminar</button>
                                    <button id="infoBtn" class="button col-md-12 col-lg-6">+info</button>
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
                                   Seguro que quieres eliminar el <?php echo $coche['brand']." ".$coche['model']." ".$coche['version'];?> de la lista "<?php echo $coche['nombreLista'];?>"
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