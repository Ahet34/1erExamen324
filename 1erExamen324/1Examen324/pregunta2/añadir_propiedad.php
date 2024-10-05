<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: index.php");
    exit;
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto por tu usuario
$password = ""; // Cambia esto por tu contraseña
$dbname = "bdalan"; // Cambia esto por el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificación de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo del formulario para crear propiedad
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $id = $conn->real_escape_string($_POST['id']);
        $zona = $conn->real_escape_string($_POST['zona']);
        $Xini = $conn->real_escape_string($_POST['Xini']);
        $Yini = $conn->real_escape_string($_POST['Yini']);
        $Xfin = $conn->real_escape_string($_POST['Xfin']);
        $superficie = $conn->real_escape_string($_POST['superficie']);
        $distrito = $conn->real_escape_string($_POST['distrito']);
        
        // Crear nueva propiedad, ci se establece en NULL
        $sql_insert = "INSERT INTO Catastro (id, zona, Xini, Yini, Xfin, superficie, distrito, ci) VALUES ('$id', '$zona', '$Xini', '$Yini', '$Xfin', '$superficie', '$distrito', NULL)";
        
        if ($conn->query($sql_insert) === TRUE) {
            $message = "Propiedad creada exitosamente.";
        } else {
            $message = "Error al crear propiedad: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Propiedad</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Crear Propiedad</h2>
        <a href="propiedades.php" class="btn btn-secondary mb-3">Volver a Propiedades</a>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?= $message; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="id">ID del Catastro</label>
                <input type="number" class="form-control" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="zona">Zona</label>
                <input type="text" class="form-control" id="zona" name="zona" required>
            </div>
            <div class="form-group">
                <label for="Xini">X Inicial</label>
                <input type="text" class="form-control" id="Xini" name="Xini" required>
            </div>
            <div class="form-group">
                <label for="Yini">Y Inicial</label>
                <input type="text" class="form-control" id="Yini" name="Yini" required>
            </div>
            <div class="form-group">
                <label for="Xfin">X Final</label>
                <input type="text" class="form-control" id="Xfin" name="Xfin" required>
            </div>
            <div class="form-group">
                <label for="superficie">Superficie</label>
                <input type="number" class="form-control" id="superficie" name="superficie" required>
            </div>
            <div class="form-group">
                <label for="distrito">Distrito</label>
                <input type="text" class="form-control" id="distrito" name="distrito" required>
            </div>
            <input type="hidden" name="action" value="create">
            <button type="submit" class="btn btn-primary">Crear Propiedad</button>
        </form>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
