<?php
    require('connect.php');

    //Current page number of results
    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }
    else{
      $page = 1;
    }

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
            <h1>Created Hardware</h1>
        </div>
      </div>
    </div>
  </header>

<<table class="table table-dark">
    <tbody>
        <tr>
            <th>Catalog ID:</th>
            <th>Serial Number:</th>
            <th>Make:</th>
            <th>Description:</th>
            <th>Cost:</th>
            <th>Notes:</th>
            <th>Possession:</th>
        </tr>

        <?php while($row = $statement2->fetch()):?>
        <tr>
            <td><?=$row['hardwareID']?></td>
            <td><?=$row['serialNum']?></td>
            <td><?=$row['make']?></td>
            <td><?=$row['description']?></td>
            <td><?=$row['cost']?></td>
            <td><?=$row['notes']?></td>
            <td><?=$row['assignedTo']?></td>
        </tr>
        <?php endwhile?>
    </tbody>
</table>

<!--Pagination implementation-->
<nav aria-label="Page navigation">
  <ul class="pagination">

  <?php if($page == 1):?>
      <li class="page-item disabled">
  <?php else:?>
      <li class="page-item enabled">
  <?php endif?>

      <a class="page-link" href="hardware.php?page=<?=$page-1?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item active"><a class="page-link" href="users.php?page=<?=$page?>"></a><?=$page?></li>
    <li class="page-item"><a class="page-link" href="users.php?page=<?=$page+1?>"></a><?=$page+1?></li>
    <li class="page-item">

    <?php if($page == $page_total):?>
      <li class="page-item disabled">
    <?php else:?>
        <li class="page-item enabled">
    <?php endif?>
      <a class="page-link" href="hardware.php?page=<?=$page+1?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>


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