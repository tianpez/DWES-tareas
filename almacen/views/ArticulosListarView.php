<!-- Vista para listar los registros de un determinado modelo -->

<!-- Incluimos la cabecera -->
<?php include_once("common/cabecera.php"); 


?>

<?php include_once("common/autenticacion.php");?>
<body>
    <!-- Incluimos el menú --> 
    <?php include_once("common/menu.php"); ?>

    <table>
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Cantidad</th>
            <th>Precio Unidad</th>
            

        </tr>
        <?php
        foreach ($items as $item) {
            ?>
            <tr>
                <td>
                    <?php echo $item->getArtId()?>
                </td>
                <td>
                    <?php echo $item->getArtNombre()?>
                </td>
                <td>
                    <?php echo $item->getArtCategoria()?>
                </td>
                <td class="col-cantidad">
                    <?php echo $item->getArtCantidad()?>
                </td>
                <td>
                    <?php echo $item->getArtPrecioUnitario()?>    
                </td>

                <td>
                    <a href="index.php?controlador=Articulos&accion=editar&art_id=<?php echo $item->getArtId() ?>">Editar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Articulos&accion=borrar&art_id=<?php echo $item->getArtId() ?>">Borrar</a>
                </td>

            </tr>
            <?php
        }
        ?>
    </table>
    <a href="index.php?controlador=Articulos&accion=nuevo">Nuevo</a>

    <!-- Incluimos el pie de página -->
    <?php include_once("common/pie.php"); 
    
   
    
    ?>
</body>

</html>