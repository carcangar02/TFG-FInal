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