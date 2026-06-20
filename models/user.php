<?php

function getUserByEmail($conn, $email)
{
    $query = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);

    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getUserByUsername($conn, $username)
{
    $query = "SELECT * FROM users WHERE username = ?";

    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);

    return $stmt->fetch(PDO::FETCH_OBJ);
}

function registerUser(
    $conn,
    $firstName,
    $lastName,
    $username,
    $email,
    $password,
    $activationCode
)
{
    $query = "
        INSERT INTO users
        (
            first_name,
            last_name,
            username,
            email,
            password,
            activation_code,
            role_id
        )
        VALUES
        (
            ?, ?, ?, ?, ?, ?, 2
        )
    ";

    $stmt = $conn->prepare($query);

    return $stmt->execute([
        $firstName,
        $lastName,
        $username,
        $email,
        $password,
        $activationCode
    ]);
}

function loginUser($conn, $email)
{
    $query = "SELECT * FROM users WHERE email = ? LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);

    return $stmt->fetch(PDO::FETCH_OBJ);
}

function activateUser($conn, $token)
{
    $query = "
        UPDATE users
        SET active = 1,
            activation_code = NULL
        WHERE activation_code = ?
    ";

    $stmt = $conn->prepare($query);
    return $stmt->execute([$token]);
}


function incrementFailedLogin($conn, $userId)
{
    $query = "
        UPDATE users
        SET failed_attempts = failed_attempts + 1
        WHERE id = ?
    ";

    $stmt = $conn->prepare($query);
    return $stmt->execute([$userId]);
}

function lockUser($conn, $userId)
{
    $query = "
        UPDATE users
        SET locked_until = DATE_ADD(NOW(), INTERVAL 5 MINUTE),
            failed_attempts = 0
        WHERE id = ?
    ";

    $stmt = $conn->prepare($query);
    return $stmt->execute([$userId]);
}

function resetFailedLogin($conn, $userId)
{
    $query = "
        UPDATE users
        SET failed_attempts = 0,
            locked_until = NULL
        WHERE id = ?
    ";

    $stmt = $conn->prepare($query);
    return $stmt->execute([$userId]);
}