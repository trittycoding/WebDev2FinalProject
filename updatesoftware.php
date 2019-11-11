<?php
    //Id of entry is passed over via GET
    $id = $_GET['softwareID'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    //Nullable Fields
    if(!isset($_POST['version'])){
        $_POST['version'] = null;
        $version = $_POST['version'];
    }
    else{
        $version = filter_input(INPUT_POST, 'version', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $version = TRIM($version);
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

    if(!isset($_POST['subscription_cycle'])){
        $_POST['subscription_cycle'] = null;
        $sub_cycle = $_POST['subscription_cycle'];
    }
    else{
        $sub_cycle = filter_input(INPUT_POST, 'subscription_cycle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sub_cycle = TRIM($sub_cycle);
    }

    if(!isset($_POST['expiry'])){
        $_POST['expiry'] = null;
        $expiry = $_POST['expiry'];
    }
    else{
        $expiry = $_POST['expiry'];
    }

    //Required Fields
    if(isset($_POST['key'], $_POST['publisher'], $_POST['description'], $_POST['subscription'], $_POST['location'])){
        $key = $_POST['key'];
        $publisher = $_POST['publisher'];
        $description = $_POST['description'];
        $subscription = $_POST['subscription'];
        $location = $_POST['location'];
        $assignedTo = null;

        $key = filter_var($key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $publisher = filter_var($publisher, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $subscription = filter_var($subscription, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $location = filter_var($location, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $key = TRIM($key);
        $publisher = TRIM($publisher);
        
        if(0 < strlen($key) && strlen($key) <= 50 && 
            0 < strlen($publisher) && strlen($publisher) <= 50 &&
            0 < strlen($description) && strlen($description) <= 100){
                require('connect.php');

                $query = "UPDATE software SET licenseKey = :licenseKey, version = :version, publisher = :publisher, 
                description = :description, subscription = :subscription, cost = :cost, subscriptionCycle = :subscriptionCycle, 
                location = :location, expiry = :expiry, assignedto = :assignedTo WHERE softwareID = :softwareID";

                $statement = $db->prepare($query);
                $statement->bindValue(':softwareID', $id, PDO::PARAM_INT);
                $statement->bindValue(':licenseKey', $key);
                $statement->bindValue(':version', $version);
                $statement->bindValue('publisher', $publisher);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':subscription', $subscription);
                $statement->bindValue(':cost', $cost);
                $statement->bindValue(':subscriptionCycle', $sub_cycle);
                $statement->bindValue(':location', $location);
                $statement->bindValue(':expiry', $expiry);
                $statement->bindValue(':assignedTo', $assignedTo);

                if($statement->execute()){
                    header('Location: software.php');
                }
                else{
                    ECHO "Invalid data, update has failed. Press the back button on your browser.";
                }
        }
    }

    else{
        ECHO "Error: Invalid Data";
    }
?>