<?php
include 'classes/Database.php';
include 'classes/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $special_code = $_POST['special_code'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $code_stmt = $db->prepare("SELECT * FROM special_codes WHERE code = :code");
    $code_stmt->bindParam(':code', $special_code);
    $code_stmt->execute();
    $code = $code_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$code) {
        $error = "Invalid special code.";
    } elseif ($password != $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $result = $user->register($username, $password);

        if ($result === true) {
            header("Location: login.php");
            exit;
        } else {
            $error = $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <div class="form-container">
        <form action="register.php" method="post">
            <h2>Register</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="special_code">Special Code:</label>
                <input type="text" id="special_code" name="special_code" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="button">Register</button>
        </form>
    </div>
</body>
</html>
