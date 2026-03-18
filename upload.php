<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

// Definieer de twee verschillende mappen
$video_dir = "uploads/";
$thumb_dir = "thumbnails/";

// Zorg dat beide mappen bestaan
if (!is_dir($video_dir)) mkdir($video_dir, 0777, true);
if (!is_dir($thumb_dir)) mkdir($thumb_dir, 0777, true);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $movie_name = $_POST['movie_name'];
        $movie_desc = $_POST['movie_desc'];

        // 1. Voorbereiden Video
        $video_filename = time() . "_" . basename($_FILES["movie_file"]["name"]);
        $video_target = $video_dir . $video_filename;

        // 2. Voorbereiden Thumbnail
        $thumb_filename = time() . "_" . basename($_FILES["thumbnail_file"]["name"]);
        $thumb_target = $thumb_dir . $thumb_filename;

        // 3. Bestanden verplaatsen naar hun eigen map
        $video_success = move_uploaded_file($_FILES["movie_file"]["tmp_name"], $video_target);
        $thumb_success = move_uploaded_file($_FILES["thumbnail_file"]["tmp_name"], $thumb_target);

        if ($video_success && $thumb_success) {
            // 4. Sla alleen de bestandsnamen op in de Database
            $sql = "INSERT INTO Video (name, beschrijving, video, thumbnail) VALUES (:name, :desc, :video, :thumb)";
            $stmt = $conn->prepare($sql);
            
            $stmt->execute([
                ':name'  => $movie_name,
                ':desc'  => $movie_desc,
                ':video' => $video_filename,
                ':thumb' => $thumb_filename
            ]);

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