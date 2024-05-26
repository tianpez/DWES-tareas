<!-- Incluimos la cabecera -->
<?php 

include_once("common/cabecera.php");

include_once("common/autenticacion.php");

?>

<!-- Vista para editar un elemento de la tabla -->

<body>
	<!-- Incluimos un menú para la aplicación -->
	<?php include_once("common/menu.php"); ?>

	<!-- Parte específica de nuestra vista -->
	<form action="index.php" method="post"class ="form-login">
		<input type="hidden" name="controlador" value="Categorias">
		<input type="hidden" name="accion" value="editar">

		<label for="codigo">Codigo</label>
		<input type="text" name="cat_id" value ="<?php echo $itemCategoria->getCatId(); ?>" readonly >
		</br>

		<?php echo isset($errores["cat_nombre"]) ? "*" : "" ?>
		<label for="nombre">Nombre</label>
		<input type="text" name="cat_nombre" value="<?php echo $itemCategoria->getCatNombre(); ?>">



		<input type="submit" name="submit" value="Aceptar">
	</form>
	</br>

	<?php
	// Si hay errores los mostramos.
	if (isset($errores)):
		foreach ($errores as $key => $error):
			echo $error . "</br>";
		endforeach;
	endif;
	?>

	<!-- Incluimos el pie de la página -->
	<?php include_once("common/pie.php"); ?>
</body>

</html>