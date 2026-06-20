<?php
require_once "models/user.php";
require_once "helpers/mail.php";

$errors = [];
$message = "";

$firstName = "";
$lastName = "";
$username = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = trim($_POST["first_name"]);
    $lastName = trim($_POST["last_name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // VALIDACIJA
    if (strlen($firstName) < 3) {
        $errors[] = "Ime mora imati najmanje 3 karaktera.";
    }

    if (strlen($lastName) < 3) {
        $errors[] = "Prezime mora imati najmanje 3 karaktera.";
    }

    if (strlen($username) < 4) {
        $errors[] = "Korisničko ime mora imati najmanje 4 karaktera.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email nije ispravan.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Lozinka mora imati najmanje 6 karaktera.";
    }

    if (getUserByEmail($conn, $email)) {
        $errors[] = "Email je već zauzet.";
    }

    if (getUserByUsername($conn, $username)) {
        $errors[] = "Korisničko ime je već zauzeto.";
    }

    if (count($errors) == 0) {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $activationCode = md5(time() . $email);

        $success = registerUser(
            $conn,
            $firstName,
            $lastName,
            $username,
            $email,
            $hash,
            $activationCode
        );

        if ($success) {

            $activationLink =
                "http://localhost/skarsneakers/index.php?strana=activate&token=" .
                $activationCode;

            sendActivationEmail($email, $activationLink);



            $message = "Registration successful! Check your email to activate your account. WARNING: It might be in your spam folder.";

            $firstName = "";
            $lastName = "";
            $username = "";
            $email = "";

        } else {
            $errors[] = "Greška prilikom registracije.";
        }
    }
}
?>

<div class="container py-5" style="max-width:600px;">
    <h2 class="mb-4">Register</h2>
    <?php if(count($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <div><?= $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if($message): ?>
        <div class="alert alert-success">
            <?= $message ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">First name</label>
            <input type="text" class="form-control" name="first_name"
                   value="<?= htmlspecialchars($firstName) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Last name</label>
            <input type="text" class="form-control" name="last_name"
                   value="<?= htmlspecialchars($lastName) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username"
                   value="<?= htmlspecialchars($username) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email"
                   value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button class="btn btn-dark w-100">
            Register
        </button>
    </form>
</div>