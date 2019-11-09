<?php
    //Grabbing post values from the create user page
    if(!isset($_POST['department'])){
        $_POST['department'] = null;
        $department = $_POST['department'];
    }
    else{
        $department = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if(!isset($_POST['notes'])){
        $_POST['notes'] = null;
        $notes = $_POST['notes'];
    }
    else{
        $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //If the required fields are set
    if(isset($_POST['FirstName'], $_POST['LastName'], $_POST['Level'], $_POST['active'], $_POST['password'], $_POST['username'])){ 
        $fname = filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lname = filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $level = filter_input(INPUT_POST, 'Level', FILTER_VALIDATE_INT);
        $active = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastLogin = date('Y-m-d h:i:s');
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fname = TRIM($fname);
        $lname = TRIM($lname);
        $password = TRIM($password);
        $username = TRIM($username);

            //If the parameters pass all of the tests, then insert into the database
            if(0 < strlen($fname) && strlen($fname) <=50 && 0 < strlen($lname) 
                && strlen($lname) <= 100 && $level && 7 < strlen($password) && strlen($password) <= 20
                    && 3 < strlen($username) && strlen($username) <= 20){
                require('connect.php');

                //Preparing the insert
                $insert = "INSERT INTO users (level, department, 
                active, firstName, lastName, password, lastLogin, notes, username) VALUES 
                (:level, :department, :active, :firstName, :lastName, :password, 
                :lastLogin, :notes, :username)";
                $statement = $db->prepare($insert);
        
                $statement->bindValue(':level', $level, PDO::PARAM_INT);
                $statement->bindValue(':department', $department);
                $statement->bindValue(':active', $active);
                $statement->bindValue(':firstName', $fname);
                $statement->bindValue(':lastName', $lname);
                $statement->bindValue(':password', $password);
                $statement->bindValue(':lastLogin', $lastLogin);
                $statement->bindValue(':notes', $notes);
                $statement->bindValue(':username', $username);
        
                if($statement->execute()){
                    header("Location: users.php");
                }
            }
        }

    else{
        ECHO "Invalid Data: First Name, Last Name, Level, Account Status and password are required.";
    }
?>