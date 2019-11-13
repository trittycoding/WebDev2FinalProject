<?php 
    /*include('php-image-resize-master\lib\ImageResize.php');
    include('php-image-resize-master\lib\ImageResizeException.php');
    use \Gumlet\ImageResize;
    use \Gumlet\ImageResizeException;*/

    //Constants include DIRECTORY_SEPARATOR, PATHINFO_EXTENSION
    //Special methods - dirname, basename, join, getimagesize, pathinfo, in_array, move_upload_file
    
    //Function requires a file that is uploaded and an uploaded folder
    function upload_pathway($uploaded_file, $upload_folder = 'Uploads'){
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


    //If the image is set
    if(isset($_FILES['image'], $_POST['bio'])){

        require('connect.php');
        session_start();
        $level = $_SESSION['level'];
        $username = $_SESSION['username'];
        $name = $_SESSION['name'];
        print_r($_POST);
        
        //Bio variable
        $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $bio = TRIM($bio);

        //Compare the temp vs new paths
        $temp_path = $_FILES['image']['tmp_name'];
        $uploaded_file = $_FILES['image']['name'];
        $new_path = upload_pathway($uploaded_file);
        $uploaded_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);

        if(validate_image($temp_path, $new_path)){
            move_uploaded_file($temp_path, $new_path);

            /*$image_med = new ImageResize("Uploads/{$uploaded_file}");
            $image_med->resizeToWidth(400);
            $image_med->save("Uploads/{$uploaded_file}_med.{$uploaded_file}");

            $image_thumb = new ImageResize("Uploads/{$uploaded_file}");
            $image_thumb->resizeToWidth(50);
            $image_thumb->save("Uploads/{$uploaded_file}_thumb.{$uploaded_file_extension}");

            $new_path_med = upload_pathway($image_med);
            $new_path_thumb = upload_pathway($image_thumb);

            move_uploaded_file($temp_path, $new_path_med);
            move_uploaded_file($temp_path, $new_path_thumb);*/
            
            $query = "UPDATE users SET profilePicPath = :profilePicPath, Bio = :Bio WHERE username = :username";
            $statement = $db->prepare($query);
            $statement->bindValue(':profilePicPath', $new_path);
            $statement->bindValue(':Bio', $bio);
            $statement->bindValue(':username', $username);
            if($statement->execute()){
                header('Location: userindex.php');
            }
            else{
                ECHO 'Profile update failed, press the back button on your browser to re-try.';
            }
        }
        else {
            ECHO "Invalid data: please press back on your browser to try again.";
        }
    }
?>