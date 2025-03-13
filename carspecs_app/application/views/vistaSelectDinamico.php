<?php
foreach($opcionesModelo as $modelo)
{
    if($modelo['id_brand']==$id_brand)
    {
    ?>
<option value=<?php echo $modelo['id_model'] ?>><?php echo $modelo['model'] ?></option>
    <?php
    }
}
?>