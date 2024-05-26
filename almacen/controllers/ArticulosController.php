<?php
// Controlador para el modelo ItemModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class ArticulosController
{
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }

    // Método del controlador para listar los items almacenados
    public function listar()
    {
        //Incluye el modelo que corresponde
        require 'models/ArticulosModel.php';


        //Creamos una instancia de nuestro "modelo"
        $items = new ArticulosModel();

        //Le pedimos al modelo todos los items
        $listado = $items->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['items'] = $listado;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("ArticulosListarView.php", $data);
    }

    // Método del controlador para crear un nuevo item
    public function nuevo()
    {
        require 'models/ArticulosModel.php';
        $item = new ArticulosModel();

        $errores = array();

        // Si recibe por GET o POST el objeto y lo guarda en la BG
        if (isset($_REQUEST['submit'])) {
            // Comprobamos si se ha recibido los campos obligatorios
            if (!isset($_REQUEST['art_nombre']) || empty($_REQUEST['art_nombre']))
                $errores['art_nombre'] = "* Nombre: debes indicar un nombre.";
            if (!isset($_REQUEST['art_cantidad']) || empty($_REQUEST['art_cantidad']))
                $errores['art_cantidad'] = "* Cantidad: debes indicar una cantidad.";
            if (!isset($_REQUEST['art_preciounitario']) || empty($_REQUEST['art_preciounitario']))
                $errores['art_preciounitario'] = "* Precio unitario: debes indicar un precio unitario.";
            if (!isset($_REQUEST['art_categoria']) || empty($_REQUEST['art_categoria']))
                $errores['art_categoria'] = "* Categoria: debes indicar una categoria.";


            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                $item->setArtNombre($_REQUEST['art_nombre']);
                $item->setArtCategoria($_REQUEST['art_categoria']);
                $item->setArtCantidad($_REQUEST['art_cantidad']);
                $item->setArtPrecioUnitario($_REQUEST['art_preciounitario']);

                $item->save();

                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Articulos&accion=listar");
            }
        }

        // Si no recibe el item para añadir, devuelve la vista para añadir un nuevo item
        $this->view->show("ArticulosNuevoView.php", array('errores' => $errores));
    }

    // Método que procesa la petición para editar un item
    public function editar()
    {


        require 'models/CategoriasModel.php';

        require 'models/ArticulosModel.php';
        $items = new ArticulosModel();


        $categoriaModel = new CategoriasModel;

        $categorias = $categoriaModel->getAll();

        $data['categorias'] = $categorias;
        $data['item'] = $items->getById($_REQUEST['art_id']);




        // Recuperar el item con el código recibido
        $item = $items->getById($_REQUEST['art_id']);

        if ($item == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        }

        $errores = array();

        if (isset($_REQUEST['submit'])) {
            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['art_nombre']) || empty($_REQUEST['art_nombre']))
                $errores['art_nombre'] = "* Nombre: debes indicar un nombre.";
            if (!isset($_REQUEST['art_cantidad']) || empty($_REQUEST['art_cantidad']))
                $errores['art_cantidad'] = "* Cantidad: debes indicar una cantidad.";
            if (!isset($_REQUEST['art_preciounitario']) || empty($_REQUEST['art_preciounitario']))
                $errores['art_preciounitario'] = "* Precio unitario: debes indicar un precio unitario.";
            if (!isset($_REQUEST['art_categoria']) || empty($_REQUEST['art_categoria']))
                $errores['art_categoria'] = "* Categoria: debes indicar una categoria.";


            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                $item->setArtNombre($_REQUEST['art_nombre']);
                $item->setArtCategoria($_REQUEST['art_categoria']);
                $item->setArtCantidad($_REQUEST['art_cantidad']);
                $item->setArtPrecioUnitario($_REQUEST['art_preciounitario']);
                $item->setArtId($_REQUEST['art_id']);

                $item->save();

                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Articulos&accion=listar");
            }
        }

        // Si no se ha pulsado el botón de actualizar se carga la vista para editar el item
        $this->view->show("ArticulosEditarView.php", $data);
    }

    // Método para borrar un item 
    public function borrar()
    {
        //Incluye el modelo que corresponde
        require_once 'models/ArticulosModel.php';

        //Creamos una instancia de nuestro "modelo"
        $items = new ArticulosModel();

        // Recupera el item con el código recibido por GET o por POST
        $item = $items->getById($_REQUEST['art_id']);

        if ($item == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        } else {
            // Si existe lo elimina de la base de datos y vuelve al inicio de la aplicación
            $item->delete();
            header("Location: index.php?controlador=Articulos&accion=listar");
        }
    }



    //Metodo para obtener el stock maximo de un articulo

}
