<?php
namespace savemoneyapp;

include 'connection.class.php';
include 'user.class.php';
include 'expenses.class.php';

session_start();

$connection = new Connection();
$connection->select_database('savemoneyapp', 'root', '');
$user = new User();
$user->isLogged();
global $id_session;
global $username_session;


if(isset($_POST['logout'])) {
$user->logout();
}

?>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 10px;
        background-color: #696969;
    }
    #menu{
        display: flex;
        flex-direction: row;
        height: 60px;
    }
    #menu h1{
        width: 70%;
        padding-left: 28%;
        color:#00FF00
    }
    p{
        padding-left: 5%;
        width: 15%;
        color:#00FF00;
        font-size:22px ;
    }
    form{
        width: 15%;
        padding-top: 20px;
    }
    button {
        background-color: #00FF00;
        color: #000;
        padding: 10px;
        border: none;
    }
    #container{
        width: 100%;
        align-content: center;
        display: flex;
        flex-direction: row;
    }
    #expenses{
        width: 100%;
    }
    #expenses_form,#reports_form{
        display: flex;
        flex-direction: column;
        width: auto;
        height: auto;
        align-items: center;
        padding-bottom: 50px;
    }
    input, select{
        width: 40%;
        height: 30px;
        font-size: 22px;
        background-color: #696969;
        color: #fff;
        border: 2px solid #fff;
    }
    label{
        font-size: 25px;
        color: #fff;
    }
    #reports{
        width: 100%;
    }
    #title{
        width: 100%;
        height: 150px;
        color: #22c222;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #reports #box{
        width: 100%;
        height:auto;
        border-top: 4px dotted #22c222;
        border-left: 4px dotted #22c222;
    }
    #expenses #box{
        width: 100%;
        height: auto;
        border-top: 4px dotted #22c222;
    }
    #result h1{
        color: #22c222;
        text-align: center;
        align-items: center;
        align-content: center;
    }
    #result{
        border: 4px dotted #22c222;
    }
    #result #box {
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-bottom: 50px;
        font-style: italic;
        font-size: 25px;
    }

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Irányítópult</title>
</head>
<body>
<div id="menu">
        <p>Hello, <?php echo $username_session ?>! </p>
    <h1>Dashboard</h1>
    <form action="dashboard.php" method="post">
        <button type="submit" name="logout">Kilépés</button>
    </form>
</div>
<div id="container">
    <div id="expenses">
        <div id="title">
            <h1>Kiadások</h1>
        </div>
        <div id="box">
            <form id="expenses_form" action="dashboard.php" method="post">
                <input type="hidden" name="id" id="id"><br>

                <input type="hidden" name="user_id" id="user_id" value="<?php echo $id_session ?>"><br>

                <label for="description">Megnevezés: </label>
                <input type="text" name="description" id="description"><br>

                <label for="type">Típus: </label>
                <select id="type" name="type" required>
                    <option value="" disabled selected>-----</option>
                    <option value="Tankolás">Tankolás</option>
                    <option value="Ruhavásárlás">Ruhavásárlás</option>
                    <option value="Élelmiszer vásárlás">Élelmiszervásárlás</option>
                    <option value="Szórakozás">Szórakozás</option>
                    <option value="Lakbér">Lakbér</option>
                </select><br>

                <label for="date">Dátum: </label>
                <input type="date" name="date" id="date"><br>

                <label for="amount">Összeg: </label>
                <input type="number" id="amount" name="amount" step="0.01" inputmode="decimal"><br>

                <input type="submit" name="add" value="Hozzáadás">
            </form>
            <?php
            if(isset($_POST['add'])){
                $id = $_POST['id'];
                $user_id = $id_session;
                $description = $_POST['description'];
                $type = $_POST['type'];
                $date = $_POST['date'];
                $amount = $_POST['amount'];

                $expenses = new Expenses();
                $expenses->addExpenses($id,$user_id,$description,$type,$date,$amount);
            }
            ?>
        </div>
    </div>
    <div id="reports">
        <div id="title">
            <h1>Jelentések kérése</h1>
        </div>
        <div id="box">
            <form id="reports_form" action="dashboard.php" method="post">
                <label for="type">Típus: </label>
                <select id="type" name="type">
                    <option value=" " disabled selected>-----</option>
                    <option value="Tankolás">Tankolás</option>
                    <option value="Ruhavásárlas">Ruhavásárlás</option>
                    <option value="Élelmiszer vásárlás">Élelmiszervásárlás</option>
                    <option value="Szórakozás">Szórakozás</option>
                    <option value="Lakbér">Lakbér</option>
                </select><br>

                <label for="start_date">Kezdeti dátum: </label>
                <input type="date" name="start_date" id="start_date"><br>

                <label for="end_date">Végső dátum: </label>
                <input type="date" name="end_date" id="end_date"><br>

                <label for="min_amount">Minimális összeg: </label>
                <input type="number" id="min_amount" name="min_amount" step="0.01" inputmode="decimal"><br>

                <label for="max_amount">Maximális összeg: </label>
                <input type="number" id="max_amount" name="max_amount" step="0.01" inputmode="decimal"><br>

                <input type="submit" name="search" value="Keresés">
                <input type="submit" name="listing" value="Költségek listázása">
            </form>
        </div>
    </div>
</div>
<div id="result">
    <div id="title">
        <h1>Jelentés eredmény</h1>
    </div>
    <div id="box">
        <?php
        if(isset($_POST['listing'])){
            $expenses = new Expenses();
            $expenses ->allExpenses();
        }
        elseif (isset($_POST['search'])){
            $expenses = new Expenses();
            $expenses->reportExpenses();
        }
        ?>
    </div>
</div>
</body>
</html>


