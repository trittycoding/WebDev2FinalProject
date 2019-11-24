<?php
    require('connect.php');
    //Inserts a category into the userCategory table
    if(isset($_POST['categoryID'])){
        $categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(filter_var($categoryID, FILTER_VALIDATE_INT)){

            $query2 = "DELETE FROM SoftwareCategories WHERE categoryID = (:categoryID)";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(':categoryID', $categoryID);
            if($statement2->execute()){
                header('Location:softwarecategories.php');
            }
            else{
                ECHO "Unknwon Error: Query did not execute. Press back on your browser to retry.";
            }
        }
        else{
            ECHO "Invalid Data: The deletion did not execute. Press back on your browser to retry.";
        }
    }

    else{
        header('Location:softwarecategories.php');
    }

?>
