<?php
<<<<<<< Updated upstream
=======
session_start();

>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
  echo "Connection failed: " . $e->getMessage();
=======
    die("Connection failed: " . $e->getMessage());
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user["password"]) || $password === $user["password"]) {
            
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = str_contains($user['email'], '@admin') ? "admin" : "user";

            header("Location: voorpagina.php");
            exit();
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "User not found";
    }
>>>>>>> Stashed changes
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< Updated upstream
  <meta charset="UTF-8">
  <title>NetNix</title>
  <link rel="stylesheet" href="style/style.css">
=======
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css">
>>>>>>> Stashed changes
</head>

<body>

<<<<<<< Updated upstream
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
      $sql = "SELECT id, name, video, thumbnail FROM video";
      $result = $conn->query($sql);

      if ($result->rowCount() > 0) {
        // The loop starts here
        while($row = $result->fetch()) {
          ?>
<<<<<<< Updated upstream
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
=======
      <li>
        <a href="videopagina.php?id=<?php echo $row['id']; ?>">
          <img src="images/<?php echo htmlspecialchars($row['thumbnail']); ?>" alt="Thumbnail">
          <div class="movie-info">
            <span class="label">FILMNAAM</span>
            <span class="name">
              <?php echo $row['name']; ?>
            </span>
          </div>
        </a>
      </li>
      <?php
>>>>>>> Stashed changes
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
=======
<div class="login-page">
    <div class="login-page__card">

        <h1 class="login-page__title">Login</h1>

        <?php if($error): ?>
            <p class="login-page__error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post">

            <div class="login-page__input-group">
                <input class="login-page__input" type="email" name="email" required placeholder=" ">
                <label class="login-page__label">Email</label>
            </div>

            <div class="login-page__input-group">
                <input class="login-page__input" type="password" name="password" required placeholder=" ">
                <label class="login-page__label">Password</label>
            </div>

            <button class="login-page__button" type="submit">Login</button>

        </form>

    </div>
</div>
>>>>>>> Stashed changes

</body>
</html>