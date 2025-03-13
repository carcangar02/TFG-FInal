function crearCoche($marcaCrear,$modeloCrear,$versionCrear,$id_combustibleCrear,$consumoMedioCrear,$potenciaCrear,$torqueCrear,$pesoCrear,$id_etiquetaCrear,$likesCrear,$puntosSeguridadCrear,$comprasCrear,$rutaFotoCrear)
    {
        $query = "UPDATE cars
                SET id_brand = ?, id_model = ?, version = ?, id_combustible = ?, averageConsumption = ?,horsePower = ?, engineTorque = ?, weight = ?, safetyPoints = ?, mostBought = ?, id_etiqueta = ?, rutaFoto = ?, likes = ?
                WHERE id_car = ?;";
        return $this->db->query($query,array($marcaCambio,$modeloCambio,$versionCambio,$id_combustibleCambio,$consumoMedioCambio,$potenciaCambio,$torqueCambio,$pesoCambio,$puntosSeguridadCambio,$comprasCambio,$id_etiquetaCambio,$rutaFotoCambio,$likesCambio,$id_carCambio));
    
    }