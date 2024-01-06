<?php
namespace savemoneyapp;

include 'connection.class.php';
include 'user.class.php';


if(isset($_POST['regist'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

$connection = new Connection();
$connection->select_database('savemoneyapp', 'root', '');
$user = new User();
$user->regist($id, $name, $username, $password, $confirm_password);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #696969;
        }

        #registration-container {
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
<div id="registration-container">
    <h2>Regisztráció</h2>
    <form action="registration.php" method="post">
        <input type="hidden" id="id" name="id">

        <label for="name" >Név</label>
        <input type="text" id="name" name="name" required>

        <label for="username">Felhasználónév:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Jelszó:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Jelszó megerősítése:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" name="regist">Regisztráció</button>
    </form>
    <form action="login.php"><button type="submit">Belépés</button></form>
</div>

</body>
</html>


