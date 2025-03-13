<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<H1>Gestion de Usuarios</H1>
<a href="<?php echo base_url();?>AdminController/menu"><button class="button">Volver</button></a>
<div class="buscadorUsusariosAdmin">
    <form class="formularioGestionUsuarios">
        <input class="input"type="number" id="id_usuario"placeholder="ID" min=0>
        <input class="input"type="text" id="nombreUsuario" placeholder="Nombre de Usuario">
        <input class="input"type="email" id="email"placeholder="Email">
        <p>Roles :</p>
        <select id="id_rol">
            <option value="">Todos</option>
            <?php
            foreach($roles as $rol)
            {
                ?>
            <option value=<?php echo $rol['id_rol'] ?>><?php echo $rol['rol'] ?></option>
                <?php
            }
            ?>
        </select>
        <p>Status :</p>
        <select  id="id_status">
            <option value="">Todos</option>
            <?php
            foreach($statuses as $status)
            {
                ?>
            <option value=<?php echo $status['id_status'] ?>><?php echo $status['status'] ?></option>
                <?php
            }
            ?>
        </select>
        <button type="button" class="button" onclick=busqueda()>Buscar</button>
    </form>

</div>
<div>

    <table class="mostrarRegistros">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Fecha_VIP</th>
            <th>Status</th>
        </tr>
        <?php   foreach($usuarios as $user) 
        {
        ?>
        <tr>    
            <td><?php echo $user['id_usuario'];?></td>
            <td><?php echo $user['nombreUsuario'];?></td>
            <td><?php echo $user['email'];?></td>
            <td><?php echo $user['rol'];?></td>
            <td><?php echo $user['fecha_VIP'];?></td>
            <td><?php echo $user['status'];?></td>
            <td>||
                <?php  
                if($user['rol']=='ADMIN')
                {

                }
                else
                {
                    if($user['status']=='Activo')
                    {
                        ?>
                        <button class="button" onclick=cambioStatus(2,<?php echo $user['id_usuario'];?>)>Desactivar</button>
                        <?php
                    }
                    if($user['status']=='Inactivo')
                    {
                        ?>
                        <button class="button" onclick=cambioStatus(1,<?php echo $user['id_usuario'];?>)>Activar</button>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php   
                    if($user['rol']=='VIP')
                    {
                        ?>
                        <button class="button" onclick=pasoVariables(<?php echo $user['id_usuario']?>) data-bs-toggle="modal" data-bs-target="#cambioPonerVIP">Quitar VIP</button>
                        <?php
                    }
                    if($user['rol']=='NO VIP')
                    {
                        ?>
                        <button class="button"  onclick=pasoVariables(<?php echo $user['id_usuario']?>) data-bs-toggle="modal" data-bs-target="#cambioVIP">Hacer VIP</button>
                        <?php
                    }
                    if($user['rol']=='ADMIN')
                    {

                    }
                ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php echo $this->pagination->create_links(); ?>
</div>

<div>

<figure class="highcharts-figure">
    <div id="container"></div>
</figure>

</div>


                            <!-- Modal Cambio Poner VIP -->
<div class="modal fade" id="cambioVIP" tabindex="-1" aria-labelledby="cambioVIPLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="id_usuarioModal" value=0>
            <input type="date" id="fechaCambioVIP" class="input">
      </div>
      <div class="modal-footer">
        <button type="button" class="button" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="button" onclick=cambioVIP(1)>Hacer VIP</button>
      </div>
    </div>
  </div>
</div>
                            <!-- Modal Cambio Quitar VIP -->
<div class="modal fade" id="cambioPonerVIP" tabindex="-1" aria-labelledby="cambioPonerVIPLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="id_usuarioModal" value=0>
            ¿Seguro que quiere quitarle el rol de VIP a este usuario?
      </div>
      <div class="modal-footer">
        <button type="button" class="button" data-bs-dismiss="modal">NO</button>
        <button type="submit" class="button" onclick=cambioVIP(2)>SI</button>
      </div>
    </div>
  </div>
</div>





<input type="hidden" id="json_n_subs" value=<?php echo $json_n_subs?>>
<input type="hidden" id="json_n_usuarios" value=<?php echo$json_n_usuarios?>>
<input type="hidden" id="json_periodo" value=<?php echo $json_periodo?>>
<input type="hidden" id="json_n_no_subs" value=<?php echo $json_n_no_subs?>>
<script>




    //Enviar datos de los inputs al controller
     function busqueda()
    {
        var id_usuario = document.getElementById('id_usuario').value
        var nombreUsuario = document.getElementById('nombreUsuario').value
        var email = document.getElementById('email').value
        var id_rol = document.getElementById('id_rol').value
        var id_status = document.getElementById('id_status').value
        $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>AdminController/DisplayGestionUsuariosRefresh",
            data: { 'id_usuario': id_usuario,'nombreUsuario': nombreUsuario,'email': email,'id_rol': id_rol,'id_status': id_status }
        })
        .done(function (e){
            // vacio contenedor de listas coches
            $(".mostrarRegistros").empty();

            // lo cargo con el nuevo contenido desde el controller
            $(".mostrarRegistros").append(e);
        });
    }

    function cambioStatus(status,id_usuario)
    {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>AdminController/Activar_Desactivar",
            data: {'id_usuario': id_usuario,'status':status}
        })
        .done(function (e){
            // vacio contenedor de listas coches
            $(".mostrarRegistros").empty();

            // lo cargo con el nuevo contenido desde el controller
            $(".mostrarRegistros").append(e);
        });

    }
    //Funcion intermedia para enviar datos a la funcion cambioVIP
    function pasoVariables(id_usuario)
    {
        document.querySelector('.id_usuarioModal').value = id_usuario
    }



    //envio los datos del input para cambiar el campo VIP
    function cambioVIP(rol)
    {
        if(rol==1)
        {
        var fechaCambioVIP = document.querySelector('#fechaCambioVIP').value
        }
        var id_usuario = document.querySelector('.id_usuarioModal').value
        
        $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>AdminController/cambioVIP",
            data: {'id_usuario': id_usuario,'fechaCambioVIP':fechaCambioVIP}
        })
        .done(function (e){
            $('.modal').modal('hide');
            // vacio contenedor de listas coches
            $(".mostrarRegistros").empty();
            // lo cargo con el nuevo contenido desde el controller
            $(".mostrarRegistros").append(e);
            
        });
    }



    /*----------------GRAFICA-------------------*/
    const json_n_subs = document.getElementById('json_n_subs').value
    const json_n_usuarios = document.getElementById('json_n_usuarios').value
    const json_periodo = document.getElementById('json_periodo').value
    const json_n_no_subs = document.getElementById('json_n_no_subs').value


    const periodoArray = JSON.parse(json_periodo);
    const n_usuariosArray = JSON.parse(json_n_usuarios);
    const n_subsArray = JSON.parse(json_n_subs);
    const no_subsArray = JSON.parse(json_n_no_subs);






    

    Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Datos de Subscripciones',
        align: 'left'
    },
 
    xAxis: {
        categories: periodoArray,
        crosshair: true,
       
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Numero de Usuarios'
        }
    },
    tooltip: {
       
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'VIP',
            data: n_subsArray
        },
        {
            name: 'No VIP',
            data: no_subsArray
        },
        {
            name: 'Num Usuarios',
            data: n_usuariosArray
        }
    ]
});
</script>


