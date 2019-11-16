<?php
    //User profile page - allows user to change bio and profile picture
    require('connect.php');
    session_start();
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];
    $image = $_SESSION['image'];

    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $row = $statement->fetch();

    $firstlast = strtolower(substr($row['firstName'], 0, 1).$row['lastName']);
    $department = $row['department'];

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Homepage</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
   <!-- Custom styles for this template -->
   <link href="css/landing-page.min.css" rel="stylesheet">
	</head>

<body>
      <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="userindex.php">Design By The GOAT</a>
      <span class="navbar-text">
        Welcome to your homepage <?=$name?>
      </span>
      <a class="nav-link" href="userindex.php"><?=$username?> <span class="sr-only">(current)</span></a>
      <a class="btn btn-primary btn-med" href="logout.php">Log Out</a>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <h1>Edit User Profile</h1>
        </div>
      </div>
    </div>
  </header>


<!--Form to edit user profile-->
  <div class="container-fluid">
        <form method="post" action="updateprofile.php" enctype='multipart/form-data'>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">Email:</label>
                <input type="text" readonly class="form-control-plaintext col-sm-3" id="staticEmail" value="<?=$firstlast?>@designbythegoat.com">
          </div>

            <div class="form-group row">
                <label for="staticDpt" class="col-sm-3 col-form-label">Department:</label>
                    <input type="text" readonly class="form-control-plaintext col-sm-3" id="staticDpt" value="<?=$department?>"/>
           </div>

          <div class="form-group row">
            <label for="inputPicture" class="col-sm-3 col-form-label">Profile Picture:</label>
              <div class="form-group row">
                <input type="file" class="form-control" id="inputPicture" name='image' placeholder="Click to upload a file"/>
                <img class="rounded float-right" src="Uploads/<?=$image?>" alt="<?=$image?>">
              </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="profileBio">Bio:</label>
          </div>
              <div class="form-group row">
                <textarea class="form-control" id="profileBio" rows="3" name="bio"><?=$row['Bio']?></textarea>
              </div>

          <button type="submit" name='submit' class="btn btn-primary">Update Profile</button>
        </form>
    </div>


  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Design By The GOAT 2019. All Rights Reserved.</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-facebook fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>