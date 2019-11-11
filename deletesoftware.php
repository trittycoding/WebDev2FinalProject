<?php 
    require('connect.php');
    $id = $_GET['softwareID'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    if($id != false && $id != null && $id != ""){
        $query = "DELETE FROM software WHERE softwareID = :softwareID";
        $statement = $db->prepare($query);
        $statement->bindvalue(':softwareID', $id, PDO::PARAM_INT);
        if($statement->execute()){
            header('Location: software.php');
        }
        else{
            ECHO "Error: query was not executed. Press the back button on your browser to return to the previous page";
        }
    }
    else{
        ECHO "Error: System cannot find the primary key associated with this entry. Delete has failed. Press back on your browser.";
    }
?>