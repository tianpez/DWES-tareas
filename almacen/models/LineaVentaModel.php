<?php

// Clase del modelo para trabajar con objetos Item que se almacenan en BD en la tabla
class LineaVentaModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla
    //no ncesarios campos autoincrement
    private $lin_id;
    private $lin_venta;
    private $lin_articulo;
    private $lin_cantidad;


    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    public function getLinId()
    {
        return $this->lin_id;
    }

    public function setLinId($lin_id)
    {
        $this->lin_id = $lin_id;
    }

    public function getLinVenta()
    {
        return $this->lin_venta;
    }

    public function setLinVenta($lin_venta)
    {
        $this->lin_venta = $lin_venta;
    }

    public function getLinArticulo()
    {
        return $this->lin_articulo;
    }

    public function setLinArticulo($lin_articulo)
    {
        $this->lin_articulo = $lin_articulo;
    }

    public function getLinCantidad()
    {
        return $this->lin_cantidad;
    }

    public function setLinCantidad($lin_cantidad)
    {
        $this->lin_cantidad = $lin_cantidad;
    }



    // Método para obtener todos los registros de la tabla
    // Devuelve un array de objetos de la clase LineaVenta
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM linea_venta');
        $consulta->execute();

        // OJO!! El fetchAll() funcionará correctamente siempre que el nombre
        // de los atributos de la clase coincida con los campos de la tabla
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "LineaVentaModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }




    // Método para obtener un registro de la tabla getVentaFiltro($lin_venta)
    // Devuelve un objeto de la clase LineaVenta filtrado con lin_articulo y lin_venta

    //---|lin_articulo|lin_cantidad|
    //---|1            |2           |
    //---|10           |3           |
    //---|15           |4           |

    public function getPriceByLinea()
    {
        $consulta = $this->db->prepare('SELECT art_precio FROM articulos WHERE art_id = ?');
        $consulta->bindParam(1, $this->lin_articulo);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "LineaVentaModel");
        $resultado = $consulta->fetch();
        return $resultado;
    }

    public function getVentaFiltro($lin_venta)
    {
        $consulta = $this->db->prepare('SELECT  lin_articulo, lin_cantidad FROM linea_venta WHERE lin_venta = ?');
        $consulta->bindParam(1, $lin_venta);
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, "LineaVentaModel");
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    public function getLinCantByLinId($lin_id)
    {
        $consulta = $this->db->prepare('SELECT lin_cantidad FROM linea_venta WHERE lin_id = ?');
        $consulta->bindParam(1, $lin_id);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "LineaVentaModel");
        $resultado = $consulta->fetch();
        return intval($resultado->getLinCantidad());

        // return $resultado;
    }




    public function getByVenta($lin_venta)
    {
        $consulta = $this->db->prepare('SELECT * FROM linea_venta WHERE lin_venta = ?');
        $consulta->bindParam(1, $lin_venta);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "LineaVentaModel");
        $resultado = $consulta->fetchAll();

        return $resultado;
    }




    public function update()
    {


        $consulta = $this->db->prepare('UPDATE linea_venta SET lin_cantidad=? WHERE lin_id=?');
        $consulta->bindParam(1, $this->lin_cantidad);
        $consulta->bindParam(2, $this->lin_id);
        $consulta->execute();
    }






    public function save()
    {


        $consulta = $this->db->prepare('INSERT INTO linea_venta(lin_venta,lin_articulo,lin_cantidad) VALUES (?,?,?)');
        $consulta->bindParam(1, $this->lin_venta);
        $consulta->bindParam(2, $this->lin_articulo);
        $consulta->bindParam(3, $this->lin_cantidad);
        // $consulta->bindParam(4, $this->lin_id);
        $consulta->execute();
    }



    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM linea_venta WHERE lin_id=?');
        $consulta->bindParam(1, $this->lin_id);
        $consulta->execute();
    }





    public function findDuplicate($lin_venta, $lin_articulo)
    {
        $consulta = $this->db->prepare('SELECT lin_id FROM linea_venta WHERE lin_venta = ? AND lin_articulo = ?');
        $consulta->bindParam(1, $lin_venta);
        $consulta->bindParam(2, $lin_articulo);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['lin_id'];
        } else {
            return null;
        }
    }
}
