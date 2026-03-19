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
    $action = $_POST["action"] ?? "login";

    if ($action === "register") {
        // Check if email already exists in users or admin
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ? UNION SELECT email FROM admin WHERE email = ?");
        $stmt->execute([$email, $email]);
        if ($stmt->fetch()) {
            $error = "Email is already registered";
        } else {
            // Hash password and register user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            if ($stmt->execute([$email, $hashedPassword])) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $conn->lastInsertId();
                $_SESSION["email"] = $email;
                $_SESSION["role"] = "user";

                header("Location: voorpagina.php");
                exit();
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    } else {
        // Check admin table
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if (password_verify($password, $admin["password"]) || $password === $admin["password"]) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $admin["id"];
                $_SESSION["email"] = $admin["email"];
                $_SESSION["role"] = "admin";

                header("Location: adminpagina.php");
                exit();
            } else {
                $error = "Wrong password";
            }
        } else {
            // Check users table
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user["password"]) || $password === $user["password"]) {
                    session_regenerate_id(true);
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["role"] = "user";

                    header("Location: voorpagina.php");
                    exit();
                } else {
                    $error = "Wrong password";
                }
            } else {
                $error = "User not found";
            }
        }
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

            <button class="login-page__button" type="submit" name="action" value="login">Login</button>
            <button class="login-page__button" type="submit" name="action" value="register" style="margin-top: 15px; background-color: rgba(51,51,51,.9); color: white;">Register</button>

        </form>

    </div>
</div>

</body>
</html>