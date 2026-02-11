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
  <title>NetNix Admin Dashboard</title>
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

<footer>
  <p>&copy; 2026 NetNix</p>
</footer>

</body>
</html>
