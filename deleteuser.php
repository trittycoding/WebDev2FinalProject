<?php 
    require('connect.php');
    session_start();
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];

    if($level == 1){
        $id = $_GET['userID'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if($id != false && $id != null && $id != ""){
            $query = "DELETE FROM users WHERE userID = :userID";
            $statement = $db->prepare($query);
            $statement->bindvalue(':userID', $id, PDO::PARAM_INT);
            if($statement->execute()){
                header('Location:users.php');
            }
            else{
                ECHO "Error: query was not executed. Press the back button on your browser to return to the previous page";
            }
        }
        else{
            ECHO "Error: System cannot find the primary key associated with this user. Delete has failed. Press back on your browser.";
        }
    }
    else{
        ECHO "You do not have access to this page, press back on your browser to return to the previous page.";
    }

?>