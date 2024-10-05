<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'bdalan';
$username = 'root'; // Cambia esto por tu usuario de MySQL
$password = ''; // Cambia esto por tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Guardar la persona
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ci = $_POST['ci'];
        $nombre = $_POST['nombre'];
        $paterno = $_POST['paterno'];
        $zona = $_POST['zona']; // Zona seleccionada

        // Primero insertamos la persona
        $sql = "INSERT INTO Persona (ci, nombre, paterno) VALUES (:ci, :nombre, :paterno)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ci', $ci);
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':paterno', $paterno);
        $stmt->execute();

        // Obtener el ID de la persona recién insertada
        $personaId = $pdo->lastInsertId();

        // Luego insertamos en la tabla Catastro (puedes adaptar esto según tu lógica)
        $sqlCatastro = "UPDATE Catastro SET ci = :ci WHERE zona = :zona";
        $stmtCatastro = $pdo->prepare($sqlCatastro);
        $stmtCatastro->bindValue(':ci', $ci);
        $stmtCatastro->bindValue(':zona', $zona);
        $stmtCatastro->execute();

        echo "Persona registrada con éxito.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
