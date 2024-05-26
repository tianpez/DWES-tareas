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
	<!-- Formulario para insertar un nuevo item -->
	<form action="index.php" method="post" class="form-login">
		<input type="hidden" name="controlador" value="Categorias">
		<input type="hidden" name="accion" value="nuevo">

	
		<label for="cat_nombre">Nombre</label>
		<input type="text" name="cat_nombre" maxlength ="50">
		

		<input type="submit" name="submit" value="Aceptar">
	</form>
	</br>



	<!-- Incluimos el pie de la página -->
	<?php include_once("common/pie.php"); ?>
</body>

</html>