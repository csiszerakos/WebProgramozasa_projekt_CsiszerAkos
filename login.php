<?php
namespace savemoneyapp;

include 'connection.class.php';
include 'user.class.php';

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $connection = new Connection();
    $connection->select_database('savemoneyapp', 'root', '');
    $user = new User();
    $user->login($username,$password);

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location:login.php');
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #696969;
        }

        #login-container {
            max-width: 450px;
            margin: 90px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 95%;
            padding: 8px;
            margin-bottom: 16px;
        }
        button {
            background-color: #00FF00;
            color: #000;
            padding: 10px;
            border: none;
        }
    </style>
</head>
<body>
<div id="login-container">
    <h2>Belépés</h2>
    <form action="login.php" method="post">
        <input type="hidden" id="id" name="id">

        <label for="username">Felhasználónév:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Jelszó:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Belépés</button>
    </form>
    <form action="registration.php"><button type="submit">Regisztráció</button></form>

</div>

</body>
</html>
