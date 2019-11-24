<?php
    require('connect.php');
    //Inserts a category into the userCategory table
    if(isset($_POST['category'])){
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category = strtolower($category);
        //Find out if the category already exists in the table
        $query = "SELECT softwareCategory FROM SoftwareCategories WHERE softwareCategory = :softwareCategory";
        $statement = $db->prepare($query);
        $statement->bindValue(':softwareCategory', $category);
        $statement->execute();

        //If the query returns a rowcount greater than zero, throw error msg
        if($statement->rowCount() > 0){
            ECHO "The category selected already exists in the table";
        }
        else{
            $query2 = "INSERT INTO SoftwareCategories (softwareCategory) VALUES (:softwareCategory)";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(':softwareCategory', $category);
            if($statement2->execute()){
                header('Location:softwarecategories.php');
            }
            else{
                ECHO "Unknwon Error: Query did not execute. Press back on your browser to retry.";
            }
        }
    }
    else{
        header('Location:softwarecategories.php');
    }

?>