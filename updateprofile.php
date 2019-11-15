<?php
    /*include('php-image-resize-master\lib\ImageResize.php');
    include('php-image-resize-master\lib\ImageResizeException.php');
    use \Gumlet\ImageResize;
    use \Gumlet\ImageResizeException;*/

    //Constants include DIRECTORY_SEPARATOR, PATHINFO_EXTENSION
    //Special methods - dirname, basename, join, getimagesize, pathinfo, in_array, move_upload_file

    
    //Function requires a file that is uploaded and an uploaded folder
    function upload_pathway($image_filename, $upload_folder = 'Uploads'){
        // gets name of directory
        $current_path = dirname(__FILE__); 
        $uploaded_file = basename($_FILES['image']['name']);

        //Put parts of the pathway into an array and join them together
        $path_parts = [$current_path, $upload_folder, $uploaded_file];
        $joined_path = join(DIRECTORY_SEPARATOR, $path_parts);
        return $joined_path;
    }

    //Now that the image path is created, must validate to see if the file is an image. 
    //Takes in the temp pathway and spits out the new path if the image is verified.
    function validate_image($temp_path, $new_path){
        //Possible image formats the file can take if valid
        
        $possible_mimes = ['image/jpeg', 'image/png'];

        //Possible extensions the file can have if it is valid
        $possible_extensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png'];

        //Find the actual mime and image postfix type
        $actual_mime = getimagesize($temp_path)['mime'];
        $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);

        //Validate versus the possible types, both return a bool
        $valid_mime = in_array($actual_mime, $possible_mimes);
        $valid_filetype = in_array($actual_file_extension, $possible_extensions);

        //If one or the other is invalid, it will return false and validation will fail.
        return $valid_mime && $valid_filetype;
    }

        require('connect.php');
        session_start();
        $level = $_SESSION['level'];
        $username = $_SESSION['username'];
        $name = $_SESSION['name'];

        $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $bio = TRIM($bio);

        $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    
        if ($image_upload_detected) {
            $image_filename       = $_FILES['image']['name'];
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $new_image_path       = upload_pathway($image_filename);
    
            move_uploaded_file($temporary_image_path, $new_image_path);
            if(isset($_POST['submit'])){
                $query = "UPDATE users SET image = :image, Bio = :Bio WHERE username = :username";
                $statement = $db->prepare($query);
                $statement->bindValue(':image', $image_filename);
                $statement->bindValue(':Bio', $bio);
                $statement->bindValue(':username', $username);
                $statement->execute();
                header('Location: userindex.php');
            }
        }
?>