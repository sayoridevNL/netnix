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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

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

</body>
</html>