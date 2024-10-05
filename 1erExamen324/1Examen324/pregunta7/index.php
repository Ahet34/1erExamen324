<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'bdalan';
$username = 'root'; // Cambia esto por tu usuario de MySQL
$password = ''; // Cambia esto por tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Obtener distritos únicos
    $sql = "SELECT DISTINCT distrito FROM Catastro";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $distritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Persona</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#distrito').change(function() {
                var distrito = $(this).val();
                $.ajax({
                    url: 'obtener_zonas.php',
                    method: 'POST',
                    data: {distrito: distrito},
                    success: function(response) {
                        $('#zona').html(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Registro de Persona</h2>
        <form action="guardar_personas.php" method="POST">
            <div class="form-group">
                <label for="ci">CI:</label>
                <input type="number" class="form-control" id="ci" name="ci" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="paterno">Paterno:</label>
                <input type="text" class="form-control" id="paterno" name="paterno" required>
            </div>
            <div class="form-group">
                <label for="distrito">Distrito:</label>
                <select class="form-control" id="distrito" name="distrito" required>
                    <option value="">Seleccione un distrito</option>
                    <?php foreach ($distritos as $distrito): ?>
                        <option value="<?php echo htmlspecialchars($distrito['distrito']); ?>"><?php echo htmlspecialchars($distrito['distrito']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="zona">Zona:</label>
                <select class="form-control" id="zona" name="zona" required>
                    <option value="">Seleccione una zona</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Persona</button>
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
