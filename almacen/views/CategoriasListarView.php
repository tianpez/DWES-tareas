<!-- Vista para listar los registros de un determinado modelo -->

<!-- Incluimos la cabecera -->
<?php include_once("common/cabecera.php"); 
include_once("common/autenticacion.php");?>
<body>
    <!-- Incluimos el menú --> 
    <?php include_once("common/menu.php"); ?>

    <table>
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
        
            

        </tr>
        <?php
        foreach ($itemsCategoria as $itemCategoria) {
            ?>
            <tr>
                <td>
                    <?php echo $itemCategoria->getCatId() ?>
                </td>
                <td>
                    <?php echo $itemCategoria->getCatNombre() ?>
                </td>
            

                <td>
                    <a href="index.php?controlador=Categorias&accion=editar&cat_id=<?php echo $itemCategoria->getCatId() ?>">Editar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Categorias&accion=borrar&cat_id=<?php echo $itemCategoria->getCatId() ?>">Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="index.php?controlador=Categorias&accion=nuevo">Nuevo</a>

    <!-- Incluimos el pie de página -->
    <?php include_once("common/pie.php"); ?>
</body>

</html>