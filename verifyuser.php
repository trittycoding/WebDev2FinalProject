<?php
    require('connect.php');
    //print_r($_POST);
    //Check to see if the password and username are set in POST
    if(isset($_POST['password'], $_POST['username'])){
        $username_input = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password_input = $_POST['password'];

        //If they are, query the database for the username
        $db_login = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($db_login);
        $statement->bindValue(':username', $username_input);
        $statement->execute();
        $credentials = $statement->fetch();
        $account_status = $credentials['active'];

        //If query doesn't return null, then compare the passwords
        if($credentials != null && $account_status == 'y'){
            $password_db = $credentials['password'];

            //If the passwords match, then create variables & assign to session
            if(password_verify($password_input, $password_db)){
                session_start();
                $_SESSION['username'] = $credentials['username'];
                $_SESSION['name'] = $credentials['firstName'].' '.$credentials['lastName'];
                $_SESSION['status'] = $credentials['status'];

                if($credentials['status'] == 1){
                    header('Location: adminuserindex.php');
                }
                elseif($credentials['status' == 2]){
                    header('Location: manageruserindex.php');
                }
                else{
                    header('Location: regularuserindex.php');
                }
            }
        }
    }
    else{
        header('Location: failedlogin.php');
    }
?>