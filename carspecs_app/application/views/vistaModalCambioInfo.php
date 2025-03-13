            
            <?php foreach($carInfo as $info) ?>
            <u>Marca</u> <select id="marcaCambio" class='marcaCrear' class='marcaCrear' onchange=selectDinamico()>  
            <option value=<?php echo $info['id_brand'] ?>><?php echo $info['brand'] ?> || Actual</option>
            <?php
            foreach($opcionesMarcas as $marca)
            {
                ?>
            <option value=<?php echo $marca['id_brand'] ?>><?php echo $marca['brand'] ?></option>
                <?php
            }
            ?>
          </select> 
          <u>Modelo</u> <select id="modeloCambio" class="modelsCrear"> 
            <option value=<?php echo $info['id_model'] ?>><?php echo $info['model'] ?> || Actual</option>
          <?php
            foreach($opcionesModelo as $modelo)
            {
                ?>
            <option value=<?php echo $modelo['id_model'] ?>><?php echo $modelo['model'] ?></option>
                <?php
            }
            ?>
          </select> 
          <u>Version</u> <input class ="input" type="text" id="versionCambio" value="<?php echo $info['version']?>">  
          <u>Combustible</u> <select id="id_combustibleCambio">
            <option value=<?php echo $info['id_combustible'] ?>><?php echo $info['combustionType'] ?> || Actual</option>
            <?php
            foreach($combustibles as $combustible)
            {
                ?>
            <option value=<?php echo $combustible['id_combustible'] ?>><?php echo $combustible['CombustionType'] ?></option>
                <?php
            }
            ?>
          </select>  
          <u>Cosumo medio</u> <input class ="input" type="number" min=0 id="consumoMedioCambio" value="<?php echo $info['averageConsumption']?>">  
          <u>Pontencia</u> <input class ="input" type="number" min=0 id="potenciaCambio" value="<?php echo $info['horsePower']?>">  
          <u>Torque</u> <input class ="input" type="number" min=0 id="torqueCambio" value="<?php echo $info['engineTorque']?>">  
          <u>Peso</u> <input class ="input" type="number" min=0 id="pesoCambio" value="<?php echo $info['weight']?>">  
          <u>Etiqueta</u> <select  id="id_etiquetaCambio">
            <option value=<?php echo $info['id_etiqueta'] ?>><?php echo $info['etiqueta'] ?> || Actual</option>
            <?php
            foreach($etiquetas as $etiqueta)
            {
                ?>
            <option value=<?php echo $etiqueta['id_etiqueta'] ?>><?php echo $etiqueta['etiqueta'] ?></option>
                <?php
            }
            ?>
          </select>
          <u>Likes</u> <input class ="input" type="number" id="likesCambio" value="<?php echo $info['likes']?>">  
          <u>Puntos Seguridad</u> <input class ="input" type="number" id="puntosSeguridadCambio" value="<?php echo $info['safetyPoints']?>">  
          <u>Compras</u> <input class ="input" type="number" id="comprasCambio" value="<?php echo $info['mostBought']?>">  
          <u>Ruta Foto</u> <input class ="input" type="text" id="rutaFotoCambio" value="<?php echo $info['rutaFoto']?>"> 
          <input type="hidden" id="id_carCambio"value="<?php echo $info['id_car']?>"> 