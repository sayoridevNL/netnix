<?php
session_start();
// 1. Controleer of de gebruiker is ingelogd en of deze een 'admin' rol heeft.
// Als de gebruiker geen admin is, wordt deze teruggestuurd naar de index.php.
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}

// 2. Database configuratiegegevens
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
    // Maak een nieuwe databaseverbinding via PDO (PHP Data Objects)
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Stel de foutmodus in op exceptions zodat we fouten makkelijk kunnen opvangen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Als de verbinding mislukt, laat dan de foutmelding zien
    echo "Verbinding mislukt: " . $e->getMessage();
}

// 3. Haal alle gegevens op uit de 'video' tabel
$sql = "SELECT * FROM video";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>NetNix Admin</title>
    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
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

<main>
    <h2>Video Beheer</h2>
    <table class="admintabel">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Video Pad</th>
                <th>Uploaded at</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Loop door alle rijen die uit de database zijn opgehaald
            while($row = $result->fetch(PDO::FETCH_ASSOC)){ ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['video']); ?></td>
                <td><?php echo $row['uploaded_at']; ?></td>
                <td>
                    <!-- Knop om het bewerk-venster (modal) te openen met de gegevens van de huidige video -->
                    <button class="edit-btn" onclick="openEditModal(
                        '<?php echo $row['id']; ?>', 
                        '<?php echo addslashes(htmlspecialchars($row['name'])); ?>', 
                        '<?php echo isset($row['beschrijving']) ? addslashes(htmlspecialchars($row['beschrijving'])) : ''; ?>'
                    )">Bewerken</button>  

                    <!-- Link om een video te verwijderen, vraagt eerst om bevestiging via JavaScript -->
                    <a class="vw-btn" href="delete.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Weet je zeker dat je dit wilt verwijderen?')">
                       Verwijderen
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</main>

<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <h3>Edit Movie Details</h3>

        <form action="edit.php" method="POST">
            <input type="hidden" name="movie_id" id="edit_id">

            <label class="form-label">Naam:</label><br>
            <input type="text" name="movie_name" id="edit_name" style="width:100%; margin-bottom:10px;" required>

            <label class="form-label">Beschrijving:</label><br>
            <textarea name="movie_desc" id="edit_desc" rows="4" style="width:100%; margin-bottom:10px;"></textarea>

            <button type="submit" class="save-btn">Update Gegevens</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2026 NetNix</p>
</footer>

<script>
    // Selecteer het modal-element
    const modal = document.getElementById('editModal');

    /**
     * Functie om het bewerkingsvenster te openen.
     * Vult de invoervelden met de huidige gegevens van de film.
     */
    function openEditModal(id, name, desc) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_desc').value = desc;
        modal.style.display = 'flex'; // Maak de modal zichtbaar
    }

    /**
     * Functie om de modal weer te sluiten.
     */
    function closeEditModal() {
        modal.style.display = 'none'; // Verberg de modal
    }

    // Sluit de modal wanneer er buiten de inhoud van de modal wordt geklikt
    window.onclick = function(event) {
        if (event.target == modal) {
            closeEditModal();
        }
    }
</script>

</body>
</html>