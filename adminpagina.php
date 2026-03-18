<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  /*echo*/ "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
            <a href="#">Login</a>
            <input type="text" placeholder="Search">
        </div>
    </header>

    <input type="checkbox" id="modal-toggle">

    <main>
        <h2>Admin Dashboard</h2>

        <ul class="movie-list">
            <li class="movie-manage-item">
                <label for="modal-toggle" class="open-modal-label">
                    <img src="images/upload.png" alt="Add movies">
                    <div class="movie-info">
                        <span class="name">Add Movies</span>
                    </div>
                </label>
            </li>
            <li>
                <a href="update.php">
                    <img src="images/upload.png" alt="Dashboard Item 2">
                    <div class="movie-info">
                        <span class="name">Manage Movies</span>
                    </div>
                </a>
            </li>
            <li>
                <img src="images/upload.png" alt="Dashboard Item 3">
                <div class="movie-info">
                    <span class="name">Manage Categories</span>
                </div>
            </li>
            <li>
                <img src="images/upload.png" alt="Dashboard Item 4">
                <div class="movie-info">
                    <span class="name">Manage Settings</span>
                </div>
            </li>
        </ul>
    </main>

    <div class="modal-overlay">
<div class="modal-content">
    <label for="modal-toggle" class="close-btn">&times;</label>
    <h3>Upload New Movie</h3>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label class="form-label">Select Movie File (.mp4, .mov):</label>
        <input type="file" name="movie_file" accept="video/mp4, video/mov" required>

        <label class="form-label">Select Thumbnail File (.jpg, .png):</label>
        <input type="file" name="thumbnail_file" accept=".jpg, .jpeg, .png" required>

        <label class="form-label">Naam:</label>
        <input type="text" name="movie_name" placeholder="Enter title..." required>

        <label class="form-label">Beschrijving:</label>
        <textarea name="movie_desc" rows="4" placeholder="Enter description..."></textarea>

        <button type="submit" class="save-btn">Save Movie</button><br>
    </form>
</div>
    </div>

    <footer>
        <p>&copy; 2026 NetNix</p>
    </footer>

</body>

</html>