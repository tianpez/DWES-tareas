<?php
// En primer lugar recuperamos la información de la sesión
session_start();

// Si el usuario no se ha autenticado lo redirigimos a la pantalla de login
if (!isset($_SESSION['usuario_login'])&& !isset($_SESSION['usuario_pass'])) {
   header("Location:index.php?controlador=usuario&accion=login");
}