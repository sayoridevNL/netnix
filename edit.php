<?php
// 1. Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Process POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['movie_id'] ?? null;
        $name = $_POST['movie_name'] ?? null;
        $desc = $_POST['movie_desc'] ?? null;

        if ($id && $name) {
            $sql = "UPDATE video SET name = :name, beschrijving = :beschrijving WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':beschrijving', $desc);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
} catch(PDOException $e) {
    die("Connection or query failed: " . $e->getMessage());
}

header("Location: voorpagina.php");
exit();
?>
