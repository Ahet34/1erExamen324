<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'bdalan';
$username = 'root'; // Cambia esto por tu usuario de MySQL
$password = ''; // Cambia esto por tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tipoImpuesto = '';
    if (isset($_GET['tipo'])) {
        $tipoImpuesto = $_GET['tipo'];

        // Lógica para obtener las personas según el tipo de impuesto
        $sql = "
        SELECT p.ci, p.nombre, p.paterno, c.id AS codigo_catastro
        FROM Persona p
        JOIN Catastro c ON p.ci = c.ci
        WHERE LEFT(c.id, 1) = :tipo
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':tipo', $tipoImpuesto);
        $stmt->execute();
        $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $personas = [];
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Impuestos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            min-width: 200px;
            background-color: #f8f9fa;
            padding: 15px;
            height: 100vh;
        }
        .content {
            flex: 1;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Control de Impuestos</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="?tipo=1">Alto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?tipo=2">Medio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?tipo=3">Bajo</a>
            </li>
        </ul>
    </div>
    <div class="content">
        <h2>Personas con Impuesto <?php echo ucfirst($tipoImpuesto); ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>CI</th>
                    <th>Nombre</th>
                    <th>Paterno</th>
                    <th>Código de Catastro</th> <!-- Cambiado aquí -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($personas)): ?>
                    <?php foreach ($personas as $persona): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($persona['ci']); ?></td>
                            <td><?php echo htmlspecialchars($persona['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($persona['paterno']); ?></td>
                            <td><?php echo htmlspecialchars($persona['codigo_catastro']); ?></td> <!-- Cambiado aquí -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay personas con este tipo de impuesto.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
