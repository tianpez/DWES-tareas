<!-- Incluimos la cabecera -->
<?php include_once("common/cabecera.php"); 


require 'models/LineaVentaModel.php';

?>



<body>
	
	<?php include_once("common/menu.php"); ?>


	<form action="index.php" method="post" class="form-login">
		<input type="hidden" name="controlador" value="LineaVenta">
		<input type="hidden" name="accion" value="nuevo">
		

		<?php echo isset($errores["art_nombre"]) ? "*" : "" ?>
		
		
		<label for="nombre">Nombre</label>
		<input type="text" name="art_nombre" maxlength ="50">
	
		<label for="cantidad">Cantidad</label>
		<input type="number" name="art_cantidad">
		<label for="precioUnitario">Precio Unitario</label>
		<input type="number" name="art_preciounitario" min=0 max=99999999999 step=".01">
		</br>

		<input type="submit" name="submit" value="Aceptar">
	</form>
	</br>

	<?php
	// Si hay errores se muestran
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
