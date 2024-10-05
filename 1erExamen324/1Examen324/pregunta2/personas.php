<?php
session_start();

// Verificar si el usuario ha iniciado sesión
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

// Obtener el ID de la propiedad
$id = $_GET['id'] ?? 0;

// Manejo del formulario para agregar o actualizar persona
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $ci = $_POST['ci'];
            $nombre = $_POST['nombre'];
            $paterno = $_POST['paterno'];

            // Verificar si el ci en Catastro es NULL
            $catastroCheck = $conn->query("SELECT ci FROM Catastro WHERE id='$id' AND ci IS NULL");
            if ($catastroCheck->num_rows > 0) {
                // Si ci es NULL, añadir persona
                $sql = "INSERT INTO Persona (ci, nombre, paterno) VALUES ('$ci', '$nombre', '$paterno')";
                if ($conn->query($sql) === TRUE) {
                    // Actualizar ci en Catastro con el nuevo ci de la persona
                    $conn->query("UPDATE Catastro SET ci='$ci' WHERE id='$id'");
                }
            } else {
                echo "<script>alert('No se puede añadir la persona. El CI en Catastro ya está asociado.');</script>";
            }
        } elseif ($_POST['action'] === 'update') {
            $ci = $_POST['ci'];
            $nombre = $_POST['nombre'];
            $paterno = $_POST['paterno'];
            $sql = "UPDATE Persona SET nombre='$nombre', paterno='$paterno' WHERE ci='$ci'";
            $conn->query($sql);
        }
    }
}

// Manejo de eliminación
if (isset($_GET['delete_ci'])) {
    $ci = $_GET['delete_ci'];
    
    // Primero, poner a NULL el campo ci en la tabla Catastro
    $conn->query("UPDATE Catastro SET ci=NULL WHERE ci='$ci'");
    
    // Luego, eliminar la persona de la tabla Persona
    $conn->query("DELETE FROM Persona WHERE ci='$ci'");
}

// Obtener personas de la propiedad
$personas = $conn->query("SELECT * FROM Persona WHERE ci IN (SELECT ci FROM Catastro WHERE id='$id')");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Personas - Propiedades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestionar Personas</h2>
        <a href="propiedades.php" class="btn btn-secondary mb-3">Volver a Propiedades</a>

        <form method="post" class="mb-3">
            <h5>Añadir Persona</h5>
            <div class="form-group">
                <label for="ci">CI</label>
                <input type="text" class="form-control" id="ci" name="ci" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="paterno">Apellido Paterno</label>
                <input type="text" class="form-control" id="paterno" name="paterno" required>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">Añadir Persona</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>CI</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $personas->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ci']; ?></td>
                        <td><?= $row['nombre']; ?></td>
                        <td><?= $row['paterno']; ?></td>
                        <td>
                            <a href="?delete_ci=<?= $row['ci']; ?>&id=<?= $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta persona?');">Eliminar</a>
                            <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal<?= $row['ci']; ?>">Actualizar</a>

                            <!-- Modal para actualizar persona -->
                            <div class="modal fade" id="updateModal<?= $row['ci']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?= $row['ci']; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel<?= $row['ci']; ?>">Actualizar Persona</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post">
                                                <div class="form-group">
                                                    <label for="ci">CI</label>
                                                    <input type="text" class="form-control" id="ci" name="ci" value="<?= $row['ci']; ?>" readonly required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nombre">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $row['nombre']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="paterno">Apellido Paterno</label>
                                                    <input type="text" class="form-control" id="paterno" name="paterno" value="<?= $row['paterno']; ?>" required>
                                                </div>
                                                <input type="hidden" name="action" value="update">
                                                <button type="submit" class="btn btn-primary">Actualizar Persona</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

