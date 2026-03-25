<?php
session_start();
// 1. Zorg ervoor dat alleen admins toegang hebben tot deze pagina.
// Als er geen sessie is of de rol is niet 'admin', wordt de gebruiker omgeleid.
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: voorpagina.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
  // Verbinding maken met de database.
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Foutmeldingen inschakelen voor PDO.
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  // Foutmelding tonen als de verbinding mislukt.
  echo "Verbinding mislukt: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>NetNix Admin Dashboard</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
</head>

<body>

    <header>
        <div class="topnav">
            <img src="images/logo2.png" alt="NetNix Logo" class="logo-img">
            <a href="voorpagina.php">Home</a>
            <a href="adminpagina.php">Admin</a>
            <a href="index.php">Logout</a>
        </div>
    </header>

    <!-- Een checkbox die fungeert als 'toggle' voor de modal-vensters zonder JavaScript te gebruiken voor het openen -->
    <input type="checkbox" id="modal-toggle">

    <main>
        <h2>Admin Dashboard</h2>

        <ul class="movie-list">
            <li class="movie-manage-item">
                <label for="modal-toggle" class="open-modal-label">
                    <img src="images/upload.png" alt="Add movies" class="admin-card-icon">
                    <div class="movie-info">
                        <span class="name">Add Movies</span>
                    </div>
                </label>
            </li>
            <li>
                <a href="update.php">
                    <img src="images/upload.png" alt="Dashboard Item 2" class="admin-card-icon">
                    <div class="movie-info">
                        <span class="name">Manage Movies</span>
                    </div>
                </a>
            </li>

        </ul>
    </main>

    <div class="modal-overlay">
    <!-- De inhoud van het upload-venster (modal) -->
<div class="modal-content">
    <!-- Knop om de modal te sluiten (gekoppeld aan de checkbox hierboven) -->
    <label for="modal-toggle" class="close-btn">&times;</label>
    <h3>Upload Nieuwe Film</h3>

    <!-- Formulier voor het uploaden van bestanden. 'enctype' is nodig voor bestandsuploads -->
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label class="form-label">Selecteer Filmbestand (.mp4, .mov):</label>
        <input type="file" name="movie_file" accept="video/mp4, video/mov" required class="modal-input">

        <label class="form-label">Selecteer Thumbnail (.jpg, .png):</label>
        <input type="file" name="thumbnail_file" accept=".jpg, .jpeg, .png" required class="modal-input">

        <label class="form-label">Naam:</label>
        <input type="text" name="movie_name" placeholder="Voer titel in..." required>

        <label class="form-label">Beschrijving:</label>
        <textarea name="movie_desc" rows="4" placeholder="Voer beschrijving in..."></textarea>

        <button type="submit" class="save-btn">Film Opslaan</button><br>
    </form>
</div>
    </div>

    <footer>
        <p>&copy; 2026 NetNix</p>
    </footer>

</body>

</html>