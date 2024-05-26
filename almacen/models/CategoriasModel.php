<?php

// Clase del modelo para trabajar con objetos Item que se almacenan en BD en la tabla 
class CategoriasModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla 
    // private $cat_id;
    private $cat_nombre;


    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters



    // Getter para obtener el valor de cat_id
    public function getCatId()
    {
        return $this->cat_id;
    }

    // Getter para obtener el valor de cat_nombre
    public function getCatNombre()
    {
        return $this->cat_nombre;
    }




    // Setter para asignar el valor de cat_id
    public function setCatId($cat_id)
    {
        $this->cat_id = $cat_id;
    }

    // Setter para asignar el valor de cat_nombre
    public function setCatNombre($cat_nombre)
    {
        $this->cat_nombre = $cat_nombre;
    }

    // Método para obtener todos los registros de la tabla ITEMS
    // Devuelve un array de objetos de la clase ItemModel
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM categorias');
        $consulta->execute();

        // OJO!! El fetchAll() funcionará correctamente siempre que el nombre
        // de los atributos de la clase coincida con los campos de la tabla
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "CategoriasModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto ItemModel con un código determinado
    public function getById($cat_id)
    {
        $gsent = $this->db->prepare('SELECT * FROM categorias WHERE cat_id = ?');
        $gsent->bindParam(1, $cat_id);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "CategoriasModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }


    // Método que almacena en BD un objeto ItemModel
    // Si tiene ya código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->cat_id)) {
            $consulta = $this->db->prepare('INSERT INTO categorias(cat_nombre) VALUES (?)');
            $consulta->bindParam(1, $this->cat_nombre);
            $consulta->bindParam(2, $this->cat_id);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE categorias SET cat_nombre=? WHERE cat_id=?');
            $consulta->bindParam(1, $this->cat_nombre);
            $consulta->bindParam(2, $this->cat_id);


            $consulta->execute();
        }
    }

    // Método que elimina el ItemModel de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM categorias WHERE cat_id=?');
        $consulta->bindParam(1, $this->cat_id);
        $consulta->execute();
    }
}
