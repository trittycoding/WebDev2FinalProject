<?php
    require('connect.php');
    //Inserts a category into the userCategory table
    if(isset($_POST['category'])){
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category = strtolower($category);
        //Find out if the category already exists in the table
        $query = "SELECT hardwareCategory FROM HardwareCategories WHERE hardwareCategory = :hardwareCategory";
        $statement = $db->prepare($query);
        $statement->bindValue(':hardwareCategory', $category);
        $statement->execute();

        //If the query returns a rowcount greater than zero, throw error msg
        if($statement->rowCount() > 0){
            ECHO "The category selected already exists in the table";
        }
        else{
            $query2 = "INSERT INTO HardwareCategories (hardwareCategory) VALUES (:hardwareCategory)";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(':hardwareCategory', $category);
            if($statement2->execute()){
                header('Location:hardwarecategories.php');
            }
            else{
                ECHO "Unknwon Error: Query did not execute. Press back on your browser to retry.";
            }
        }
    }
    else{
        header('Location:hardwarecategories.php');
    }

?>