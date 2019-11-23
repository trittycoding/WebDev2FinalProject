<?php
    require('connect.php');
    session_start();
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];

    //Error msg if the account level is not 1
    $error = "You do not have clearance to view this page, press back on your browser.";

    //Current page number of results
    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }
    else{
      $page = 1;
    }

    //If the searchbox and category are filled, search results
    if(isset($_GET['category'], $_GET['search_value']) && $_GET['search_value'] != ""){
        $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $search_value = filter_input(INPUT_GET, 'search_value', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $search_value = '%'.$search_value.'%';

        //Get all Rows
        $query = "SELECT * FROM users WHERE LOWER($category) LIKE LOWER(:category)";
        $statement = $db->prepare($query);
        $statement->bindValue(':category', $search_value);
        $statement->execute();
    }

    //If the searchbox isn't filled out, then get all results
    else{
        $query = "SELECT * FROM users";
        $statement = $db->prepare($query);
        $statement->execute();
    
        //Pagination variables
        $page_limit = 5;
        $result_count = $statement->rowCount();
        $page_total = ceil($result_count/$page_limit);
        $start_limit = ($page-1)*$page_limit;
    
        //Executing query to determine the amount of data
        $query = "SELECT * FROM users ORDER BY username LIMIT $start_limit, $page_limit";
        $statement = $db->prepare($query);
        $statement->execute();
    }

    //Query to populate the selectable search categories
    $query3 = "SELECT userCategory FROM UserCategories";
    $statement3 = $db->prepare($query3);
    $statement3->execute();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Users</title>

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
            <h1>Created Users</h1>
          <!--Searchbox-->
          <form method="GET" action="searchUsers.php">
          <h4>Search by keyword:</h4>
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search_value"/>
            <div class="form-group">
              <select class="form-control" name="category" id="category">
                <?php while($category = $statement3->fetch()):?>
                  <option class="dropdown-item" value="<?=$category['userCategory']?>"><?=strtoupper($category['userCategory'])?></option>
                <?php endwhile?>
              </select>
              <!--Form Buttons-->
              <button class="btn btn-primary" type="submit">Search</button>
              <button class="btn btn-warning" type="submit" formaction="users.php">Reset</button>
              </div>
            </form>

            <!--Sortbox-->
            <form method="GET" action="sortUsers.php">                
            <h4> Or Sort By Column:</h4>
              <div class="form-group">
                <select class="form-control" name="category" id="category">
                  <option value="username">USERNAME</option>
                  <option value="firstName">FIRSTNAME</option>
                  <option value="lastName">LASTNAME</option>
                  <option value="department">DEPARTMENT</option>
                  <option value="level">LEVEL</option>
                  <option value="active">ACTIVE</option>
                  <option value="lastLogin">LASTLOGIN</option>
                  <option value="notes">NOTES</option>
                </select>
                <select class="form-control" name="direction" id="direction">
                  <option class="dropdown-item" value="asc">Asc</option>
                  <option class="dropdown-item" value="desc">Desc</option>
                </select>
              <button class="btn btn-primary" type="submit">Sort</button>
              <button class="btn btn-warning" type="submit" formaction="users.php">Reset</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </header>

<<table class="table table-hover table-dark">
    <tbody>
        <tr>
            <th>Username:</th>
            <th>First Name:</th>
            <th>Last Name:</th>
            <th>Department:</th>
            <th>Account Level:</th>
            <th>Account Status</th>
            <th>Previous Login:</th>
            <th>Notes:</th>
        </tr>

        <?php if($statement->rowCount() != 0):?>
        <?php while($row = $statement->fetch()):?>
          <tr>
            <?php if($level == 1):?>
                <td><a href="edituser.php?username=<?=$row['username']?>"><?=$row['username']?></a></td>
            <?php else:?>
                <td><?=$row['username']?></td>
            <?php endif?>
            <td><?=$row['firstName']?></td>
            <td><?=$row['lastName']?></td>
            <td><?=$row['department']?></td>
            <td><?=$row['level']?></td>
            <td><?=$row['active']?></td>
            <td><?=$row['lastLogin']?></td>
            <td><?=$row['notes']?></td>
          </tr>
          <?php endwhile?>
        <?php else:?>
          <td>NO</td>
              <td>RESULTS</td>
              <td>FOUND</td>
        </tr>
        <?php endif?>
    </tbody>
</table>

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
  <?php endif?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>