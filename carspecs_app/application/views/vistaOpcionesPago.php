<div style="text-align: center; margin-top: 1%;"><h1>Elige tu plan de suscripción</h1></div>
<div class="displayPago">
        <?php   foreach($aDatosSubs as $sub)
        { $subInfo = json_encode($sub);
        ?>
        <form class="opcionesSubs" action="<?php echo base_url()?>PagosController/displayPago" method="POST">
        <button type="submit" id ="<?php echo $sub['precioSubs'];?>"class='button'>
            <section class="subSection">
                <input type="hidden" name = "subInfo" value=<?php echo $subInfo?>>
                <p><?php echo $sub['precioSubs'];?>€</p>
                <p>
                    <?php if($sub['periodoSubs']==365)
                    {
                        echo "1 año";
                    }
                    else 
                    {
                        echo $sub['periodoSubs']." dias";
                    }
                    ?>
                </p>
            </section>
        </button>
        </form>
        <?php
        }
        ?>
    
</div>
