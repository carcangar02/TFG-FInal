<?php
    foreach($displayCoches as $coche){
    ?>
        <div class="contenedorCoche idCoche=<?php echo $coche['id_car'];?>"> 
                <img class="imagen" src=<?php $http='https://www.auto-data.net/'; $testRuta = strpos($coche['rutaFoto'],$http);   if($testRuta===0){echo $coche['rutaFoto'];}else{echo base_url().''.$coche['rutaFoto'];} ?>>
                    <div class="contenedorCarInfo">
                        <div class="coche">
                        <?php echo "<u>Marca:</u> ".$coche['brand']."<br>"."<u>Modelo:</u> ".$coche['model']."<br>"."<u>Version:</u> ".$coche['version']; ?> 
                        </div>
                        <div class="divBtn">
                                <button id="infoBtn" class="button col-md-12 col-lg-6" onclick=abrirModalInfo(<?php echo $coche['id_car']?>) data-bs-toggle="modal" data-bs-target="#modalInfo">+info</button>
                                <button id="agregarListaBtn" class="button col-md-12 col-lg-6" data-bs-toggle="modal" data-bs-target="#agregarCocheLista" onclick="cambiarOnclickModalListas(<?php echo $coche['id_car']; ?>)">Agregar a mi lista</button>
                        </div>
                    </div>
            </div>                       
<?php
    }
?>
        