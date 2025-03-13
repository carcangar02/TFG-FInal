<h1>Gestion de Coches</h1>
<a href="<?php echo base_url();?>AdminController/menu"><button class="button">Volver</button></a>
<div class="buscadorUsusariosAdmin">
    <form class="formularioGestionUsuarios">
        <input class="input"type="number" id="id_car"placeholder="ID" min=0>
        <input class="input"type="text" id="strBusqueda" placeholder="Buscar">
        <p>Combustible :</p>
        <select id="id_combustible">
            <option value="">Todos</option>
            <?php
            foreach($combustibles as $combustible)
            {
                ?>
            <option value=<?php echo $combustible['id_combustible'] ?>><?php echo $combustible['CombustionType'] ?></option>
                <?php
            }
            ?>
        </select>
        <p>Etiqueta :</p>
        <select  id="id_etiqueta">
            <option value="">Todos</option>
            <?php
            foreach($etiquetas as $etiqueta)
            {
                ?>
            <option value=<?php echo $etiqueta['id_etiqueta'] ?>><?php echo $etiqueta['etiqueta'] ?></option>
                <?php
            }
            ?>
        </select>
        <button type="button" class="button" onclick=busqueda()>Buscar</button>
    </form>
    <button class="button" data-bs-toggle="modal" data-bs-target="#crearCoche" id='botonCrearCoche'>Crear coche</button>
    <button class="button" onclick=crearModelo()  data-bs-toggle="modal" data-bs-target="#crearModelo" id="crearModeloModal">Crear Modelo </button>
    <button class="button" onclick=crearMarca()   data-bs-toggle="modal" data-bs-target="#crearMarca"id="crearMarcaModal">Crear Marca </button>
