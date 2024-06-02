<?php

require_once __DIR__ . '/../../repositories/UserRepository.php';

use repositories\UsersRepository;

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

function alert($message) {
    echo "<script type='text/javascript'>alert('$message'); window.location.href = 'login.php';</script>";
    exit();
}

// Validations
if (empty($email) || empty($password)) {
    alert("Моля попълнете всички полета.");
    exit();
}

$userService = new UsersRepository();
$user = $userService->getByEmail($email);
if (!$user) {
    alert("Невалидни потребителско име или парола.");
    exit();
}

$storedPassword = $user->getPasswordHash();
if (password_verify($password, $storedPassword)) {
    $_SESSION['email'] = $user->getEmail();
    $_SESSION['username'] = $user->getUsername();
    header("Location: ../home/home.php");
    $userService->createCurrent($user);
    exit();
} else {
    alert("Невалидни потребителско име или парола.");
    exit();
}

?>