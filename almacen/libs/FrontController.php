<?php
// Esta clase es el controlador principal de la aplicación web
// Si queremos utilizar alguna acción de un controlador, al final venimos a éste
// ya que siempre se usa index.php y se le pasa el controlador y la acción
class FrontController {
      static function main() {
            //Incluimos algunas clases:
            require 'libs/Config.php'; // de configuracion
            require 'libs/SPDO.php'; // PDO con singleton
            require 'libs/View.php'; // Mini motor de plantillas
            require 'setup.php'; //Archivo con configuraciones.

            // Con el objetivo de no repetir nombre de clases, nuestros controladores
            // terminarán todos en Controller. Por ej, la clase controladora Items, será ItemsController

            // Formamos el nombre del Controlador o en su defecto, asumimos que es el ItemController
            // En nuestra aplicación podemos cambiar el controlador por defecto por el que consideremos
            // por ejemplo "IndexController".
            if (!empty($_REQUEST['controlador']))
                  $controllerName = $_REQUEST['controlador'] . 'Controller';
            else
                  $controllerName = "UsuarioController";

            // Lo mismo sucede con las acciones, si no hay acción, tomamos index como acción por defecto
            if (!empty($_REQUEST['accion']))
                  $actionName = $_REQUEST['accion'];
            else
                  $actionName = "login";

            // Obtenemos la ruta a la carpeta con los controladores de la configuración de la app
            // y generamos la ruta completa al controlador elegido
            $controllerPath = $config->get('controllersFolder') . $controllerName . '.php';

            // Incluimos el fichero que contiene nuestra clase controladora solicitada
            if (is_file($controllerPath))
                  require $controllerPath;
            else
                  die('El controlador no existe - 404 not found');

            //Si todo esta bien, creamos una instancia del controlador y llamamos a la acción
            if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
                  $controller = new $controllerName();
                  $controller->$actionName();
            } else {
                  trigger_error($controllerName . '->' . $actionName . ' no existe', E_USER_NOTICE);
                  return false;
            }
      }


      // public function login() {
      //       require 'models/UsuarioModel.php';
    
      //       $usuario = new UsuarioModel();
    
        
      //       if (isset($_REQUEST['submit'])) {
    
      //           if (isset($_REQUEST['login']) && isset($_REQUEST['password'])) {
      //               $usuario_existe = $usuario->getByLogin($_REQUEST['login']);
    
      //               if ($usuario_existe) {
      //                   if ($usuario->autenticar($_REQUEST['login'], $_REQUEST['password'])) {
      //                       // Si la autenticación es correcta guardamos variable de sesion y  vamos a la pantalla inicial de la app
      //                       session_start();
      //                       $_SESSION['usuario_app'] = $_REQUEST['login'];
      //                       header("Location: index.php");
      //                   } else {
      //                       $errores['login'] = "La contraseña no es la correcta";
      //                   }
      //               } else {
      //                   $errores['login'] = "No existe usuario con este login";
      //               }
      //           } else {
      //               $errores['login'] = "Hay que enviar login y password";
      //           }
      //       }
            
      //       // Si llego hasta aquí es porque no se ha llamado a ninguna vista, por lo que muestro el error
      //       $this->view->show("loginView.php", array('errores' => $errores));
      //   }
    
      //   // Método para cerrar sesión
      //   public function logout() {
      //       // Recuperamos la información de la sesión
      //       session_start();
    
      //       // Y la eliminamos
      //       session_destroy();
      //       header("Location: index.php");
      //   }
    }

?>