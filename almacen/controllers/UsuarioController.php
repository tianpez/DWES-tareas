

<?php

class UsuarioController{



    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }


public function login() {
        require 'models/UsuarioModel.php';

        $usuario = new UsuarioModel();

        $errores = array();

        // Si se ha pulsado el botón de entrar
        if (isset($_REQUEST['submit'])) {

            echo '<pre>';
            var_dump($_REQUEST['usu_login']);
            echo '</pre>';

            echo '<pre>';
            var_dump($_SESSION['usuario_login']);
            echo '</pre>';

            if (isset($_REQUEST['usu_login']) && isset($_REQUEST['usu_pass'])) {
                $usuario_existe = $usuario->getByLogin($_REQUEST['usu_login']);

                if ($usuario_existe) {
                    if ($usuario->autenticar($_REQUEST['usu_login'], $_REQUEST['usu_pass'])) {
                        // Si la autenticación es correcta guardamos variable de sesion y  vamos a la pantalla inicial de la app
                        session_start();

                        // 
                        //
                        // Guardamos el login del usuario en la sesión   $_SESSION['usuario_app']
                        $_SESSION['usuario_login'] = $_REQUEST['usu_login'];
                        $_SESSION['usuario_pass'] = $_REQUEST['usu_pass'];

                        header("Location:index.php?controlador=articulos&accion=listar");
                    } else {
                        $errores['login'] = "La contraseña no es la correcta";
                    }
                } else {
                    $errores['login'] = "No existe usuario";
                }
            } else {
                $errores['login'] = "Hay que enviar login y password";
            }
        }
        
        // Si llego hasta aquí es porque no se ha llamado a ninguna vista, por lo que muestro el error
        $this->view->show("UsuariologinView.php", array('errores' => $errores));
    }

    // Método para cerrar sesión
public function logout() {
        // Recuperamos la información de la sesión
        session_start();

        // Y la eliminamos
        session_destroy();
        header("Location: index.php");
    }
}

?>