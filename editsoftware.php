<?php
    require('connect.php');
    session_start();
    $level = $_SESSION['level'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];

    //Id of entry is passed over via GET
    $id = $_GET['softwareID'];
    $id = filter_var($id, FILTER_SANITIZE_STRING);

    $query = "SELECT softwareID, licenseKey, version, publisher, description, subscription, cost,
    subscriptionCycle, location, DATE_FORMAT(expiry, '%Y-%m-%d') AS date FROM software WHERE softwareID = :softwareID";
    $statement = $db->prepare($query);
    $statement->bindValue(':softwareID', $id, PDO::PARAM_INT);
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
  <title>Edit Software Entry</title>

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
        <form method="post" action="updatesoftware.php?softwareID=<?=$row['softwareID']?>">
            <div class="form-row">
              <div class="col-12 col-md-4s mb-2 mb-md-0">
                <h3>Software Edit Wizard</h3>
                    <label for="key">License Key:</label>
                    <input class="form-control form-control-sm" id="key" name="key" type="text" value="<?=$row['licenseKey']?>"/>
                    <label for="version">Version:</label>
                    <input class="form-control form-control-sm" id="version" name="version" type="text" value="<?=$row['version']?>"/>
                    <label for="publisher">Publisher:</label>
                    <input class="form-control form-control-sm" id="publisher" name="publisher" type="text" value="<?=$row['publisher']?>"/>
                    <label for="description">Description:</label>
                    <input class="form-control form-control-sm" id="description" name="description" type="text" value="<?=$row['description']?>"/>
                    <label for="subscription">Subscription:</label>
                    <select id='subscription' name='subscription'>
                      <?php if($row['subscription'] == 'y'):?>
                        <option value="y" selected>Yes</option>
                        <option value="n">No</option>
                      <?php else:?>
                        <option value="y">Yes</option>
                        <option value="n" selected>No</option>
                      <?php endif?>
                    </select>
                    <label for="cost">Cost:</label>
                    <input class="form-control form-control-sm" id="cost" name="cost" type="text" value="<?=$row['cost']?>"/>
                    <label for="subscription_cycle">Subscription Cycle:</label>
                    <input class="form-control form-control-sm" id="subscription_cycle" name="subscription_cycle" type="text" value="<?=$row['subscriptionCycle']?>"/>
                    <label for="location">Software Location:</label>
                    <select id='location' name='location'>
                      <?php if($row['location'] == 'local'):?>
                        <option value="local" selected>Local</option>
                        <option value="cloud">Cloud-Based</option>
                      <?php else:?>
                        <option value="local">Local</option>
                        <option value="cloud" selected>Cloud-Based</option>
                      <?php endif?>
                    </select>
                    <label for="expiry">Expiry of License/Subscription:</label>
                    <input class="form-control form-control-sm" id="expiry" name="expiry" type="date" value="<?=$row['date']?>"/>
                    <button class="btn btn-block btn-lg btn-primary" type="submit">Update Entry</button>
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