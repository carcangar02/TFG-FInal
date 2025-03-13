<div class="displayAjustesUsuario">
    <h1 class="header">Datos de Usuario</h1>
    <div class="divinfo ">
    <a href="<?php echo base_url();?>MenuController/menu"><button type="button" class="button" >Perfil</button></a>
        <ul class="infoLista">
            <?php foreach($datosUsuario as $infoUser)?>
            <li class="infoElement"><u>Nombre Usuario</u> :<?php echo $infoUser['nombreUsuario']?><button class="button btnLi" data-bs-toggle="modal" data-bs-target="#modalCambiarNombreUsuario">Cambiar</button></li>
            <li class="infoElement"><u>Email</u> :<?php echo $infoUser['email']?><button class="button btnLi" data-bs-toggle="modal" data-bs-target="#modalCambiarEmail">Cambiar</button></li>
            <li class="infoElement"><u>Rol</u> :<?php echo $infoUser['rol']?></li>
            <?php
             if($infoUser['fecha_VIP']!=NULL)
            {
            ?>
            <li class="infoElement"><u>VIP hasta</u> : <?php echo $infoUser['fecha_VIP']?></li>
            <?php
            }
            ?>
        </ul>   
    </div>
    <div class="divBtn">
        <button class="button"  data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">Cambiar Contraseña</button>
       
        <?php
        if($infoUser['rol']=="NO VIP")
        {
        ?>
        <a href="<?php echo base_url()?>PagosController/displayOpcionesPago"><button class="button">Suscribirse</button></a>
        <?php
        }
        ?>
    </div>

                                            <!-- modal cambio email -->
                        <div class="modal fade" id="modalCambiarEmail" tabindex="-1" aria-labelledby="modalCambiarEmailLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalCambiarEmailLabel">Cambiar Email</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                            <form>
                                                <input type="email" class="input" id="cambiarEmail" placeholder="Email">
                                            </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="button" onclick=cambiarEmail()>Guardar Cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                                              <!-- modal cambio nombreUsuario -->
                        <div class="modal fade" id="modalCambiarNombreUsuario" tabindex="-1" aria-labelledby="modalCambiarNombreUsuarioLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalCambiarNombreUsuarioLabel">Cambiar Nombre de Usuario</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input type="text" class="input" id="cambiarNombreUsuario" placeholder="Nombre de Usuario" >
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="button"onclick=cambiarNombreUsuario()>Guardar Cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                                                                      <!-- modal cambio contrasena -->
                        <div class="modal fade" id="modalCambiarContrasena" tabindex="-1" aria-labelledby="modalContrasenaLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalCambiarContrasenaLabel">Cambiar Contraseña</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input type="text" class="input" id="cambiarContrasena" placeholder="Introduzca la contraseña" >
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="button"onclick=cambiarContrasena()>Guardar Cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
<script>
 




    document.getElementById('cambiarEmail').addEventListener('keypress', function (e)
    {   
        
        if (e.key === 'Enter') 
        {    
            e.preventDefault()
            cambiarEmail()
        }
    });

    document.getElementById('cambiarNombreUsuario').addEventListener('keypress', function (e)
    {   
        
        if (e.key === 'Enter') 
        {    
            e.preventDefault()
            cambiarNombreUsuario()
        }
    });

    function cambiarEmail()
    {

        const email = document.getElementById('cambiarEmail').value
        const validarEmail = new validaciones(email)
        if(validarEmail.validarEmail()==true)
        {
            $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>AjustesUsuarioController/cambiarEmail",
            data: {'email':email}
        })
        .done(function (e){
            // cierro modales activos
            $('.modal').modal('hide');

            // vacio contenedor de listas coches
            $(".infoLista").empty();

            // lo cargo con el nuevo contenido desde el controller
            $(".infoLista").append(e);
            
        });
        }

    }


    function cambiarContrasena()
    {

        const contrasena = document.getElementById('cambiarContrasena').value
        const validarPassword = new validaciones(contrasena)
        if(validarPassword.validarPassword()==true)
        {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url();?>AjustesUsuarioController/cambiarContrasena",
                data: {'contrasena':contrasena}
            })
            .done(function (e){
                // cierro modales activos
                $('.modal').modal('hide');
                alert('Contrasena cambiada');
                
            });
        }
    }




    function cambiarNombreUsuario()
    {
        
        const nuevoNombreUsuario = document.getElementById('cambiarNombreUsuario').value
        const validarNombre = new validaciones(nuevoNombreUsuario)
        if(validarNombre.validarNombre()==true)
        {
            $.ajax({
            method: "POST",
            url: "<?php echo base_url();?>AjustesUsuarioController/cambiarNombreUsuario",
            data: {'nuevoNombreUsuario':nuevoNombreUsuario}
            })
            .done(function (e){
                // cierro modales activos
                $('.modal').modal('hide');

                // vacio contenedor de listas coches
                $(".infoLista").empty();

                // lo cargo con el nuevo contenido desde el controller
                $(".infoLista").append(e);
                
            });  
        }

     
    }

</script>


</div>