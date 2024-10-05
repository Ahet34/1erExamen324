<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$dbname = "bdalan"; // Cambia por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Iniciar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ci = $_POST['ci'];
    
    // Validar usuario
    $sql = "SELECT * FROM Persona WHERE ci = $ci";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Usuario válido
        $catastroSql = "SELECT * FROM Catastro WHERE ci = $ci";
        $catastroResult = $conn->query($catastroSql);
    } else {
        echo "<script>alert('CI no válido'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Bienvenido</h2>
        <h4 class="text-center">Propiedades de CI: <?php echo $ci; ?></h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Zona</th>
                    <th>Superficie</th>
                    <th>Tipo de Impuesto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($catastroResult->num_rows > 0) {
                    while ($row = $catastroResult->fetch_assoc()) {
                        $codigoCatastral = $row['id'];
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['zona']}</td>
                                <td>{$row['superficie']}</td>
                                <td id='impuesto-{$codigoCatastral}'>Cargando...</td>
                                <td>
                                    <button class='btn btn-info' onclick='obtenerImpuesto($codigoCatastral)'>Ver Tipo de Impuesto</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay propiedades registradas.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function obtenerImpuesto(codigo) {
            fetch(`http://localhost:8080/ControlImpuestosApp/ObtenerImpuesto?codigo=${codigo}`)
                .then(response => response.text())
                .then(data => {
                    // Procesar la respuesta y actualizar la tabla
                    document.getElementById(`impuesto-${codigo}`).innerText = data; // Suponiendo que el servidor devuelve el tipo de impuesto directamente
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
