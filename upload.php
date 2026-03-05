<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

$target_dir = "uploads/";
$image_dir = "images/";

// Zorg dat de map bestaat
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $movie_name = $_POST['movie_name'];
        $movie_desc = $_POST['movie_desc'];

        $thumbnail_name = time() . "_" . basename($_FILES["thumbnail_file"]["name"]);
        $thumbnail_destination = $image_dir . $thumbnail_name;

        move_uploaded_file($_FILES["thumbnail_file"]["tmp_name"], $thumbnail_destination);
        
        // 1. Maak de unieke bestandsnaam aan (ZONDER de mapnaam)
        $clean_file_name = time() . "_" . basename($_FILES["movie_file"]["name"]);
        
        // 2. Het volledige pad waar PHP het bestand naartoe moet schrijven
        $upload_destination = $target_dir . $clean_file_name;
        
        // 3. Verplaats het bestand fysiek naar /uploads
        if (move_uploaded_file($_FILES["movie_file"]["tmp_name"], $upload_destination)) {
            
            // 4. Sla ALLEEN de schone bestandsnaam op in de database
            $sql = "INSERT INTO Video (name, beschrijving, video, thumbnail) VALUES (:name, :desc, :video_name, :thumb)";
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':name', $movie_name);
            $stmt->bindParam(':desc', $movie_desc);
            $stmt->bindParam(':video_name', $clean_file_name); // Hier staat GEEN 'uploads/' meer voor
            $stmt->bindParam(':thumb', $thumbnail_name);

            $stmt->execute();
            
            echo "<h3>Gelukt!</h3> De film staat in de database als: <code>$clean_file_name</code>";
        } else {
            echo "Fout: Bestand verplaatsen mislukt.";
        }
    }
    header("Location: index.php"); exit();
} catch(PDOException $e) {
    echo "Fout: " . $e->getMessage();
}

$conn = null;
?>