<?php
    require('connect.php');
    //Creates a user entry for the users table. Only admins have access to this functionality.
    session_start();
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];

    //GET value for username passed through
    $username_passed = $_GET['username'];

    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username_passed);
    $statement->execute();
    $row = $statement->fetch();

    if($row == null){
        ECHO "Error: Query returned no results, press the back button on your browser to view the hardware catalog.";
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit User</title>

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
      <a class="nav-link" href="#"><?=$username?> <span class="sr-only">(current)</span></a>
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
          <form method="post" action="updateuser.php?userID=<?=$row['userID']?>">
            <div class="form-row">
              <div class="col-12 col-md-4s mb-2 mb-md-0">
                <h3>Create A User</h3>
                    <label for="FName">First Name:</label>
                    <input class="form-control form-control-sm" id="FName" name="FirstName" type="text" value="<?=$row['firstName']?>"/>
                    <label for="LName">Last Name:</label>
                    <input class="form-control form-control-sm" id="LName" name="LastName" type="text" value="<?=$row['lastName']?>"/>
                    <label for="acctlvl">Account Level</label>
                    <input class="form-control form-control-sm" id="acctlvl" name="Level" type="number" min="1" max="3" value="<?=$row['level']?>"/>
                    <label for="department">Department:</label>
                    <input class="form-control form-control-sm" id="department" name="department" type="text" value="<?=$row['department']?>"/>
                    <label for="status">Account Is Active?</label>
                    <select id='active' name='active'>
                        <?php if($row['active'] == 'y'):?>
                            <option value="y" selected>Yes</option>
                            <option value="n">No</option>
                        <?php else:?>
                            <option value="y">Yes</option>
                            <option value="n" selected>No</option>
                        <?php endif?>
                    </select>
                    <label for="Username">Username:</label>
                    <input class="form-control form-control-sm" id="Username" name="username" type="text" value="<?=$row['username']?>"/>
                    <label for="password">Password:</label>
                    <input class="form-control form-control-sm" id="password" name="password" type="text" value="<?=$row['password']?>"/>
                    <label for="Notes">Notes:</label>
                    <input class="form-control form-control-sm" id="Notes" name="notes" type="text" value="<?=$row['notes']?>"/>
                    <button class="btn btn-block btn-lg btn-primary" type="submit">Update User</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

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