<?php
    require('connect.php');

      //Current page number of results
      if(isset($_GET['page'])){
        $page = $_GET['page'];
      }
      else{
        $page = 1;
      }

    //Sortable elements
    if(!isset($_GET['direction'], $_GET['category'])){
        $direction = 'asc';
        $sort_category = 'username';
    }
    else{
        $direction = $_GET['direction'];
        $sort_category = $_GET['category'];
    }

    //Executing query to determine the amount of data
    $query2 = "SELECT * FROM software ORDER BY $sort_category $direction";
    $statement2 = $db->prepare($query2);
    $statement2->execute();

    session_start();
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];

    //Query to populate the selectable search categories
    $query3 = "SELECT softwareCategory FROM SoftwareCategories";
    $statement3 = $db->prepare($query3);
    $statement3->execute();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Software</title>

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
            <h1>Created Software</h1>
            <!--Searchbox-->
            <form method="GET" action="searchSoftware.php">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search_value"/>
                <div class="form-group">
                  <select class="form-control" name="category" id="category">
                    <?php while($category = $statement3->fetch()):?>
                      <option class="dropdown-item" value="<?=$category['softwareCategory']?>"><?=strtoupper($category['softwareCategory'])?></option>
                    <?php endwhile?>
                  </select>
                  </div>
                  <button class="btn btn-primary" type="submit">Search</button>
                  <button class="btn btn-warning" type="submit" formaction="software.php">Reset</button>
            </form>

            <!--Sortbox-->
            <form method="GET" action="sortSoftware.php">                
            <h4> Or Sort By Column:</h4>
              <div class="form-group">
                <select class="form-control" name="category" id="category">
                  <option value="licenseKey">LICENSE KEY</option>
                  <option value="version">VERSION</option>
                  <option value="publisher">PUBLISHER</option>
                  <option value="description">DESCRIPTION</option>
                  <option value="subscription">SUBSCRIPTION</option>
                  <option value="cost">COST</option>
                  <option value="subscriptionCycle">SUBSCRIPTION CYCLE</option>
                  <option value="location">LOCATION</option>
                  <option value="expiry">EXPIRY</option>
                  <option value="assignedTo">POSSESSION</option>
                </select>
                <select class="form-control" name="direction" id="direction">
                  <option class="dropdown-item" value="asc">Asc</option>
                  <option class="dropdown-item" value="desc">Desc</option>
                </select>
              <button class="btn btn-primary" type="submit">Sort</button>
              <button class="btn btn-warning" type="submit" formaction="software.php">Reset</button>
              </div>
            </form>

        </div>
      </div>
    </div>
  </header>

<<table class="table table-dark">
    <tbody>
        <tr>
            <th>Catalog ID:</th>
            <th>License Key:</th>
            <th>Version:</th>
            <th>Publisher:</th>
            <th>Description:</th>
            <th>Subscription:</th>
            <th>Cost:</th>
            <th>Subscription Cycle:</th>
            <th>Location:</th>
            <th>Expiry:</th>
            <th>Possession:</th>
        </tr>

        <?php while($row = $statement2->fetch()):?>
        <tr>
          <?php if($level == 1):?>
            <td><a href="editsoftware.php?softwareID=<?=$row['softwareID']?>"><?=$row['softwareID']?></a></td>
          <?php else:?>
              <td><?=$row['softwareID']?></td>
          <?php endif?>
            <td><?=$row['licenseKey']?></td>
            <td><?=$row['version']?></td>
            <td><?=$row['publisher']?></td>
            <td><?=$row['description']?></td>
            <td><?=$row['subscription']?></td>
            <td><?=$row['cost']?></td>
            <td><?=$row['subscriptionCycle']?></td>
            <td><?=$row['location']?></td>
            <td><?=$row['expiry']?></td>
            <td><?=$row['assignedTo']?></td>
        </tr>
        <?php endwhile?>
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

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>