<?php
    //Verifies the user identity and logs that person into the system.
    require('connect.php');

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
        $row = $statement->fetch();
        $id = $row['userID'];

        //If query doesn't return null and account is active, then compare the passwords
        if($credentials != null && $account_status == 'y'){
            $password_db = $credentials['password'];

            //If the passwords match, then create variables & assign to session
            if(password_verify($password_input, $password_db)){
                session_start();
                $_SESSION['username'] = $credentials['username'];
                $_SESSION['name'] = $credentials['firstName'].' '.$credentials['lastName'];
                $_SESSION['level'] = $credentials['level'];

                //Update the last login column on the users table since the user has successfully logged in
                $lastLogin = date('Y-m-d h:i:s');
                $update = "UPDATE users SET lastLogin = :lastLogin WHERE userID = :userID";
                $updateLoginStatement = $db->prepare($update);
                $updateLoginStatement->bindValue(':userID', $id, PDO::PARAM_INT);
                $updateLoginStatement->bindValue(':lastLogin', $lastLogin);
                $updateLoginStatement->execute();
                
                //Redirect the logged in user to their homepage
                header('Location: userindex.php');
            }

            //Passwords do not match
            else{
                ECHO "The password entered do not match our records. Press the back button on your browser to re-try.";
            }
        }

        //Account query doesn't return null but account status is set to inactive
        elseif($credentials != null && $account_status == 'n'){
            ECHO "<p> This account is currently deactivated. Contact your system administrator for reactivation. </p>";
            ECHO "<p> Press the back button on your browser to log in with a different account. </p>";
        }

        //Non-Existant Account
        else{
            ECHO "Account does not exist. Press the back button on your browser to log in with a valid account.";
        }
    }
?>