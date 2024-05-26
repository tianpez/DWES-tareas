<!-- Vista para listar los registros de un determinado modelo -->

<!-- Incluimos la cabecera -->
<?php 
include_once("common/cabecera.php");

?>
<body>
    <!-- Incluimos el menú --> 
    <?php include_once("common/menu.php"); ?>

    <table class="table-pedidos">
        <tr>
            <th>Linea-Id</th>
            <th>Linea-Venta</th>
            <th>Linea-Articulo</th>
            <th>Linea-Venta</th>
        
            

        </tr>
        <?php
        foreach ($pedido as $item) {
            ?>
            <tr>
                <td>
                    <?php echo $item->getLinId() ?>
                </td>
               <td>
                    <?php echo $item->getLinVenta() ?>
                </td>
                <td>
                    <?php echo $item->getLinArticulo() ?>
                </td>
                <td>
                    <?php echo $item->getLinCantidad() ?>
                </td>
            </tr>
            <?php
        }
     

        ?>
    </table>
    <!-- <a href="index.php?controlador=Categorias&accion=nuevo">Nuevo</a> -->

    <!-- Incluimos el pie de página -->
    <?php include_once("common/pie.php"); ?>
</body>

</html>