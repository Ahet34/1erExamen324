<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'bdalan';
$username = 'root'; // Cambia esto por tu usuario de MySQL
$password = ''; // Cambia esto por tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (isset($_POST['distrito'])) {
        $distrito = $_POST['distrito'];

        // Obtener zonas del distrito seleccionado
        $sql = "SELECT zona FROM Catastro WHERE distrito = :distrito";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':distrito', $distrito);
        $stmt->execute();
        $zonas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generar opciones para el combo de zonas
        foreach ($zonas as $zona) {
            echo '<option value="' . htmlspecialchars($zona['zona']) . '">' . htmlspecialchars($zona['zona']) . '</option>';
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
