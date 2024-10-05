<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Si se desea, también se puede destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio
header("Location: index.php");
exit;
?>
