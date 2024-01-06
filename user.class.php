<?php

namespace savemoneyapp;

class User
{
    function login($username,$password){

        global $con;

        $query = "SELECT id, username, password FROM users WHERE username=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stored_password = $user['password'];

            if (password_verify($password, $stored_password)) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location:dashboard.php');
            } else {
                echo "Hibás jelszó!";
            }
        } else {
            echo "Nem létező felhasználó!";
        }
    }

    function regist($id,$name,$username,$password,$confirm_password){

        global $con;

        if($password == $confirm_password){
            $hash_password=password_hash($password,PASSWORD_DEFAULT);

            $new_user="INSERT INTO users VALUES (?,?,?,?)";
            $stmt=$con->prepare($new_user);

            $stmt->bind_param('isss',$id,$name,$username,$hash_password);

            if($stmt->execute()){
                echo "Felhasználó sikeresen hozzáadva";
            }
            else{
                echo "Hiba történt: " . $stmt->error;
            }
        }
        else{
            echo "A két jelszó nem egyezik.";
        }
    }

    function isLogged(){
        global $username_session;
        global $id_session;

        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
        }else{
            $username_session = $_SESSION['username'];
            $id_session = $_SESSION['user_id'];
        }
    }

    function logout(){
        session_destroy();
        header('Location: login.php');
    }
}