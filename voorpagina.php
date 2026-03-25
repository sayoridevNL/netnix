<?php
session_start();
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>NetNix</title>
  <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
</head>

<body>

  <header>
    <div class="topnav">
      <img src="images/logo2.png" alt="NetNix Logo" class="logo-img">
      <a href="voorpagina.php">Home</a>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="adminpagina.php">Admin</a>
      <?php endif; ?>
      <a href="index.php">Logout</a>
    </div>
  </header>

  <main>
    <h2>Movies</h2>

    <ul class="movie-list">
      <?php
    try {
      $sql = "SELECT id, name, video, thumbnail  FROM video";
         $result = $conn->query($sql);

      if ($result->rowCount() > 0) {
        while($row = $result->fetch()) {
          ?>
      <li>
        <a href="videopagina.php?id=<?php echo $row['id']; ?>">
          <img class="thumbnail" src="thumbnails/<?=htmlspecialchars($row['thumbnail']) ?>" alt="Movie Logo">
          <div class="movie-info">
            <span class="label">FILMNAAM</span>
            <span class="name">
              <?php echo $row['name']; ?>
            </span>
          </div>
        </a>
      </li>
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
    </ul>
  </main>

  <footer>
    <p>&copy; 2026 NetNix</p>
  </footer>

</body>

</html>