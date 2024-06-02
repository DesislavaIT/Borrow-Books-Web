<?php

require_once __DIR__ . '/../../repositories/UserRepository.php';

use repositories\UsersRepository;

session_start();

function alert($message) {
    echo "<script type='text/javascript'>alert('$message'); window.location.href = 'login.php';</script>";
    exit();
}

$userService = new UsersRepository();
$userService->deleteCurrent($user);
alert("Вие излязохте от Вашия профил.");
header("Location: ../authentication/login.php");
exit();

?>