<?php

require_once "config/connection.php";
require_once "models/user.php";
require_once "models/auth.php";

$errors = [];
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $user = loginUser($conn, $email);

    if (!$user) {
        $errors[] = "Korisnik ne postoji.";
    }

    else {
        if ($user->locked_until && strtotime($user->locked_until) > time()) {
            $errors[] = "Nalog je zaključan. Pokušajte kasnije.";
        }

        elseif ($user->active == 0) {
            $errors[] = "Nalog nije aktiviran.";
        }

        elseif (!password_verify($password, $user->password)) {

            incrementFailedLogin($conn, $user->id);

            $user->failed_attempts++;

            if ($user->failed_attempts >= 3) {
                lockUser($conn, $user->id);
            }

            $errors[] = "Pogrešna lozinka.";
        }

       else {

            resetFailedLogin($conn, $user->id);

            $_SESSION["user"] = [
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "role_id" => $user->role_id
            ];

            if ($user->role_id == 1) {
                $_SESSION["user"]["is_admin"] = true;
                 header("Location: index.php?strana=admin");
                exit;
            }

            $logLine = date("Y-m-d H:i:s") . " - LOGIN - " . $user->id . "\n";
            file_put_contents("data/login_logs.txt", $logLine, FILE_APPEND);

            header("Location: index.php?strana=home");
            exit;
        }
    }
}
?>

<div class="container py-5" style="max-width:500px;">
    <h2 class="mb-4">Login</h2>
    <?php if(count($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <div><?= $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-dark w-100">
            Login
        </button>
    </form>
</div>