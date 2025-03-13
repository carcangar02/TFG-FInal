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