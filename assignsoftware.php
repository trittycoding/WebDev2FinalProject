<?php
    if(isset($_GET['softwareID'], $_GET['assignedTo'])){
        //GET variables - userID to assign and softwareID to assign to
        $softwareID = filter_input(INPUT_GET, 'softwareID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $assignedTo = filter_input(INPUT_GET, 'assignedTo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //If the userID and softwareID values are valid then update the row
        if(!(filter_var($assignedTo, FILTER_VALIDATE_INT) && filter_var($softwareID, FILTER_VALIDATE_INT))){
            ECHO "Invalid data. Press back on your browser to retry.";
        }
        else{      
            require('connect.php');
            $query = "UPDATE software SET assignedTo = :assignedTo WHERE softwareID = (:softwareID)";
            $statement = $db->prepare($query);
            $statement->bindValue(':softwareID', $softwareID, PDO::PARAM_INT);
            $statement->bindValue(':assignedTo', $assignedTo, PDO::PARAM_INT);
            if($statement->execute()){
                header('Location:software.php');
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