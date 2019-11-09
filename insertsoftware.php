<?php
    //Nullable Fields
    if(!isset($_POST['version'])){
        $_POST['version'] = null;
        $version = $_POST['version'];
    }
    else{
        $version = $_POST['version'];
    }

    if(!isset($_POST['cost'])){
        $_POST['cost'] = null;
        $cost = $_POST['cost'];
    }
    else{
        $cost = $_POST['cost'];
    }

    if(!isset($_POST['subscription_cycle'])){
        $_POST['subscription_cycle'] = null;
        $sub_cycle = $_POST['subscription_cycle'];
    }
    else{
        $sub_cycle = $_POST['subscription_cycle'];
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
            0 < strlen($publisher) && strlen($publisher) <= 20 &&
            0 < strlen($description) && strlen($description) <= 20){
                require('connect.php');

                $insert = "INSERT INTO software (licenseKey, version, publisher, description, subscription, cost, subscriptionCycle, location, expiry, assignedTo) VALUES
                (:licenseKey, :version, :publisher, :description, :subscription, :cost, :subscriptionCycle, :location, :expiry, :assignedTo)";

                $statement = $db->prepare($insert);
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
        }
    }

    else{
        ECHO "License key, publisher, subscription, location are required.";
    }
?>