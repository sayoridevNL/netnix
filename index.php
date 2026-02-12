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
  /*echo*/ "Connection failed: " . $e->getMessage();
}

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
      <?php
try {
  $sql = "SELECT id, name, video FROM video";
  // Execute the SQL query
  $result = $conn->query($sql);
  // Process the result set
  if ($result->rowCount() > 0) {
    echo "<table><tr><th>FILMNAAM</th></tr>";
    // Output data of each row
    while($row = $result->fetch()) {
      echo "<tr>";
      echo "<td>" . $row['name'] . "</td>";
      "<td>" . $row['video'] . "</td>";
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
    </li>
  </ul>
</main>

<footer>
  <p>&copy; 2026 NetNix</p>
</footer>

</body>
</html>
