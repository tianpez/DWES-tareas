<!-- Incluimos la cabecera -->
<?php 
include_once("common/cabecera.php");

require 'models/UsuarioModel.php';

include_once("common/autenticacion.php");?>

<!-- Vista para editar un elemento de la tabla -->

<body>
	<!-- Incluimos un menú para la aplicación -->
	<?php include_once("common/menu.php"); ?>

	<!-- Parte específica de nuestra vista -->
	<form action="index.php" method="post" class="form-login">
		<input type="hidden" name="controlador" value="Articulos">
		<input type="hidden" name="accion" value="editar">

		<label for="codigo">Codigo</label>
		<input type="text" name="art_id" value ="<?php echo $item->getArtId(); ?>" readonly >
		</br>

		<?php echo isset($errores["art_nombre"]) ? "*" : "" ?>
		<label for="nombre">Nombre</label>
		<input type="text" name="art_nombre" value="<?php echo $item->getArtNombre(); ?>">

		<label for="categoria">Categoria</label>
		<select name="art_categoria">
	

			<option selected value="">-- Seleccione --</option>

				<?php foreach ($categorias as $categoria) { ?>
					<option value="<?php echo $categoria->getCatId(); ?>"><?php echo $categoria->getCatNombre(); ?></option>
			<?php } ?>


	
			
		</select>


		<label for="cantidad">Cantidad</label>
		<input type="number" name="art_cantidad" value="" placeholder=" <?php echo $item->getArtCantidad();?>"> 

		<label for="precioUnitario">Precio Unitario</label>
		<input type="number" name="art_preciounitario"  min=0 max=99999999999 step=".01" value="" placeholder="<?php echo $item->getArtPrecioUnitario();?>">



		</br>

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