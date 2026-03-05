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
    <a href="index.html">Home</a>
    <a href="adminpagina.php">Admin</a>
    <a href="#">Login</a>
    <input type="text" placeholder="Search">
  </div>
</header>

<main>
  <h2>Admin Dashboard</h2>

  <ul class="admin-list">
    <li>
      <img src="images/logo2.png" alt="Dashboard Item 1">
      <span>Manage Movies</span>
    </li>
    <li>
      <img src="images/logo2.png" alt="Dashboard Item 2">
      <span>Manage Users</span>
    </li>
    <li>
      <img src="images/logo2.png" alt="Dashboard Item 3">
      <span>Manage Categories</span>
    </li>
    <li>
      <img src="images/logo2.png" alt="Dashboard Item 4">
      <span>Manage Settings</span>
    </li>
  </ul>
</main>

<<<<<<< Updated upstream
=======
<div class="modal-overlay">
    <div class="modal-content">
        <label for="modal-toggle" class="close-btn">&times;</label>
        <h3>Upload New Movie</h3>
        
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label class="form-label">Select Movie File:</label>
            <input type="file" name="movie_file" accept="video/mp4, video/mov" required>

            <label class="form-label">Thumbnail:</label>
            <input type="file" name="thumbnail_file" accept="image/png, image/jpeg" required>

            <label class="form-label">Naam:</label>
            <input type="text" name="movie_name" placeholder="Enter title..." required>

            <label class="form-label">Beschrijving:</label>
            <textarea name="movie_desc" rows="4" placeholder="Enter description..."></textarea>

            <button type="submit" class="save-btn">Save Movie</button><br>
        </form>
    </div>
</div>

>>>>>>> Stashed changes
<footer>
  <p>&copy; 2026 NetNix</p>
</footer>

</body>
</html>
