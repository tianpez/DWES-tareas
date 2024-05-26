<?php
// Controlador para el modelo ItemModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class LineaVentaController
{
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }



    // Método del controlador para listar los pedido almacenados
    public function listar()
    {


        //Incluye el modelo que corresponde
        require 'models/LineaVentaModel.php';

        //Creamos una instancia de nuestro "modelo"
        $pedido = new LineaVentaModel();

        //Le pedimos al modelo todos los items
        $listado = $pedido->getAll();




        //Pasamos a la vista toda la información que se desea representar
        $data['pedido'] = $listado;


        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("LineaVentaListarView.php", $data);
    }



    public function editar()
    {
    }



    // Método para borrar un item 
    public function borrar()
    {
        require 'models/LineaVentaModel.php';
        $pedido = new LineaVentaModel();
        $pedido->delete($_REQUEST['lin_id']);
        // $this->view->show("LineaVentaListarView.php", $data);
        // $this->view->show("ArticulosVentaListarView.php");
        
    }
}
