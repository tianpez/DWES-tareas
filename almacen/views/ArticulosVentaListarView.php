<!-- Vista para listar los registros de un determinado modelo -->

<!-- Incluimos la cabecera -->
<?php include_once("common/cabecera.php"); 
include_once("common/autenticacion.php");

?>
<body>
    <!-- Incluimos el menú --> 
    <?php include_once("common/menu.php"); ?>

    <table>
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Categoria</th>
            <!-- <th>Cantidad</th> -->
            <th>Precio Unidad</th>

            <!-- opcional añadir numero de la venta <th>Venta id</th>  !! -->

        </tr>


        <?php
        foreach ($items as $item) {


            ?>

            <form type="index.php?controlador=venta&accion=editar&ven_id=$_REQUEST[ven_id]" method="post">

            <tr>
                <td name="lin_id">
                    <?php echo $item->getArtId() ?>
                    </td>
                <td name = "lin_nombre">
                    <?php echo $item->getArtNombre() ?>
                    </td>
                <td>
                    <?php echo $item->getArtCategoria() ?>
                    </td>
                <!-- <td>
                    <input type = "number" name="lin_cantidad" value="1" min ="1" max= "<?php echo $item->getMaxStock($item->getArtId()) ?>"/>
    
                    </td> -->
                <td name="lin_precio">
                    <?php echo $item->getArtPrecioUnitario() ?>    
                    </td>

                <td>
                    <a href="index.php?controlador=venta&accion=addArticulo&ven_id=<?php echo $_REQUEST['ven_id']?>&art_id=<?php echo $item->getArtId() ?>&cantidad=1">Añadir</a>

                    </tr>
                <?php
            }

           
            ?>
             </form>
    </table>


<h1>Articulos en la linea de venta <?php echo $_REQUEST['ven_id']?></h1>

    <table class="table-pedidos">
        <tr>
            <th>Linea-Id</th>
            <!-- <th>Linea-Venta</th> -->
            <th>Linea-Articulo</th>
            <th>Linea-Cantidad</th>
        
        
            

        </tr>
        <?php
   
        foreach ($pedidos as $pedido) {
            ?>
            <tr>
                <td>
                    <?php echo $pedido->getLinId() ?>
                </td>
               <!-- <td>
                    <?php echo $pedido->getLinVenta() ?>
                </td> -->
                <td>
                    <?php echo $pedido->getLinArticulo() ?>
                </td>
                <td>
                    <?php echo $pedido->getLinCantidad() ?>
                </td>

                <!-- <td>
                <a href="index.php?controlador=lineaventa&accion=borrar&lin_id=<?php echo $pedido->getLinId()?>">Eliminar</a>

                </td> -->
             
            </tr>
  
          
            <?php
        }

        
        ?>
    </table>

    
    <a href="index.php?controlador=venta&accion=finVenta&ven_id=<?php echo $_REQUEST['ven_id']?>">Finalizar Venta</a><br/>

  

    <!-- Incluimos el pie de página -->
    <?php include_once("common/pie.php"); ?>
</body>

</html>



