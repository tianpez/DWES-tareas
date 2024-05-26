<!-- Incluimos la cabecera -->
<?php include_once("common/cabecera.php"); 


?>

<!-- Vista para editar un elemento de la tabla -->

<body>

<h1>Gestión de Almacen 2.0</h1>
	<!-- Incluimos un menú para la aplicación -->


	<!-- Parte específica de nuestra vista -->
	<form action="index.php" method="post" class=form-login>
		<input type="hidden" name="controlador" value="Usuario">
		<input type="hidden" name="accion" value="login">

		<label for="usuario">Usuario</label>
		<input type="text" name="usu_login">
		</br>

	
		<label for="password">Password</label>
		<input type="password" name="usu_pass">


		</br>

		<input type="submit" name="submit" value="ENTRAR">
	</form>
	</br>
	<div id =msj-error>
	<?php
	// Si hay errores los mostramos.
	if (isset($errores)):
		foreach ($errores as $key => $error):
			echo $error . "</br>";
		endforeach;
	endif;
	?>
	</div>

	<!-- Incluimos el pie de la página -->
	<?php include_once("common/pie.php")?>

	
	
</body>

</html>