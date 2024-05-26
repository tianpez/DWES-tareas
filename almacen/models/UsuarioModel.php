<?php

// Clase del modelo para trabajar con objetos Item que se almacenan en BD en la tabla ITEMS
class UsuarioModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $usu_login;
    private $usu_pass;
    private $usu_name;
    private $usu_active;


    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }


    // Getters
    public function getUsuLogin()
    {
        return $this->usu_login;
    }

    public function getUsuPass()
    {
        return $this->usu_pass;
    }

    public function getUsuName()
    {
        return $this->usu_name;
    }

    public function getUsuActive()
    {
        return $this->usu_active;
    }


    // Setters
    public function setUsuLogin($usu_login)
    {
        $this->usu_login = $usu_login;
    }

    public function setUsuPass($usu_pass)
    {
        $this->usu_pass = $usu_pass;
    }


    public function setUsuName($usu_name)
    {
        $this->usu_name = $usu_name;
    }

    public function setUsuActive($usu_active)
    {
        $this->usu_active = $usu_active;
    }

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD


    // Método para obtener todos los registros de la tabla ITEMS
    // Devuelve un array de objetos de la clase ItemModel
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM usuarios');
        $consulta->execute();
        
        // OJO!! El fetchAll() funcionará correctamente siempre que el nombre
        // de los atributos de la clase coincida con los campos de la tabla
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "UsuarioModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto ItemModel con un código determinado
    public function getById($usu_login)
    {
        $consulta = $this->db->prepare('SELECT * FROM usuarios WHERE usu_login = ?');
        $consulta->bindParam(1, $usu_login);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
        $resultado = $consulta->fetch();

        return $resultado;
    }

    // Método que devuelve (si existe en BD) un objeto UsuarioModel con un login determinado
    public function getByLogin($usu_login)
    {
        $consulta = $this->db->prepare('SELECT * FROM usuarios WHERE usu_login = ?');
        $consulta->bindParam(1, $usu_login);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
        $resultado = $consulta->fetch();

        return $resultado;
    }

    // Método para autenticar a un usuario
    public function autenticar($usu_login,$usu_pass): bool
    {
        $consulta = $this->db->prepare('SELECT * FROM usuarios WHERE usu_login = ? AND usu_pass=?');
        $consulta->bindParam(1, $usu_login);
        $password_encrypt = sha1($usu_pass);
        $consulta->bindParam(2, $password_encrypt);
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
        $resultado = $consulta->fetch();

        if (!$resultado) {
            return false;
        } else {
            return true;
        }
    }

    // Método que almacena en BD un objeto ItemModel
    // Si tiene ya código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->usu_login)) {
            $consulta = $this->db->prepare('INSERT INTO usuarios (usu_login,usu_pass) VALUES (?,?)');
            $consulta->bindParam(1, $this->usu_login);
            $consulta->bindParam(2, $this->usu_pass);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE usuarios SET usu_login=?,usu_pass=? WHERE usu_login=?');
            $consulta->bindParam(1, $this->usu_login);
            $consulta->bindParam(2, $this->usu_pass);
            $consulta->bindParam(3, $this->codigo);
            $consulta->execute();
        }
    }

    // Método que elimina el ItemModel de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM usuarios WHERE usu_login=?');
        $consulta->bindParam(1, $this->usu_login);
        $consulta->execute();
    }
}
?>