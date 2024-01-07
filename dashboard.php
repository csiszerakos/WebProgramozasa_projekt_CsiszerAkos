<?php
namespace savemoneyapp;

use function PHPUnit\Framework\isEmpty;

include 'connection.class.php';
include 'user.class.php';
include 'expenses.class.php';
include 'target.class.php';

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Irányítópult</title>
</head>
<body>
<div id="menu">
        <p>Üdvözöllek, <?php echo $username_session ?>! </p>
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
                <select id="type" name="type" >
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
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $id_session ?>"><br>

                <label for="type">Típus: </label>
                <select id="type" name="type">
                    <option value="" disabled selected>-----</option>
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
    <div id="target">
        <div id="title">
            <h1>Célok hozzáadása</h1>
        </div>
        <div id="box">
            <form id="target_form" action="dashboard.php" method="post">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $id_session ?>"><br>
                <label for="id">ID:</label>
                <input type="number" name="id" id="id"><br>

                <label for="type">Típus: </label>
                <select id="type" name="type" required>
                    <option value="" disabled selected>-----</option>
                    <option value="Tankolás">Tankolás</option>
                    <option value="Ruhavásárlas">Ruhavásárlás</option>
                    <option value="Élelmiszer vásárlás">Élelmiszervásárlás</option>
                    <option value="Szórakozás">Szórakozás</option>
                    <option value="Lakbér">Lakbér</option>
                </select><br>

                <label for="amount">Összeg: </label>
                <input type="number" id="amount" name="amount" step="0.01" inputmode="decimal" required><br>

                <input type="submit" name="add_target" value="Hozzáadás">
                <input type="submit" name="update_target" value="Cél modósítás" >
            </form>
            <?php
            if(isset($_POST['add_target'])){
                $id_target = $_POST['id'];
                $user_id = $id_session;
                $type_target = $_POST['type'];
                $amount_target = $_POST['amount'];

                $target = new Target();
                $target->addTarget($id_target,$user_id,$type_target,$amount_target);
            }
            if(isset($_POST['update_target'])){
                $id_target = $_POST['id'];
                $type_target = $_POST['type'];
                $amount_target = $_POST['amount'];

                $target = new Target();
                if(!empty($_POST['id'])) {
                    $target->updateTarget($id_target, $type_target, $amount_target);
                }else{
                    echo "Adjon meg egy id-t!";
                }
            }
            ?>
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
<div id="targets_result">
    <div id="title">
        <h1>Célok</h1>
    </div>
    <div id="box">
        <?php
            $target = new Target();
            $target->listTargets();
        ?>
    </div>
</div>
</body>
</html>


