<?php
    //Id of entry is passed over via GET
    $id = $_GET['hardwareID'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    //Nullable fields
    if(!isset($_POST['serial'])){
        $_POST['serial'] = null;
        $serial = $_POST['serial'];
    }
    else{
        $serial = filter_input(INPUT_POST, 'serial', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $serial = TRIM($serial);
    }

    if(!isset($_POST['cost'])){
        $_POST['cost'] = null;
        $cost = $_POST['cost'];
    }
    else{
        $cost = filter_input(INPUT_POST, 'cost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cost = TRIM($cost);
        $cost = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_FLOAT);
    }

    if(!isset($_POST['notes'])){
        $_POST['notes'] = null;
        $notes = $_POST['notes'];
    }
    else{
        $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $notes = TRIM($notes);
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

                $query = "UPDATE hardware SET serialNum = :serialNum, make = :make, description = :description, 
                cost = :cost, notes = :notes, assignedTo = :assignedTo WHERE hardwareID = :hardwareID";

                $statement = $db->prepare($query);
                $statement->bindValue(':hardwareID', $id, PDO::PARAM_INT);
                $statement->bindValue(':serialNum', $serial);
                $statement->bindValue(':make', $make);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':cost', $cost);
                $statement->bindValue(':notes', $notes);
                $statement->bindValue(':assignedTo', $assignedTo);

                
                if($statement->execute()){
                    header("Location: hardware.php");
                }
                else{
                    ECHO "Invalid data, update has failed. Press the back button on your browser.";
                }
            }
    }

    //If required fields aren't set, then send error
    else{
        ECHO "Error: Invalid Data";
    }

?>