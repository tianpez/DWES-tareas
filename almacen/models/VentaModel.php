<?php

// Clase del modelo para trabajar con objetos Item que se almacenan en BD en la tabla 
class VentaModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla 
    //no ncesarios campos autoincrement
    private $ven_id;
    private $ven_fecha;
    private $ven_importe;
    private $ven_pagada;


    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }






    // Getters
    public function getVenId()
    {
        return $this->ven_id;
    }

    public function getVenFecha()
    {
        return $this->ven_fecha;
    }

    public function getVenImporte()
    {
        return $this->ven_importe;
    }

    public function getVenPagada()
    {
        return $this->ven_pagada;
    }

    // Setters
    public function setVenId($ven_id)
    {
        $this->ven_id = $ven_id;
    }

    public function setVenFecha($ven_fecha)
    {
        $this->ven_fecha = $ven_fecha;
    }

    public function setVenImporte($ven_importe)
    {
        $this->ven_importe = $ven_importe;
    }

    public function setVenPagada($ven_pagada)
    {
        $this->ven_pagada = $ven_pagada;
    }














    // Método para obtener todos los registros de la tabla 
    // Devuelve un array de objetos de la clase LineaVenta
    public function getAll()
    {
        //realizamos la consulta de todos los venta
        $consulta = $this->db->prepare('SELECT * FROM ventas');
        $consulta->execute();

        // OJO!! El fetchAll() funcionará correctamente siempre que el nombre
        // de los atributos de la clase coincida con los campos de la tabla
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "VentaModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto lineaVenta con codigo ven_id determinado
    public function getById($ven_id)
    {
        $consulta = $this->db->prepare('SELECT * FROM ventas WHERE ven_id = ?');
        $consulta->bindParam(1, $ven_id);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "VentaModel");
        $resultado = $consulta->fetch();


        return $resultado;
    }





    public function getByVenta($ven_id)
    {
        $consulta = $this->db->prepare('SELECT * FROM ventas WHERE ven_id = ?');
        $consulta->bindParam(1, $ven_id);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "VentaModel");
        $resultado = $consulta->fetch();

        return $resultado;
    }


    public function getVenImporteTotal($ven_id)
    {
        $consulta = $this->db->prepare('SELECT SUM(lin_cantidad*art_preciounitario) as importeTotal FROM linea_venta JOIN articulos_auto ON linea_venta.lin_articulo=articulos_auto.art_id WHERE lin_venta=?');
        $consulta->bindParam(1, $ven_id);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);

        $resultado = $consulta->fetch();

        return  floatval($resultado['importeTotal']);
    }



    // SELECT lin_articulo, lin_cantidad, art_preciounitario 
    // FROM linea_venta JOIN articulos_auto ON linea_venta.lin_articulo=articulos_auto.art_id
    // where lin_venta=' 	19041228 ';


    // SELECT lin_articulo, lin_cantidad, art_preciounitario  , sum(lin_cantidad*art_preciounitario)  as total_articulo
    // FROM linea_venta JOIN articulos_auto ON linea_venta.lin_articulo=articulos_auto.art_id
    // where lin_venta=' 	19041228 ';




    public function save()
    {

        if (!isset($this->ven_id)) {
            $consulta = $this->db->prepare('INSERT INTO ventas(ven_fecha,ven_importe,ven_pagada) VALUES (?,?,?)');

            $consulta->bindParam(1, $this->ven_fecha);
            $consulta->bindParam(2, $this->ven_importe);
            $consulta->bindParam(3, $this->ven_pagada);
            $consulta->execute();
        }
    }

    // Método que elimina el ItemModel de la BD
    // public function delete()
    // {
    //     $consulta = $this->db->prepare('DELETE FROM ventas WHERE ven_id=?');
    //     $consulta->bindParam(1, $this->ven_id);
    //     $consulta->execute();
    // }


    public function update()
    {
        $consulta = $this->db->prepare('UPDATE ventas SET ven_importe=?,ven_pagada=? WHERE ven_id=?');

        $consulta->bindParam(1, $this->ven_importe);
        $consulta->bindParam(2, $this->ven_pagada);
        $consulta->bindParam(3, $this->ven_id);
        // $consulta->bindParam(4, $this->ven_fecha);
        $consulta->execute();
    }




    public function preSave()
    {
        $consulta = $this->db->prepare('INSERT INTO ventas(ven_id,ven_fecha,ven_importe,ven_pagada) VALUES (?,?,?,?)');
        $consulta->bindParam(1, $this->ven_id);
        $consulta->bindParam(2, $this->ven_fecha);
        $consulta->bindParam(3, $this->ven_importe);
        $consulta->bindParam(4, $this->ven_pagada);
        $consulta->execute();
    }
}
