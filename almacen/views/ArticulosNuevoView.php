<!-- Incluimos la cabecera -->
<?php 
include_once("common/cabecera.php");


include_once("common/autenticacion.php");


require 'models/CategoriasModel.php';

$categoriaModel= new CategoriasModel;

$categorias = $categoriaModel->getAll();



// var_dump($categorias);


?>



<body>

	<?php include_once("common/menu.php"); ?>


	<form action="index.php" method="post" class="form-login">
		<input type="hidden" name="controlador" value="Articulos">
		<input type="hidden" name="accion" value="nuevo">
		

		<?php echo isset($errores["art_nombre"]) ? "*" : "" ?>
		
		
		<label for="nombre">Nombre</label>
		<input type="text" name="art_nombre" maxlength ="50">
		<select name="art_categoria">
		<option selected value="">-- Seleccione --</option>

			<?php foreach ($categorias as $categoria) { ?>
				<option value="<?php echo $categoria->getCatId(); ?>"><?php echo $categoria->getCatNombre(); ?></option>
			<?php } ?>


	
			
		</select>
		<label for="cantidad">Cantidad</label>
		<input type="number" name="art_cantidad" class="col-cantidad">
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


<!-- 
<select name="producto[vendedorId]" id="nombre_vendedor">
        <option selected value="">-- Seleccione --</option>
        ////<?php foreach($vendedores as $vendedor) { ?>
           ///// <option <?php echo $producto->vendedorId === $vendedor->id ? 'selected' : '' ?> value="<?php echo s($vendedor->id); ?>"><?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
        /////<?php  } ?>
    </select> -->

</html>


