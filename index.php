<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
  $conn = new PDO("mysql:host=$servername;dbname=,$dbname", $username, $password);
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
<<<<<<< Updated upstream
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
=======
    <?php
    try {
      $sql = "SELECT id, name, video FROM video";
      $result = $conn->query($sql);

      if ($result->rowCount() > 0) {
        // The loop starts here
        while($row = $result->fetch()) {
          ?>
            <a href="videopagina.php?id=<?php echo $row['id']; ?>">
              <li>
              <img src="images/logo2.png" alt="Movie Logo">
              <div class="movie-info">
                <span class="label">FILMNAAM</span>
                <span class="name"><?php echo $row['name']; ?></span>
              </div>
              </li>
            </a>
          
          <?php
        }
      } else {
        echo "No records found.";
      }
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
>>>>>>> Stashed changes
  </ul>
</main>

<footer>
  <p>&copy; 2026 NetNix</p>
</footer>

</body>
</html>