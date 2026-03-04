<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netnix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT name, video, beschrijving FROM video WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("No movie selected.");
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movie['name']); ?></title>
    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
</head>

<body>

<header>
    <h1><?php echo htmlspecialchars($movie['name']); ?></h1>
</header>

<div class="video-container">

    <video controls>
        <source src="uploads/<?=htmlspecialchars($movie['video']) ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <br><br>
<div>
    <p><?php echo htmlspecialchars($movie['beschrijving']); ?></p>
</div>
    <a class="back-btn" href="index.php">← Back to Movies</a>

</div>

</body>
</html>