<?php
  require('connect.php');
  session_start();
  $level = $_SESSION['level'];
  $username = $_SESSION['username'];
  $name = $_SESSION['name'];

  $error = "You do not have clearance to view this page. Press back on your browser to return to the previous page.";

  /*System catalog query to get columns: SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA` = 'GOAT_CMS' AND `TABLE_NAME` = 'users';*/

  //Populate dropdowns dynamically with the columns from the database
  $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'GOAT_CMS' AND TABLE_NAME = 'users'";
  $statement = $db->prepare($query);
  $statement->execute();

  //Query to populate the categories in the table
  $query2 = "SELECT * FROM UserCategories";
  $statement2 = $db->prepare($query2);
  $statement2->execute();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User Categories</title>

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
        <form method="post" action="insertusercategory.php">
            <div class="form-row">
              <div class="col-12 col-md-4s mb-2 mb-md-0">
                <h3>User Categories: Add</h3>
                    <label for="category">Category:</label>
                    <select class="form-control" name="category" id="category">
                      <?php while($category = $statement->fetch()):?>
                        <option class="dropdown-item" value="<?=$category['COLUMN_NAME']?>"><?=strtoupper($category['COLUMN_NAME'])?></option>
                      <?php endwhile?>
                    </select>
                    <button class="btn btn-block btn-lg btn-primary" type="submit">Create Entry</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

  <<table class="table table-hover table-dark">
    <tbody>
        <tr>
            <th>CategoryID:</th>
            <th>User Category:</th>
        </tr>

        <?php while($row = $statement2->fetch()):?>
        <tr>
            <td><a href="editusercategory.php?categoryID=<?=$row['categoryID']?>"><?=$row['categoryID']?></td>
            <td><?=$row['userCategory']?></td>
        </tr>
        <?php endwhile?>
    </tbody>
</table>
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