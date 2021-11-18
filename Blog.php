<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog - Advance CMS System</title>
  <link rel="stylesheet" href="bootstrap4/css/bootstrap.min.css" />
  <script src="fontawesom5/js/all.js"></script>
  <link rel="stylesheet" href="Css/style.css" />
  <style>
    .heading {
      font-family: Bitter, Georgia, "Times New Roman", Times, serif;
      font-weight: bold;
      color: #005e90;
    }

    .heading:hover {
      color: #0090db;
    }
  </style>
</head>

<body>
  <!--NAVABAR-->
  <div style="height: 10px; background: #27aae1;"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#0">MEENTYCOON.COM</a>
      <button class="navbar-toggler" data-target="#navbarcollapseCMS" data-toggle="collapse" aria-controls="navbarcollapseCMS" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarcollapseCMS" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="Blog.php">Home<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Blog.php">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <form class="form-inline d-none d-sm-block" action="Blog.php">
            <div class="form-group">
              <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
              <button class="btn btn-primary" name="SearchButton">Search</button>
            </div>
          </form>
        </ul>
      </div>
    </div>
  </nav>
  <div style="height: 10px; background: #27aae1;"></div>
  <!--END OF NAVBAR-->
  <!--HEADER-->
  <div class="container">
    <div class="row mt-4">
      <div class="col-sm-8">
        <h1>The Complete Responsive CMS Blog</h1>
        <p class="lead">The Complete blog by using PHP by Meen Tycoon</p>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <?php
        global $ConnectingDB;
        // SQL query when Searh button is active
        if (isset($_GET["SearchButton"])) {
          $Search = $_GET["Search"];
          $sql = "SELECT * FROM posts
            WHERE datetime LIKE :search
            OR title LIKE :search
            OR category LIKE :search
            OR post LIKE :search";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':search', '%' . $Search . '%');
          $stmt->execute();
        } // Query When Pagination is Active i.e Blog.php?page=1
        elseif (isset($_GET["page"])) {
          $Page = $_GET["page"];
          if ($Page == 0 || $Page < 1) {
            $ShowPostFrom = 0;
          } else {
            $ShowPostFrom = ($Page * 4) - 4;
          }
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,4";
          $stmt = $ConnectingDB->query($sql);
        }
        // Query When Category is active in URL Tab
        elseif (isset($_GET["category"])) {
          $Category = $_GET["category"];
          $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
          $stmt = $ConnectingDB->query($sql);
        }

        // The default SQL query
        else {
          $sql  = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
          $stmt = $ConnectingDB->query($sql);
        }
        while ($DataRows = $stmt->fetch()) {
          $PostId          = $DataRows["id"];
          $DateTime        = $DataRows["datetime"];
          $PostTitle       = $DataRows["title"];
          $Category        = $DataRows["category"];
          $Admin           = $DataRows["author"];
          $Image           = $DataRows["image"];
          $PostDescription = $DataRows["post"];
        ?>
          <div class="card">
            <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
            <div class="card-body">
              <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
              <small class="text-muted">Category: <span class="text-dark"> <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a></span> & Written by <span class="text-dark"> <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
              <span class="badge badge-dark text-light float right">Comments:
                <?php echo ApproveCommentPerPost($PostId); ?>
              </span>
              <hr>
              <p class="card-text">
                <?php if (strlen($PostDescription) > 150) {
                  $PostDescription = substr($PostDescription, 0, 150) . "...";
                }
                echo htmlentities($PostDescription); ?></p>
              <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                <span class="btn btn-info">Read More &rang;&rang; </span>
              </a>
            </div>
          </div>
        <?php } ?>
        <!-- Pagination -->
        <nav>
          <ul class="pagination mt-3">
            <!-- Creating Backward Button -->
            <?php if (isset($Page)) {
              if ($Page > 1) { ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
                </li>
            <?php }
            } ?>
            <?php
            global $ConnectingDB;
            $sql           = "SELECT COUNT(*) FROM posts";
            $stmt          = $ConnectingDB->query($sql);
            $RowPagination = $stmt->fetch();
            $TotalPosts    = array_shift($RowPagination);
            // echo $TotalPosts."<br>";
            $PostPagination = $TotalPosts / 4;
            $PostPagination = ceil($PostPagination);
            // echo $PostPagination;
            for ($i = 1; $i <= $PostPagination; $i++) {
              if (isset($Page)) {
                if ($i == $Page) {  ?>
                  <li class="page-item active">
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>
                <?php
                } else {
                ?> <li class="page-item">
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>
            <?php  }
              }
            } ?>
            <!-- Creating Forward Button -->
            <?php if (isset($Page) && !empty($Page)) {
              if ($Page + 1 <= $PostPagination) { ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
                </li>
            <?php }
            } ?>
          </ul>
        </nav>
      </div>
      <div class="col-sm-4">
        <div class="card mt-4 shadow-lg border-light">
          <div class="card-body">
            <img class="img-fluid d-blockmb-3" src="images/startblog.png">
            <div class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi beatae libero exercitationem ratione rem. Ratione, id corrupti tenetur voluptates, enim nemo non reiciendis minima magnam voluptatum, dignissimos culpa? Voluptatem at minus, quasi culpa sapiente maiores commodi, nihil dicta, eligendi voluptas debitis earum dolor atque sunt tempore hic et eos? Dignissimos!</div>
          </div>
        </div>
        <br>
        <div class="card shadow-lg border-dark">
          <div class="card-header bg-dark text-white">
            <h2 class="lead text-center"> Sing Up !</h2>
          </div>
          <div class="card-body">
            <button type="button" class="btn btn-sm btn-success btn-block text-center text-white mb-4" name="">Join The Forum</button>
            <button type="button" class="btn btn-sm btn-danger btn-block text-center text-white mb-4" name="">Login</button>
            <div class="input-group mb-3">
              <input class="form-control" type="email" name="" placeholder="Enter your Email" value="">
              <div class="input-group-append">
                <button type="button" class="btn btn-primary btn-sm text-center text-white">Subscribe Now</button>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="card shadow-lg border-primary">
          <div class="card-header bg-primary text-light">
            <h2 class="lead">Categories</h2>
          </div>
          <div class="card-body">
            <?php
            global $ConnectingDB;
            $sql = "SELECT * FROM category ORDER BY id desc";
            $stmt = $ConnectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
              $CategoryId = $DataRows["id"];
              $CategoryName = $DataRows["title"];
            ?>
              <a href="Blog.php?category=<?php echo htmlentities($CategoryName); ?>"> <span class="heading"> <?php echo htmlentities($CategoryName); ?></span> </a><br>
            <?php } ?>
          </div>
        </div>
        <br>
        <div class="card shadow-lg border-info">
          <div class="card-header bg-info text-white">
            <h2 class="lead"> Recent Posts</h2>
          </div>
          <div class="card-body">
            <?php
            global $ConnectingDB;
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
            $stmt = $ConnectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
              $Id     = $DataRows['id'];
              $Title  = $DataRows['title'];
              $DateTime = $DataRows['datetime'];
              $Image = $DataRows['image'];
            ?>
              <div class="media">
                <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                <div class="media-body ml-2">
                  <a style="text-decoration:none;" href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
                    <h6 class="lead"><?php echo htmlentities($Title); ?></h6>
                  </a>
                  <p class="small"><?php echo htmlentities($DateTime); ?></p>
                </div>
              </div>
              <hr>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!--END OF HEADER-->
  <br />
  <!--FOOTER-->
  <!-- <div style="height: 10px; background: #27aae1;"></div> -->
  <footer class="small bg-dark text-white">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <p class="lead text-center">Theme By | Meen Tycoon | <span id="year"></span> &copy; ---- All Rights Reserves</p>
          <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos accusantium, esse velit quam ratione eum laborum itaque natus officia fugit molestias error sequi incidunt laboriosam rerum vel inventore temporibus aspernatur facere modi repellendus deleniti? Fugiat cumque molestias officia error sequi maiores doloribus ex eligendi neque corporis architecto pariatur sapiente ipsam, molestiae dolorem ipsa. Sequi consectetur tempora aliquam cum natus ut?</p>
        </div>
      </div>
    </div>
  </footer>
  <!--END OFFOOTER-->
  <div style="height: 10px; background: #27aae1;"></div>
  <script src="bootstrap4/js/jquery-3.5.1.min.js"></script>
  <script src="bootstrap4/js/bootstrap.bundle.min.js"></script>
  <script>
    $("#year").text(new Date().getFullYear());
  </script>
</body>

</html>