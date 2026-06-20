<?php

require_once "models/user.php";

$token = $_GET['token'] ?? null;

$message = "";
$error = "";

if (!$token) {
    $error = "Nevalidan aktivacioni link.";
} else {

    $success = activateUser($conn, $token);

    if ($success) {

        $message = "Nalog je uspešno aktiviran. Sada se možete ulogovati.";

    } else {

        $error = "Aktivacioni link je nevažeći ili je već iskorišćen.";
    }
}
?>

<div class="container py-5">

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
        <a href="index.php?strana=login" class="btn btn-dark mt-3">
            Idi na login
        </a>
    <?php endif; ?>

</div>