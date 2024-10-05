<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: propiedades.php");
    exit;
}

// Manejo del inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // En un caso real, verifica el usuario y la contraseña
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Para este ejemplo, consideraremos un usuario fijo
    if ($usuario === 'funcionario' && $contrasena === 'contrasena') {
        $_SESSION['loggedin'] = true;
        header("Location: propiedades.php");
        exit;
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - ABC de Propiedades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Inicio de Sesión</h2>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
