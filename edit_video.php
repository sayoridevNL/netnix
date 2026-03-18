<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. HAAL HUIDIGE GEGEVENS OP (nodig om oude bestandsnamen te weten)
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM video WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $videoData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$videoData) { die("Video niet gevonden."); }
    } else {
        header("Location: update.php");
        exit();
    }

    // 2. VERWERK DE UPDATE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_video'])) {
        $name = $_POST['name'];
        $beschrijving = $_POST['beschrijving'];
        
        // Standaard houden we de oude namen uit de database aan
        $video_db_name = $videoData['video'];
        $thumb_db_name = $videoData['thumbnail'];

        // --- VIDEO UPLOAD LOGICA ---
        if (!empty($_FILES["video_file"]["name"])) {
            $video_ext = strtolower(pathinfo($_FILES["video_file"]["name"], PATHINFO_EXTENSION));
            if (in_array($video_ext, ['mp4', 'mov'])) {
                
                // VERWIJDER OUD BESTAND: Check of het oude bestand bestaat en verwijder het
                $oud_video_pad = "uploads/" . $videoData['video'];
                if (file_exists($oud_video_pad) && !empty($videoData['video'])) {
                    unlink($oud_video_pad);
                }

                // VOEG NIEUW BESTAND TOE
                $video_db_name = time() . "_" . basename($_FILES["video_file"]["name"]);
                move_uploaded_file($_FILES["video_file"]["tmp_name"], "uploads/" . $video_db_name);
            }
        }

        // --- THUMBNAIL UPLOAD LOGICA ---
        if (!empty($_FILES["thumb_file"]["name"])) {
            $thumb_ext = strtolower(pathinfo($_FILES["thumb_file"]["name"], PATHINFO_EXTENSION));
            if (in_array($thumb_ext, ['jpg', 'jpeg', 'png'])) {
                
                // VERWIJDER OUD BESTAND: Check of de oude thumbnail bestaat en verwijder het
                $oud_thumb_pad = "thumbnails/" . $videoData['thumbnail'];
                if (file_exists($oud_thumb_pad) && !empty($videoData['thumbnail'])) {
                    unlink($oud_thumb_pad);
                }

                // VOEG NIEUW BESTAND TOE
                $thumb_db_name = time() . "_" . basename($_FILES["thumb_file"]["name"]);
                move_uploaded_file($_FILES["thumb_file"]["tmp_name"], "thumbnails/" . $thumb_db_name);
            }
        }

        // 3. UPDATE DE DATABASE
        $sql = "UPDATE video SET name = :name, video = :video, thumbnail = :thumbnail, beschrijving = :beschrijving WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'name' => $name, 
            'video' => $video_db_name, 
            'thumbnail' => $thumb_db_name,
            'beschrijving' => $beschrijving,
            'id' => $id
        ]);

        header("Location: update.php?status=geupdate");
        exit();
    }
} catch(PDOException $e) { echo "Error: " . $e->getMessage(); }
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>NetNix</title>
    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
</head>
<body>

  <header>
    <div class="topnav">
      <img src="images/logo2.png" alt="NetNix Logo" class="logo-img">
      <a href="index.php">Home</a>
      <a href="update.php">Admin</a>
    </div>
  </header>

  <main>
    <div class="edit-container">
        <h2>Video Aanpassen</h2>
        
        <form action="edit_video.php?id=<?php echo $videoData['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $videoData['id']; ?>">

            <div class="form-group">
                <label>Titel:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($videoData['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Video vervangen (.mp4, .mov):</label>
                <p style="font-size: 0.8em; color: #777;">Huidig: <?php echo $videoData['video']; ?></p>
                <input type="file" name="video_file" accept=".mp4,.mov">
            </div>

            <div class="form-group">
                <label>Thumbnail vervangen (.jpg, .png):</label>
                <p style="font-size: 0.8em; color: #777;">Huidig: <?php echo $videoData['thumbnail']; ?></p>
                <input type="file" name="thumb_file" accept="image/*">
            </div>

            <div class="form-group">
                <label>Beschrijving:</label>
                <textarea name="beschrijving"><?php echo htmlspecialchars($videoData['beschrijving'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="update_video" class="btn-save">Wijzigingen Opslaan</button>
                <a href="update.php" class="btn-cancel">Annuleren</a>
            </div>
        </form>
    </div>
  </main>

  <footer>
    <p>&copy; 2026 NetNix</p>
  </footer>

</body>
</html>
