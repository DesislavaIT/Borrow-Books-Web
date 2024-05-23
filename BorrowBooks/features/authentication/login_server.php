<?php

require_once __DIR__ . '/../../repositories/UserRepository.php';

use repositories\UsersRepository;

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Validations
if (empty($email) || empty($password)) {
    echo "Моля попълнете всички полета.";
    exit();
}

$userService = new UsersRepository();
$user = $userService->getByEmail($email);
if (!$user) {
    echo "Невалидни потребителско име или парола.";
    exit();
}

$storedPassword = $user->getPasswordHash();
if (password_verify($password, $storedPassword)) {
    $_SESSION['email'] = $user->getEmail();
    $_SESSION['username'] = $user->getUsername();
    header("Location: ../home/home.php");
    exit();
} else {
    echo "Невалидни потребителско име или парола.";
    exit();
}