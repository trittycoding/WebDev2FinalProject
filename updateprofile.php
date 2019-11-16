<?php
    include 'php-image-resize-master/lib/ImageResize.php';
    include 'php-image-resize-master/lib/ImageResizeException.php';
    use \Gumlet\ImageResize;
    use \Gumlet\ImageResizeException;

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
    function validate_image($temporary_image_path, $new_image_path){
        //Possible image formats the file can take if valid
        
        $possible_mimes = ['image/jpeg', 'image/png'];

        //Possible extensions the file can have if it is valid
        $possible_extensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png'];

        //Find the actual mime and image postfix type
        $actual_mime = getimagesize($temporary_image_path)['mime'];
        $actual_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);

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
        if(!$image_upload_detected){
            ECHO "No file has been selected. Press the back button on your browser to retry.";
        }

        //If a file upload is detected, start the upload process
        if ($image_upload_detected && isset($_POST['submit'])) {
            $image_filename = $_FILES['image']['name'];
            
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $new_image_path = upload_pathway($image_filename);
            $uploaded_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);
            
            //Identifying the length of file extension
            if(strlen($uploaded_file_extension) == 4){
                $position_of_period = strrpos(strtolower($image_filename), '.jpeg');
                $image_filename_no_extension = substr($image_filename, 0, $position_of_periods);
            }
            elseif(strlen($uploaded_file_extension) == 3){
                $image_filename_no_extension = substr($image_filename, 0, strlen($image_filename)-4);
            }
            
            //Moving the files to the upload folder if passing validation
            if(validate_image($temporary_image_path, $new_image_path) 
                && move_uploaded_file($temporary_image_path, $new_image_path)){
                    
                //Resize image to thumbnail size and save to the folder
                $image_thumb = new ImageResize("Uploads/{$image_filename}");
                $image_thumb->resizeToWidth(50);
                $image_thumb->save("Uploads/{$image_filename_no_extension}_thumb.{$uploaded_file_extension}");
                $new_image_path_thumb = upload_pathway($image_thumb);
                move_uploaded_file($temporary_image_path, $new_image_path_thumb);
                $thumbnail_image = "{$image_filename_no_extension}_thumb.{$uploaded_file_extension}";

                //If the post button has been pressed
                if(isset($_POST['submit'], $_FILES['image'])){
                    
                    $query = "UPDATE users SET image = :image WHERE username = :username";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':image', $thumbnail_image);
                    $statement->bindValue(':username', $username);
                    $statement->execute();

                    //Restart the session to display the picture properly
                    $db_login = "SELECT * FROM users WHERE username = :username";
                    $statement = $db->prepare($db_login);
                    $statement->bindValue(':username', $username);
                    $statement->execute();
                    $credentials = $statement->fetch();
                    session_destroy();

                    session_start();
                    $_SESSION['username'] = $credentials['username'];
                    $_SESSION['name'] = $credentials['firstName'].' '.$credentials['lastName'];
                    $_SESSION['level'] = $credentials['level'];
                    $_SESSION['image'] = $credentials['image'];
                    header('Location: userindex.php');
                }

                else{
                    ECHO "Please enter an image to upload as your profile picture. Press back on your browser to retry. ";
                }

            }
            else{
                ECHO "Invalid file extension. Press back on your browser to enter a valid file.";            
            }
        }
?>