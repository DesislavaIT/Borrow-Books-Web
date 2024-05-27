<?php

require_once __DIR__ . '/../../repositories/UserRepository.php';
require_once __DIR__ . '/../../models/User.php';

use models\User;
use repositories\UsersRepository;

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirmpassword'];

function alert($message) {
    $message = json_encode($message);
    echo "<script type='text/javascript'>alert($message); window.location.href = 'registration.php';</script>";
    exit();
}

// Validations
if (empty($email) || empty($password) || empty($username) || empty($confirm_password)) {
    alert("Моля попълнете всички полета.");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    alert("Моля въведете валиден имейл адрес.");
    exit();
}

if (strlen($password) < 8) {
    alert("Паролата трябва да е поне 8 символа");
    exit();
}

if (!preg_match('/[A-Z]/', $password)) {
    alert("Паролата трябва да съдържа поне една главна буква.");
    exit();
}

if (!preg_match('/[a-z]/', $password)) {
    alert("Паролата трябва да съдържа поне една малка буква.");
    exit();
}

if (!preg_match('/[0-9]/', $password)) {
    alert("Паролата трябва да съдържа поне еднo число.");
    exit();
}

if (!preg_match('/[\W]/', $password)) {
    alert("Паролата трябва да съдържа поне един специален символ.");
    exit();
}

if ($password !== $confirm_password) {
    alert("Паролите трябва да съвпадат.");
    exit();
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

try {
    $user_repo = new UsersRepository();

    if ($user_repo->getByUsername($username)) {
        alert("Това потребителско име вече съществува.");
        exit();
    }

    if ($user_repo->getByEmail($email)) {
        alert("Този имейл вече съществува.");
        exit();
    }

    $user = new User($username, $email, $passwordHash);
    $is_successful = $user_repo->create($user);

    if ($is_successful) {
        alert("Успешна регистрация.");
        header("Location: ../home/home.php");
        exit();
    } else {
        alert("Грешка по време на регистрацията.");
        exit();
    }
} catch (Exception $e) {
    alert("Възникна грешка: " . $e->getMessage());
}

?>