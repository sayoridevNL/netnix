<?php
// 1. Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

session_start();

// 2. Fetch Data
$sql = "SELECT * FROM video";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
        <a href="#">Login</a>
        <input type="text" placeholder="Search">
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
            <?php while($row = $result->fetch(PDO::FETCH_ASSOC)){ ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['video']); ?></td>
                <td><?php echo $row['uploaded_at']; ?></td>
                <td>
                    <button class="edit-btn" onclick="openEditModal(
                        '<?php echo $row['id']; ?>', 
                        '<?php echo addslashes(htmlspecialchars($row['name'])); ?>', 
                        '<?php echo isset($row['beschrijving']) ? addslashes(htmlspecialchars($row['beschrijving'])) : ''; ?>'
                    )">Bewerken</button>  

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

        <form action="edit_process.php" method="POST">
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
    const modal = document.getElementById('editModal');

    // Function to open modal and fill data
    function openEditModal(id, name, desc) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_desc').value = desc;
        modal.style.display = 'flex';
    }

    // Function to close modal
    function closeEditModal() {
        modal.style.display = 'none';
    }

    // Close when clicking outside the box
    window.onclick = function(event) {
        if (event.target == modal) {
            closeEditModal();
        }
    }
</script>

</body>
</html>