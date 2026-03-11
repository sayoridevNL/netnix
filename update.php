<?php
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
  <meta charset="UTF-8">
  <title>NetNix</title>
  <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
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
    <?php
session_start();

$sql = "SELECT * FROM video";
$result = $conn->query($sql);
?>

    <table class="admintabel">

      <tr>
        <th>ID</th>
        <th>Naam</th>
        <th>Video</th>
        <th>Uploaded at</th>
        <th>Acties</th>
      </tr>

      <?php while($row = $result->fetch(PDO::FETCH_ASSOC)){ ?>

      <tr>
        <td>
          <?php echo $row['id']; ?>
        </td>
        <td>
          <?php echo $row['name']; ?>
        </td>
        <td>
          <?php echo $row['video']; ?>
        </td>
        <td>
          <?php echo $row['uploaded at']; ?>
        </td>
        <td>
          <a href="delete.php?id=<?php echo $row['id']; ?>" 
             onclick="return confirm('Weet je zeker dat je dit wilt verwijderen?')">
             Verwijderen
          </a>
        </td>
      </tr>
      <?php } ?>
    </table>

  </main>

  <footer>
    <p>&copy; 2026 NetNix</p>
  </footer>

</body>

</html>