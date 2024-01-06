<?php
namespace savemoneyapp;


class Expenses
{
    function addExpenses($id,$user_id,$description,$type,$date,$amount){
        global $con;

        $new_expense="INSERT INTO expenses VALUES (?,?,?,?,?,?)";
        $stmt=$con->prepare($new_expense);


        $stmt->bind_param('iisssd',$id,$user_id,$description,$type,$date,$amount);

        if($stmt->execute()){
            echo "Költség hozzáadva sikeresen hozzáadva";
        }
        else{
            echo "Hiba történt: " . $stmt->error;
        }
    }

    function allExpenses(): void
    {
        global $con;

        $total_expenses_query = 'SELECT id,description, type, date, amount FROM expenses';
        $result = $con->query($total_expenses_query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " - Megnevezés: " . $row["description"]. " - Típus: " . $row["type"]. " - Dátum: " . $row["date"]. " - Összeg: " . $row["amount"]. "<br>";
            }
        } else {
            echo "Nincsen lekérdezés.";
        }
    }

    function reportExpenses()
    {
        global $con;
        if (!empty($_POST['type']) && empty($_POST['start_date']) && empty($_POST['end_date']) && empty($_POST['min_amount']) && empty($_POST['max_amount'])) {
            $type_expense = "SELECT * FROM expenses WHERE type='" . $_POST['type'] . "'";
            $result_type = $con->query($type_expense);
            if ($result_type->num_rows > 0) {
                while ($row = $result_type->fetch_assoc()) {
                    echo "Típus szerint listázás: " . "<br>" . "ID: " . $row["id"] . " - Megnevezés: " . $row["description"]. " - Típus: " . $row["type"]. " - Dátum: " . $row["date"]. " - Összeg: " . $row["amount"]. "<br>";
                }
            }
        }
        elseif (empty($_POST['type']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && empty($_POST['min_amount']) && empty($_POST['max_amount'])) {
            $date_expense = "SELECT * FROM expenses WHERE date >= '" . $_POST['start_date'] . "' AND date <= '" . $_POST['end_date'] . "'";
            $result_date = $con->query($date_expense);
            if ($result_date->num_rows > 0) {
                while ($row = $result_date->fetch_assoc()) {
                    echo "Dátum szerint listázás: " . "<br>" .  "ID: " . $row["id"] . " - Megnevezés: " . $row["description"]. " - Típus: " . $row["type"]. " - Dátum: " . $row["date"]. " - Összeg: " . $row["amount"]. "<br>";
                }
            }
        }
        elseif (empty($_POST['type']) && empty($_POST['start_date']) && empty($_POST['end_date']) && !empty($_POST['min_amount']) && !empty($_POST['max_amount'])) {
            $amount_expense = "SELECT * FROM expenses WHERE amount >= '" . $_POST['min_amount'] . "' AND amount <= '" . $_POST['max_amount'] . "'";
            $result_amount = $con->query($amount_expense);
            if ($result_amount->num_rows > 0) {
                while ($row = $result_amount->fetch_assoc()) {
                    echo "Összeg szerint listázás: " . "<br>" .  "ID: " . $row["id"] . " - Megnevezés: " . $row["description"]. " - Típus: " . $row["type"]. " - Dátum: " . $row["date"]. " - Összeg: " . $row["amount"]. "<br>";
                }
            }
        }
    }

}