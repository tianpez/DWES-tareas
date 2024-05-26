<?php
// Controlador para el modelo ItemModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class CategoriasController
{
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }

    // Método del controlador para listar los itemsCategoria almacenados
    public function listar()
    {
        //Incluye el modelo que corresponde
        require 'models/CategoriasModel.php';

        //Creamos una instancia de nuestro "modelo"
        $itemsCategoria = new CategoriasModel();

        //Le pedimos al modelo todos los itemsCategoria
        $listado = $itemsCategoria->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['itemsCategoria'] = $listado;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a pcatir de la plantilla y de los datos
        $this->view->show("CategoriasListarView.php", $data);
    }

    // Método del controlador para crear un nuevo itemCategoria
    public function nuevo()
    {
        require 'models/CategoriasModel.php';
        $itemCategoria = new CategoriasModel();

        $errores = array();

        // Si recibe por GET o POST el objeto y lo guarda en la BG
        if (isset($_REQUEST['submit'])) {
            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['cat_nombre']) || empty($_REQUEST['cat_nombre']))
                $errores['cat_nombre'] = "* Nombre: debes indicar un nombre de categoria.";





            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                $itemCategoria->setCatNombre($_REQUEST['cat_nombre']);


                $itemCategoria->save();

                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Categorias&accion=listar");
            }
        }

        // Si no recibe el itemCategoria para añadir, devuelve la vista para añadir un nuevo itemCategoria
        $this->view->show("CategoriasNuevoView.php", array('errores' => $errores));
    }




    // Método que procesa la petición para editar un itemCategoria
    public function editar()
    {

        require 'models/CategoriasModel.php';
        $items = new CategoriasModel();

        // Recuperar el itemCategoria con el código recibido
        $itemCategoria = $items->getById($_REQUEST['cat_id']);

        if ($itemCategoria == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        }

        $errores = array();

        if (isset($_REQUEST['submit'])) {
            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['cat_nombre']) || empty($_REQUEST['cat_nombre']))
                $errores['cat_nombre'] = "* Nombre: debes indicar un nombre de Categoria.";



            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                $itemCategoria->setCatNombre($_REQUEST['cat_nombre']);
                $itemCategoria->setCatId($_REQUEST['cat_id']);


                $itemCategoria->save();

                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Categorias&accion=listar");
            }
        }

        // var_dump($itemCategoria);

        // Si no se ha pulsado el botón de actualizar se carga la vista para editar el itemCategoria
        $this->view->show("CategoriasEditarView.php", array('itemCategoria' => $itemCategoria, 'errores' => $errores));
    }

    // Método para borrar un itemCategoria 
    public function borrar()
    {
        //Incluye el modelo que corresponde
        require_once 'models/CategoriasModel.php';

        //Creamos una instancia de nuestro "modelo"
        $itemsCategoria = new CategoriasModel();


        // Recupera el categoria con el código recibido por GET o por POST
        $itemCategoria = $itemsCategoria->getById($_REQUEST['cat_id']);



        if ($itemCategoria == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        } else {
            // Si existe lo elimina de la base de datos y vuelve al inicio de la aplicación
            $itemCategoria->delete();
            header("Location: index.php?controlador=Categorias&accion=listar");
        }
    }
}
