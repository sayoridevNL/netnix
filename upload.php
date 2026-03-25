<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

// Definieer de twee verschillende mappen
$video_dir = "uploads/";
$thumb_dir = "thumbnails/";

// Automatisch de mappen aanmaken als ze nog niet bestaan (0777 geeft volledige rechten)
if (!is_dir($video_dir)) mkdir($video_dir, 0777, true);
if (!is_dir($thumb_dir)) mkdir($thumb_dir, 0777, true);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $movie_name = $_POST['movie_name'];
        $movie_desc = $_POST['movie_desc'];

        // 1. Unieke bestandsnaam maken voor de video om overschrijven te voorkomen
        $video_filename = time() . "_" . basename($_FILES["movie_file"]["name"]);
        $video_target = $video_dir . $video_filename;

        // 2. Unieke bestandsnaam maken voor de thumbnail
        $thumb_filename = time() . "_" . basename($_FILES["thumbnail_file"]["name"]);
        $thumb_target = $thumb_dir . $thumb_filename;

        // 3. De tijdelijk geüploade bestanden verplaatsen naar de definitieve mappen
        $video_success = move_uploaded_file($_FILES["movie_file"]["tmp_name"], $video_target);
        $thumb_success = move_uploaded_file($_FILES["thumbnail_file"]["tmp_name"], $thumb_target);

        if ($video_success && $thumb_success) {
            // 4. Sla de gegevens op in de database met PDO 'prepared statements' tegen SQL-injection
            $sql = "INSERT INTO Video (name, beschrijving, video, thumbnail, uploaded_at) 
                    VALUES (:name, :desc, :video, :thumb, CURDATE())";
            
            $stmt = $conn->prepare($sql);
            
            // Koppel de parameters aan de waarden
            $stmt->execute([
                ':name'  => $movie_name,
                ':desc'  => $movie_desc,
                ':video' => $video_filename,
                ':thumb' => $thumb_filename
            ]);

            // Stuur de gebruiker terug naar de voorpagina met een succesmelding
            header("Location: voorpagina.php?upload=success");
            exit();
        } else {
            echo "Fout bij het uploaden van de bestanden.";
        }
    }
} catch(PDOException $e) {
    echo "Fout: " . $e->getMessage();
}
$conn = null;
?>