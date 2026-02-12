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

try {
  $sql = "SELECT id, name, video FROM video";
  // Execute the SQL query
  $result = $conn->query($sql);
  // Process the result set
  if ($result->rowCount() > 0) {
    echo "<table><tr><th>ID</th><th>name</th><th>video</th></tr>";
    // Output data of each row
    while($row = $result->fetch()) {
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";
      echo "<td>" . $row['name'] . "</td>";
      echo "<td>" . $row['video'] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    unset($result);
  }
  else {
    echo "No records found.";
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NetNix</title>
  <link rel="stylesheet" href="style/style.css">
</head>

<body>

<header>
  <div class="topnav">
    <img src="images/logo2.png" alt="NetNix Logo" class="logo-img">
    <a href="#">Home</a>
    <a href="adminpagina.php">Admin</a>
    <a href="#">Login</a>
    <input type="text" placeholder="Search">
  </div>
</header>

<main>
  <h2>Movies</h2>

  <ul class="movie-list">
    <li>
      <img src="images/logo2.png" alt="Movie 1">
      <span>Jibril, How to do nothing</span>
    </li>
    <li>
      <img src="images/logo2.png" alt="Movie 2">
      <span>Van Wijngaarden against the cs go goons</span>
    </li>
    <li>
      <img src="images/logo2.png" alt="Movie 3">
      <span>Barm</span>
    </li>
    <li>
      <img src="images/logo2.png" alt="Movie 4">
      <span>Hentai vs furries the movie</span>
    </li>
  </ul>
</main>

<footer>
  <p>&copy; 2026 NetNix</p>
</footer>

</body>
</html>
