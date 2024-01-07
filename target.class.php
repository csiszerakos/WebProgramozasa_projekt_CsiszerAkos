<?php

namespace savemoneyapp;

class Target
{
    function addTarget($id_target,$user_id,$type_target,$amount_target){
        global $con;

        $new_target="INSERT INTO targets VALUES (?,?,?,?)";
        $stmt=$con->prepare($new_target);


        $stmt->bind_param('iisd',$id_target,$user_id,$type_target,$amount_target);

        if($stmt->execute()){
            echo "Cél sikeresen hozzáadva";
        }
        else{
            echo "Hiba történt: " . $stmt->error;
        }
    }

    function updateTarget($id_target, $type_target, $amount_target) {
        global $con;

        $update_target = "UPDATE targets SET type = ?, amount = ? WHERE id = ?";
        $stmt = $con->prepare($update_target);

        $stmt->bind_param('sdi', $type_target, $amount_target, $id_target);

        if ($stmt->execute()) {
            echo "Cél sikeresen frissítve";
        } else {
            echo "Hiba történt: " . $stmt->error;
        }
    }

    function listTargets()
        {
            global $con;

            $total_target = "SELECT id, type, amount FROM targets WHERE user_id = '" .$_POST['user_id'] . "'";
            $result = $con->query($total_target);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "ID: " . $row["id"] . " - Típus: " . $row["type"] .  " - Összeg: " . $row["amount"]. "<br>";
                }
            } else {
                echo "Nincsenek célok.";
            }
        }
}