<?php
// Controlador para el modelo ItemModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class VentaController
{
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }

    // Método del controlador para listar las ventas almacenadas
    public function listar()
    {
        //Incluye el modelo que corresponde
        require 'models/VentaModel.php';
        //Incluye el modelo que corresponde

        $venta = new VentaModel();


        $listado = $venta->getAll();



        //Pasamos a la vista toda la información que se desea representar
        $data['venta'] = $listado;

        // $venta->getVenImporte();

        // $importeT = $this->getImporteVentaTotal();





        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("VentaListarView.php", $data);
    }


    public function listarToVenta()
    {
        //Incluye el modelo que corresponde
        require 'models/ArticulosModel.php';
        require 'models/lineaVentaModel.php';
        $pedido = new LineaVentaModel();
        $listPedidos = $pedido->getByVenta($_REQUEST['ven_id']);
        $data['pedidos'] = $listPedidos;

        //Creamos una instancia de nuestro "modelo"
        $items = new ArticulosModel();

        //Le pedimos al modelo todos los items
        $listItems = $items->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['items'] = $listItems;
        $data['pedidos'] = $listPedidos;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("ArticulosVentaListarView.php", $data);
    }

    // public function getImporteVentaTotal()
    // {
    //     require 'models/VentaModel.php';
    //     $venta = new VentaModel();
    //     $importeT = $venta->getVenImporteTotal();
    //     return $importeT;
    // }




    public function nueva()
    {

        require 'models/LineaVentaModel.php';
        require 'models/VentaModel.php';
        $pedido = new LineaVentaModel();
        $venta = new VentaModel();
        $numeroVenta = $this->generarNumero();
        $venta->setVenId($numeroVenta);
        $venta->setVenFecha(date('Y-m-d'));
        $venta->setVenImporte(0);
        $venta->setVenPagada(0);
        // echo "Numero de venta: " . $this->generarNumero();
        $venta->preSave();
        $listado = $venta->getAll();
        //Pasamos a la vista toda la información que se desea representar
        $data['venta'] = $listado;
        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("VentaListarView.php", $data);
    }


    ///Metodo que actualiza o añade un articulo a linea_venta
    public function addArticulo()
    {


        require 'models/LineaVentaModel.php';
        require 'models/VentaModel.php';

        $pedido = new LineaVentaModel();
        $venta = new VentaModel();
        $pedido->setLinArticulo($_REQUEST['art_id']);
        // $pedido->setLinCantidad($_REQUEST['cantidad']);
        //NO Eenviamos la cantidad porque se actualiza en el metodo save o update.
        $pedido->setLinVenta($_REQUEST['ven_id']);

        //Comprobacion de que $_REQUEST['art_id'] , $_REQUEST['ven_id'] , $_REQUEST['cantidad'] NO estan vacios

        if (isset($_REQUEST['art_id']) && isset($_REQUEST['ven_id']) && isset($_REQUEST['cantidad'])) {

            $errores = array();


            $match = $pedido->findDuplicate($_REQUEST['ven_id'], $_REQUEST['art_id']);

            var_dump($match);




            //comprobacion de que el articulo no esta en la linea de venta con el mismo ven_id
            if (!($match)) {

                $pedido->setLinCantidad($_REQUEST['cantidad']);
                $pedido->save();

                echo "NUEVO ARTICULO añadido a la venta con exito!!";
                header('Location: index.php?controlador=venta&accion=editar&ven_id=' . $_REQUEST['ven_id']);
            } else {

                //???Actualizar linea de venta con la cantidad anterior + la nueva cantidad;

                //Obtenemos la cantidad que ya tiene la linea de venta, la sumamos a la nueva cantidad y 
                //actualizamos la linea de venta.
                $pedido->getLinCantByLinId($match);
                var_dump($pedido->getLinCantByLinId($match));
                $total = $pedido->setLinCantidad($pedido->getLinCantByLinId($match) + $_REQUEST['cantidad']);
                var_dump($pedido);

                $pedido->setLinId($match);
                // $venta->setVenId($_REQUEST['ven_id']);
                // $venta->setVenImporte($venta->getVenImporteTotal($_REQUEST['ven_id']));
                // $venta->update();

                $pedido->update();


                // $pedido->update();
                echo "ACTUALIZADO ARTICULO a la venta con exito!!";
                header('Location: index.php?controlador=venta&accion=editar&ven_id=' . $_REQUEST['ven_id']);
            }


            // header("Location: index.php?controlador=venta&accion=editar&ven_id=$_REQUEST[ven_id]");
            // header("Location: index.php?controlador=LineaVenta&accion=listar");
        } else {
            echo "No se ha recibido el item a añadir a la venta!!";
            $this->view->show("ArticulosVentaListarView.php", array('errores' => $errores));
        }

        $venta->setVenImporte($venta->getVenImporteTotal($_REQUEST['ven_id']));
        $venta->setVenPagada(0);
        $venta->setVenId($_REQUEST['ven_id']);
        $venta->update();
    }



    public function generarNumero()
    {
        $fechaHora = date('YdmHis'); // Obtiene la fecha y hora actual en formato AñoMesDiaHoraMinutoSegundo
        $numero = substr($fechaHora, 4, -2); // Extrae los 10 primeros caracteres de la fecha y hora
        return $numero;
    }



    public function editar()
    {


        $this->listarToVenta();
    }


    public function finVenta()
    {
        //Incluye el modelo que corresponde
        require 'models/VentaModel.php';
        require 'models/LineaVentaModel.php';
        require 'models/ArticulosModel.php';

        $pedido = new LineaVentaModel();
        $venta = new VentaModel();
        $articulo = new ArticulosModel();



        $listadoPedido = $pedido->getByVenta($_REQUEST['ven_id']);
        var_dump($listadoPedido);
        // var_dump($pedido);
        foreach ($listadoPedido as $linea) {
            $idArticulo = $articulo->getById($linea->getLinArticulo());
            $idArticulo->setArtCantidad($idArticulo->getArtCantidad() - $linea->getLinCantidad());
           
           
           
        //    echo '<pre>';
        //     var_dump($idArticulo->getArtCantidad());    
        //     echo '</pre>';
        //     var_dump($linea->getLinCantidad());
        //     // var_dump($idArticulo);

            $idArticulo->update();

            // var_dump($articulo);
        }



        $venta = $venta->getById($_REQUEST['ven_id']);
        $importe = $venta->getVenImporteTotal($_REQUEST['ven_id']);
        $venta->setVenPagada(1);
        $venta->setVenImporte($importe);
        $venta->update();
        header("Location: index.php?controlador=venta&accion=listar");
    }



    public function borrar()
    {
        //Incluye el modelo que corresponde
        require 'models/VentaModel.php';

        //Creamos una instancia de nuestro "modelo"
        $venta = new VentaModel();

        // Recupera el item con el código recibido por GET o por POST
        $venta = $venta->getById($_REQUEST['ven_id']);

        if ($venta == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        } else {
            // Si existe lo elimina de la base de datos y vuelve al inicio de la aplicación
            $venta->delete();
            header("Location: index.php?controlador=venta&accion=listar");
        }
    }
}
