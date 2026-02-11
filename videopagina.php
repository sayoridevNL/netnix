<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NetNix Video Player</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="icon" type="image/x-icon" href="images/logo2.png">
</head>
<body>

<header>
  <div class="topnav">
    <img src="images/logo2.png" alt="NetNix Logo" class="logo-img">
    <a href="index.php">Home</a>
    <a href="adminpagina.php">Admin</a>
    <a href="#">Login</a>
    <input type="text" placeholder="Search">
  </div>
</header>

<main>
  <h2>Film titel</h2>

  <div class="video-container">
    <video controls>
      <source src="https://cdn.discordapp.com/attachments/722404331114070057/960253791339425802/video0-17.mp4?ex=698592c8&is=69844148&hm=31019d62cb345985d47f7dacc322df131fb7789205f2e153576fa871d91d68c5&" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <p class="video-description">
      This is a sample description for the video. You can put information about the movie, actors, or any other details here.
    </p>
  </div>

</main>

<footer>
  <p>&copy; 2026 NetNix. All rights reserved.</p>
</footer>

</body>
</html>
