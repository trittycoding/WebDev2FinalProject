<?php

    //Nullable fields
    if(!isset($_POST['serial'])){
        $_POST['serial'] = null;
        $serial = $_POST['serial'];
    }
    else{
        $serial = filter_input(INPUT_POST, 'serial', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if(!isset($_POST['cost'])){
        $_POST['cost'] = null;
        $cost = $_POST['cost'];
    }
    else{
        $cost = filter_input(INPUT_POST, 'cost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cost = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_FLOAT);
    }

    if(!isset($_POST['notes'])){
        $_POST['notes'] = null;
        $notes = $_POST['notes'];
    }
    else{
        $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Required Fields
    if(isset($_POST['make'], $_POST['description'])){
        $make = filter_input(INPUT_POST, 'make', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $make = TRIM($make);
        $description = TRIM($description);
        $assignedTo = null;

        if(0 < strlen($make)  && strlen($make) <= 50 && 0 < strlen($description)
            && strlen($description) <= 100){
                require('connect.php');

                $insert = "INSERT INTO Hardware (serialNum, make, description, cost, notes, assignedTo) VALUES 
                (:serialNum, :make, :description, :cost, :notes, :assignedTo)";

                $statement = $db->prepare($insert);
                $statement->bindValue(':serialNum', $serial);
                $statement->bindValue(':make', $make);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':cost', $cost);
                $statement->bindValue(':notes', $notes);
                $statement->bindValue(':assignedTo', $assignedTo);

                
                if($statement->execute()){
                    header("Location: hardware.php");
                }
            }
    }

    //If required fields aren't set, then send error
    else{
        ECHO "Make and Description are required.";
    }

?>