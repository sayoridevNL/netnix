<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // 1. Zoek de bestandsnaam op in de database VOORDAT we de rij verwijderen
        $stmt = $conn->prepare("SELECT video FROM video WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $videoData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($videoData) {
            $bestandsnaam = $videoData['video'];
            $pad = "uploads/" . $bestandsnaam; // Dit verwijst naar jouw map 'uploads'

            // 2. Controleer of het bestand echt bestaat en verwijder het dan
            if (file_exists($pad)) {
                unlink($pad); // Dit verwijdert het bestand uit de map 'uploads'
            }
        }

        // 3. Nu de database-rij verwijderen
        $deleteSql = "DELETE FROM video WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->execute(['id' => $id]);
    }
} catch(PDOException $e) {
    die("Fout bij verwijderen: " . $e->getMessage());
}

// Terug naar het overzicht
header("Location: index.php");
exit();
