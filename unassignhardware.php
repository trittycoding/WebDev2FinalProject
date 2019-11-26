<?php
    if(isset($_GET['hardwareID'], $_GET['assignedTo'])){
        //GET variables - userID to assign and hardwareID to assign to
        $hardwareID = filter_input(INPUT_GET, 'hardwareID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $assignedTo = filter_input(INPUT_GET, 'assignedTo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //If the userID and hardwareID values are valid then update the row to be null for assignedTo
        if(!(filter_var($assignedTo, FILTER_VALIDATE_INT) && filter_var($hardwareID, FILTER_VALIDATE_INT))){
            ECHO "Invalid data. Press back on your browser to retry.";
        }
        else{      
            require('connect.php');
            $query = "UPDATE hardware SET assignedTo = :assignedTo WHERE hardwareID = (:hardwareID)";
            $statement = $db->prepare($query);
            $statement->bindValue(':hardwareID', $hardwareID, PDO::PARAM_INT);
            $statement->bindValue(':assignedTo', NULL);
            if($statement->execute()){
                header('Location:hardware.php');
            }
            else{
                ECHO "Update on row failed: invalid data. Press back on your browser to retry.";
            }
        }
    }
    else{
        ECHO "Error - Values not set. Press back on your browser to retry.";
    }
?>