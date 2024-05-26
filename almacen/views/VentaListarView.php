<!-- Vista para listar los registros de un determinado modelo -->

<!-- Incluimos la cabecera -->


<?php include_once("common/cabecera.php"); 



// echo "<pre>";
// var_dump($data);
// echo "</pre>";
?>
<body>
    <!-- Incluimos el menú --> 
    <?php include_once("common/menu.php"); ?>

    <table>
        <tr>
            <th>ID</th>
            <th>FECHA</th>
            <th>IMPORTE</th>
            <th>ESTADO</th>
           
            

        </tr>
        <?php
        foreach ($venta as $item) {
            ?>
            <tr>
                <td>
                    <?php echo $item->getVenId() ?>
                </td>
                <td>
                    <?php echo $item->getVenFecha() ?>
                </td>
                <td>
                <?php echo $item->getVenImporte().' €' ?>
                    
                </td>
                <td>
                    <?php echo $item->getVenPagada() ?>
                </td>
             
                <td>
                <?php if($item->getVenPagada()!=1): ?>
                    <a href="index.php?controlador=venta&accion=editar&ven_id=<?php echo $item->getVenId() ?>">Detalle</a>
                <?php else: ?>
                    
                    <a hidden href="index.php?controlador=venta&accion=editar&ven_id=<?php echo $item->getVenId() ?>">Detalle</a>
                    <?php endif; ?>
                </td>
                  
              
            

            </tr>
            <?php
        }
        ?>
    </table>
    <a href="index.php?controlador=venta&accion=nueva">Nueva Venta</a><br/>
 

    <!-- Incluimos el pie de página -->
    <?php include_once("common/pie.php"); ?>
</body>

</html>