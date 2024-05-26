<?php

// Clase del modelo para trabajar con objetos Item que se almacenan en BD en la tabla ITEMS
class ArticulosModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS

    private $art_nombre;
    private $art_categoria;
    private $art_cantidad;
    private $art_preciounitario;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters



    // Getter para obtener el valor de art_id
    public function getArtId()
    {
        return $this->art_id;
    }

    // Getter para obtener el valor de art_nombre
    public function getArtNombre()
    {
        return $this->art_nombre;
    }

    // Getter para obtener el valor de art_categoria
    public function getArtCategoria()
    {
        return $this->art_categoria;
    }

    // Getter para obtener el valor de art_cantidad
    public function getArtCantidad()
    {
        return $this->art_cantidad;
    }

    // Getter para obtener el valor de art_preciounitario
    public function getArtPrecioUnitario()
    {
        return $this->art_preciounitario;
    }

    // Setter para asignar el valor de art_id
    public function setArtId($art_id)
    {
        $this->art_id = $art_id;
    }

    // Setter para asignar el valor de art_nombre
    public function setArtNombre($art_nombre)
    {
        $this->art_nombre = $art_nombre;
    }

    // Setter para asignar el valor de art_categoria
    public function setArtCategoria($art_categoria)
    {
        $this->art_categoria = $art_categoria;
    }

    // Setter para asignar el valor de art_cantidad
    public function setArtCantidad($art_cantidad)
    {
        $this->art_cantidad = $art_cantidad;
    }

    // Setter para asignar el valor de art_preciounitario
    public function setArtPrecioUnitario($art_preciounitario)
    {
        $this->art_preciounitario = $art_preciounitario;
    }







    // Método para obtener todos los registros de la tabla ITEMS
    // Devuelve un array de objetos de la clase ItemModel
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM articulos_auto');
        $consulta->execute();

        // OJO!! El fetchAll() funcionará correctamente siempre que el nombre
        // de los atributos de la clase coincida con los campos de la tabla
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "ArticulosModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto ItemModel con un código determinado
    public function getById($art_id)
    {
        $gsent = $this->db->prepare('SELECT * FROM articulos_auto WHERE art_id = ?');
        $gsent->bindParam(1, $art_id);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "ArticulosModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }







    // Método que almacena en BD un objeto ItemModel
    // Si tiene ya código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->art_id)) {
            $consulta = $this->db->prepare('INSERT INTO articulos_auto(art_nombre,art_categoria,art_cantidad,art_preciounitario) VALUES (?,?,?,?)');
            $consulta->bindParam(1, $this->art_nombre);
            $consulta->bindParam(2, $this->art_categoria);
            $consulta->bindParam(3, $this->art_cantidad);
            $consulta->bindParam(4, $this->art_preciounitario);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE articulos_auto SET art_nombre=?, art_categoria=? ,art_cantidad=?, art_preciounitario=? WHERE art_id=?');
            $consulta->bindParam(1, $this->art_nombre);
            $consulta->bindParam(2, $this->art_categoria);
            $consulta->bindParam(3, $this->art_cantidad);
            $consulta->bindParam(4, $this->art_preciounitario);
            $consulta->bindParam(5, $this->art_id);
            $consulta->execute();
        }
    }




    public function update()
    {
        $consulta = $this->db->prepare('UPDATE articulos_auto SET art_cantidad=? WHERE art_id=?');
        $consulta->bindParam(1, $this->art_cantidad);
        $consulta->bindParam(2, $this->art_id);
        $consulta->execute();
    }

    // Método que elimina el ItemModel de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM articulos_auto WHERE art_id=?');
        $consulta->bindParam(1, $this->art_id);
        $consulta->execute();
    }



    public function getMaxStock($art_id)
    {
        $consulta = $this->db->prepare('SELECT MAX(art_cantidad) FROM articulos_auto WHERE art_id = ?');
        $consulta->bindParam(1, $art_id);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['MAX(art_cantidad)'];
    }


    public function getByPrecio($art_id)
    {
        $consulta = $this->db->prepare('SELECT art_preciounitario FROM articulos_auto WHERE art_id = ?');
        $consulta->bindParam(1, $art_id);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "ArticulosModel");
        $resultado = $consulta->fetch();

        return $resultado['art_preciounitario'];
    }
}
