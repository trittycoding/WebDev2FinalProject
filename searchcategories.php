<?php
    //
    require('connect.php');

    //Current page number of results
    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }
    else{
      $page = 1;
    }

    $error = "You do not have clearance to view this page. Press back on your browser to return to the previous page.";

    $query = "SELECT * FROM hardware";
    $statement = $db->prepare($query);
    $statement->execute();

    //Pagination variables
    $page_limit = 5;
    $result_count = $statement->rowCount();
    $page_total = ceil($result_count/$page_limit);
    $start_limit = ($page-1)*$page_limit;

    //Executing query to determine the amount of data
    $query2 = "SELECT * FROM hardware ORDER BY hardwareID LIMIT $start_limit, $page_limit";
    $statement2 = $db->prepare($query2);
    $statement2->execute();

    session_start();
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];

    //Query to populate the selectable search categories
    $query3 = "SELECT hardwareCategory FROM HardwareCategories";
    $statement3 = $db->prepare($query3);
    $statement3->execute();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Hardware</title>

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
      <a class="nav-link" href="userprofile.php"><?=$username?> <span class="sr-only">(current)</span></a>
      <a class="btn btn-primary btn-med" href="logout.php">Log Out</a>
    </div>
  </nav>

  <?php if($level != 1):?>
    <p><?=$error?></p>
  <?php else:?>
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <div class="col">
              <a class="btn btn-primary btn-lg btn-block btn-lg btn-block" href="usercategories.php" role="button">User Search Categories</a>
              <a class="btn btn-primary btn-lg btn-block btn-lg btn-block" href="hardwarecategories.php" role="button">Hardware Search Categories</a>
              <a class="btn btn-primary btn-lg btn-block" href="softwarecategories.php" role="button">Software Search Categories</a>
            </div>
        </div>
      </div>
    </div>
  </header>
  <?php endif?>


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