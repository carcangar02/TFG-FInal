<?php foreach($coche as $info){ ?>

    <img class="imagen" src="<?php echo $info['rutaFoto']; ?>" alt="Fotito">
    <ul class="infococheInfo">
        <li><u>Marca :</u><?php echo $info['brand']?></li>
        <li><u>Modelo :</u><?php echo $info['model']?></li>
        <li><u>Version :</u><?php echo $info['version']?></li>
        <li><u>Tipo Combustion :</u><?php echo $info['combustionType']?></li>
        <li><u>Consumo Medio :</u><?php echo $info['averageConsumption']?>L</li>
        <li><u>Potencia :</u><?php echo $info['horsePower']?>cv</li>
        <li><u>Par Motor :</u><?php echo $info['engineTorque']?>Nm</li>
        <li><u>Peso :</u><?php echo $info['weight']?>kg</li>
        <li><u>Etiqueta :</u><?php echo $info['etiqueta']?></li>
        <li><u>Likes :</u><?php echo $info['likes']?></li>
    </ul>
    <div class="stats">
        <u>Seguridad :</u><?php echo $info['safetyPoints']?>
        <u>Ventas :</u><?php echo $info['mostBought']?>
    </div>
<?php } ?>