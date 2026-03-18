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

        // 1. Zoek de bestandsnamen van de video én de thumbnail op
        $stmt = $conn->prepare("SELECT video, thumbnail FROM video WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $videoData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($videoData) {
            // --- VIDEO VERWIJDEREN ---
            $videoBestand = $videoData['video'];
            $videoPad = "uploads/" . $videoBestand;
            
            if (!empty($videoBestand) && file_exists($videoPad)) {
                unlink($videoPad);
            }

            // --- THUMBNAIL VERWIJDEREN ---
            $thumbBestand = $videoData['thumbnail'];
            $thumbPad = "thumbnails/" . $thumbBestand; // Verwijst naar jouw nieuwe map
            
            if (!empty($thumbBestand) && file_exists($thumbPad)) {
                unlink($thumbPad);
            }
        }

        // 2. Nu de database-rij verwijderen
        $deleteSql = "DELETE FROM video WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->execute(['id' => $id]);
    }
} catch(PDOException $e) {
    die("Fout bij verwijderen: " . $e->getMessage());
}

// Terug naar het overzicht
header("Location: voorpagina.php");
exit();