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
                    if($user['status']=='Activo')
                    {
                        ?>
                        <button class="button" onclick=cambioStatus(2,<?php echo $user['id_usuario'];?>)>Desactivar</button>
                        <?php
                    }
                    else
                    {
                        ?>
                        <button class="button" onclick=cambioStatus(1,<?php echo $user['id_usuario'];?>)>Activar</button>
                        <?php
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
                ?>
            </td>
        </tr>
        <?php } ?>
    </table>