</div>
<div>

    <table class="mostrarRegistros">
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Version</th>
            <th>Combustible</th>
            <th>Cosumo medio</th>
            <th>Pontencia</th>
            <th>Torque</th>
            <th>Peso</th>
            <th>Etiqueta</th>
            <th>Likes</th>
            <th>Puntos Seguridad</th>
            <th>Compras</th>
            <th>Ruta Foto</th>
        </tr>
        <?php   foreach($displayCoches as $coche) 
        {
        ?>
        <tr>    
            <td><?php echo $coche['id_car'];?> </td>
            <td><?php echo $coche['brand'];?> </td>
            <td><?php echo $coche['model'];?> </td>
            <td><?php echo $coche['version'];?> </td>
            <td><?php echo $coche['combustionType'];?> </td>
            <td><?php echo $coche['averageConsumption'];?> </td>
            <td><?php echo $coche['horsePower'];?> </td>
            <td><?php echo $coche['engineTorque'];?> </td>
            <td><?php echo $coche['weight'];?> </td>
            <td><?php echo $coche['etiqueta'];?> </td>
            <td><?php echo $coche['likes'];?> </td>
            <td><?php echo $coche['safetyPoints'];?> </td>
            <td><?php echo $coche['mostBought'];?> </td>
            <td><?php echo $coche['rutaFoto'];?> </td>
            <td>
                <button class="button"type="button" onclick=pasarvariableEliminar(<?php echo $coche['id_car']?>) data-bs-toggle="modal" data-bs-target="#eliminarCoche">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                </button>
            </td>
            <td>   
            <button class="button"  onclick=modalCambioInfo(<?php echo $coche['id_car']?>) data-bs-toggle="modal" data-bs-target="#editarCoche">Editar Informacion</button>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php echo $this->pagination->create_links(); ?>
</div>
                                            <!-- modal editar coche -->
<div class="modal fade" id="editarCoche" tabindex="-1" aria-labelledby="editarCocheLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modalCambioInfo" style="display:flex; flex-direction:column; gap:5px;">    

            <!-- vistaModalCambioInfo -->
             
      </div>
      <div class="modal-footer">
        <button type="button" class="button" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="button" onclick=cambiarInfo()>Editar Informacion</button>
      </div>
    </div>
  </div>
</div>
                                            <!-- modal crear marca -->
<div class="modal fade" id="crearMarca" tabindex="-1" aria-labelledby="crearMarcaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modalCrearMarca" style="display:flex; flex-direction:column; gap:5px;">     
          <input type="text" id="crearMarcaInput" class="input" placeholder="Nombre marca" >
      </div>
      <div class="modal-footer">
        <button type="button" class="button" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="button" onclick=crearMarca() id="btnCrearMarca">crear marca</button>
      </div>
    </div>
  </div>
</div>
                                        <!-- modal crear modelo -->
<div class="modal fade" id="crearModelo" tabindex="-1" aria-labelledby="crearModeloLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modalCrearModelo" style="display:flex; flex-direction:column; gap:5px;">     
          <input type="text" id="crearModeloInput" class="input"  placeholder="Nombre modelo" >
          <u>Marca</u> <select id='crearModeloIdMarca' class='marcaCrearModelo' required>
          <?php
          foreach($opcionesMarcas as $marca)
                {
                    ?>
                <option value=<?php echo $marca['id_brand'] ?> ><?php echo $marca['brand'] ?></option>
                    <?php
                }
                ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="button" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="button" onclick=crearModelo()  id="btnCrearModelo" >crear modelo</button>
      </div>
    </div>
  </div>
</div>



                                        <!-- modal crear coche -->
<div class="modal fade" id="crearCoche" tabindex="-1" aria-labelledby="crearCocheLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <form action="<?php echo base_url()?>AdminController/crearCoche" method = "POST" enctype="multipart/form-data">
            <div class="crearCoche" style="display:flex; flex-direction:column; gap:5px;">
                <u>Marca</u> <select name="marcaCrear" class='marcaCrear' onchange=selectDinamico() required>
                <?php
                foreach($opcionesMarcas as $marca)
                {
                    ?>
                <option value=<?php echo $marca['id_brand'] ?> ><?php echo $marca['brand'] ?></option>
                    <?php
                }
                ?>
              </select>
              <u>Modelo</u> <select name="modeloCrear" class="modelsCrear" required>
              <?php
                foreach($opcionesModelo as $modelo)
                {
                    ?>
                <option value=<?php echo $modelo['id_model'] ?>><?php echo $modelo['model'] ?></option>
                    <?php
                }
                ?>
              </select>
              <u>Version</u> <input class ="input" type="text" name="versionCrear" required>
              <u>Combustible</u> <select name="id_combustibleCrear" required>
                <?php
                foreach($combustibles as $combustible)
                {
                    ?>
                <option value=<?php echo $combustible['id_combustible'] ?>><?php echo $combustible['CombustionType'] ?></option>
                    <?php
                }
                ?>
              </select>
              <u>Cosumo medio</u> <input class ="input" type="number" step="0.01" min=0 name="consumoMedioCrear" required>
              <u>Pontencia</u> <input class ="input" type="number" step="0.01" min=0 name="potenciaCrear" required>
              <u>Torque</u> <input class ="input" type="number" step="0.01" min=0 name="torqueCrear" required>
              <u>Peso</u> <input class ="input" type="number" step="0.01" min=0 name="pesoCrear" required>
              <u>Etiqueta</u> <select  name="id_etiquetaCrear" required>
                <?php
                foreach($etiquetas as $etiqueta)
                {
                    ?>
                <option value=<?php echo $etiqueta['id_etiqueta'] ?>><?php echo $etiqueta['etiqueta'] ?></option>
                    <?php
                }
                ?>
              </select>
              <u>Likes</u> <input class ="input" type="number" name="likesCrear" required>
              <u>Puntos Seguridad</u> <input class ="input" type="number" name="puntosSeguridadCrear" required>
              <u>Compras</u> <input class ="input" type="number" name="comprasCrear" required>
              <u>Ruta Foto</u> <input class ="input" type="text" name="rutaFotoCrear" required>
              <input type="file" name="fotoCrear" accept=".png, .jpg, .jpeg">
            </div>
            <div class="modal-footer">
              <button type="button" class="button" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="button" id="btnCrearCoche">Crear Coche</button> 
            </div>
          </form>
    </div>
  </div>
</div>

                            <!-- modal eliminar coche -->
<div class="modal fade" id="eliminarCoche" tabindex="-1" aria-labelledby="eliminarCocheLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div style="display:flex; flex-direction:column; gap:5px;">     
          ¿Esta seguro de eliminar este coche?
      </div>
      <div class="modal-footer">
        <input type="hidden" id="eliminarCocheInput">
        <button type="button" class="button" data-bs-dismiss="modal">NO</button>
        <button type="submit" class="button" onclick=eliminarCoche()>SI</button>
      </div>
    </div>
  </div>
</div>


<script>


    document.getElementById('id_car').addEventListener('keypress', function (e)
        {   
            
            if (e.key === 'Enter') 
            {    
                e.preventDefault()
                busqueda()
            }
        });
    document.getElementById('strBusqueda').addEventListener('keypress', function (e)
    {   
        
        if (e.key === 'Enter') 
        {    
            e.preventDefault()
            busqueda()
        }
    });
     //Enviar datos de los inputs al controller
     function busqueda()
    {
        var id_car = document.getElementById('id_car').value
        var strBusqueda = document.getElementById('strBusqueda').value
        var id_combustible = document.getElementById('id_combustible').value
        var id_etiqueta = document.getElementById('id_etiqueta').value

        $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>AdminController/DisplayGestionCochesRefresh",
            data: { 'id_car': id_car,'strBusqueda': strBusqueda,'id_combustible': id_combustible,'id_etiqueta': id_etiqueta}
        })
        .done(function (e){
            // vacio contenedor de listas coches
            $(".mostrarRegistros").empty();

            // lo cargo con el nuevo contenido desde el controller
            $(".mostrarRegistros").append(e);
        });
    }


    function modalCambioInfo(id_car)
        {
            $.ajax({
            method: "POST",
            url: "modalCambioInfo",
            data: { 'id_car': id_car}
            })
            .done(function (e)
            {
            $(".modalCambioInfo").empty();
            //Cargo el modalInfo
            $(".modalCambioInfo").append(e);
            });
        }

        function cambiarInfo()
        {
            const marcaCambio = document.getElementById('marcaCambio').value
            const modeloCambio = document.getElementById('modeloCambio').value
            const versionCambio = document.getElementById('versionCambio').value
            const id_combustibleCambio = document.getElementById('id_combustibleCambio').value
            const consumoMedioCambio = document.getElementById('consumoMedioCambio').value
            const potenciaCambio = document.getElementById('potenciaCambio').value
            const torqueCambio = document.getElementById('torqueCambio').value
            const pesoCambio = document.getElementById('pesoCambio').value
            const id_etiquetaCambio = document.getElementById('id_etiquetaCambio').value
            const likesCambio = document.getElementById('likesCambio').value
            const puntosSeguridadCambio = document.getElementById('puntosSeguridadCambio').value
            const comprasCambio = document.getElementById('comprasCambio').value
            const rutaFotoCambio = document.getElementById('rutaFotoCambio').value
            const id_carCambio = document.getElementById('id_carCambio').value

            $.ajax({
                method: "POST",
                url: "cambiarInfo",
                data: { 'id_carCambio': id_carCambio,'marcaCambio': marcaCambio,'modeloCambio': modeloCambio,'versionCambio': versionCambio,'id_combustibleCambio': id_combustibleCambio,'consumoMedioCambio': consumoMedioCambio,'potenciaCambio': potenciaCambio,'torqueCambio': torqueCambio,'pesoCambio': pesoCambio,'id_etiquetaCambio': id_etiquetaCambio,'likesCambio': likesCambio,'puntosSeguridadCambio': puntosSeguridadCambio,'comprasCambio': comprasCambio,'rutaFotoCambio': rutaFotoCambio,}
                })
                .done(function (e)
                {
                $('.modal').modal('hide');
                $(".mostrarRegistros").empty();
                //Cargo el modalInfo
                $(".mostrarRegistros").append(e);
                });
        }



        function crearModelo()
        {
            const inputModelo = document.getElementById('crearModeloInput').value
            const id_marca = document.getElementById('crearModeloIdMarca').value
            
            $.ajax({
            method: "POST",
            url: "crearModelo",
            data: { 'inputModelo': inputModelo,'id_marca':id_marca}
            })
            .done(function (e)
            {
            $('.modal').modal('hide');
            $(".modalCambioInfo").empty();
            //Cargo el modalInfo
            $(".modalCambioInfo").append(e);
            });
        }




        function crearMarca()
        { 
            const inputMarca = document.getElementById('crearMarcaInput').value



            $.ajax({
            method: "POST",
            url: "crearMarca",
            data: { 'inputMarca': inputMarca}
            })
            .done(function (e)
            {
            $('.modal').modal('hide');
            $(".modal-bodyInfo").empty();
            //Cargo el modalInfo
            $(".modal-bodyInfo").append(e);
            });
        }

        function pasarvariableEliminar(id_car)
        {
            document.getElementById('eliminarCocheInput').value = id_car
        }

        function eliminarCoche()
        {
            const id_car = document.getElementById('eliminarCocheInput').value

            $.ajax({
            method: "POST",
            url: "eliminarCoche",
            data: {'id_car': id_car}
            })
            .done(function (e)
            {
            $('.modal').modal('hide');
            $(".mostrarRegistros").empty();
            //Cargo el modalInfo
            $(".mostrarRegistros").append(e);
            });
        }


        function selectDinamico()
        {
          const id_brand = document.querySelector('.marcaCrear').value
          
          $.ajax({
            method: "POST",
            url: "selectDinamico",
            data: {'id_brand': id_brand}
            })
            .done(function (e)
            {
            $(".modelsCrear").empty();
            $(".modelsCrear").append(e);
            });
        }



</script>
