<div style="text-align: center; margin-top: 1%;"><h1>Subscripción Elegida:</h1></div> 
<div class="divPago">

    <input type="hidden" id = "infoSub" value = <?php echo $jsonInfoSub ?>>
    <div style="justify-content: center;">
        <section class="subSection2" >
            <section class="subSection" style="text-align:center;">
                <p><?php echo $aInfoSub['precioSubs'];?>€ |<?php if($aInfoSub['periodoSubs']==365){echo "1 año";}else {echo $aInfoSub['periodoSubs']." dias";}?></p>
            </section>
            <p>Que incluye:</p>
            <p>Agregar listas sin ningun limite</p>
        </section>
    </div>
    <form style="margin-left: 6%;" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST" target="_blank">
        <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1"/>
        <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params;?>"/>
        <input type="hidden" name="Ds_Signature" value="<?php echo $firma; ?>"/>
        <input type="submit" class="button" value="Realizar Pago"/>
    </form>
</div>
