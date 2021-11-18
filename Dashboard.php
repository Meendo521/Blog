<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";
?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Advance CMS System</title>
  <link rel="stylesheet" href="bootstrap4/css/bootstrap.min.css" />
  <script src="fontawesom5/js/all.js"></script>
  <link rel="stylesheet" href="Css/style.css" />
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
          <li class="nav-item ">
            <a class="nav-link" href="MyProfile.php"> <i class="fas fa-user text-success"></i> My Profile<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="Dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Posts.php">Posts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Categories.php">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Admins.php">Manage Admins</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Comments.php">Comments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Blog.php?page=1">Live Blog</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-danger" href="Logout.php"> <i class="fas fa-user-times"></i> LogOut</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div style="height: 10px; background: #27aae1;"></div>
  <!--END OF NAVBAR-->
  <!--HEADER-->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1><i class="fas fa-cog" style="color: #27aae1;"></i> Dashboard</h1>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="AddNewPost.php" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Add New Post</a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Categories.php" class="btn btn-info btn-block"><i class="fas fa-folder-plus"></i> Add New Category</a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Admins.php" class="btn btn-warning btn-block"><i class="fas fa-user-plus"></i> Add New Admin</a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Comments.php" class="btn btn-success btn-block"><i class="fas fa-check"></i> Approve Comments</a>
        </div>
      </div>
    </div>
  </header>
  <!--END OF HEADER-->
  <!--MAIN AREA-->
  <section class="container py-2 mb-2">
    <div class="row">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
      ?>
      <div class="col-lg-2 d-none d-md-block">
        <!-- Left side Area End-->
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Posts</h1>
            <h4 class="display-5"> <i class="fab fa-readme"></i>
              <?php htmlentities(TotalPost()); ?>
            </h4>
          </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Categories</h1>
            <h4 class="display-5"> <i class="fas fa-folder"></i>
              <?php htmlentities(TotalCategories()); ?>
            </h4>
          </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Admins</h1>
            <h4 class="display-5"> <i class="fas fa-users"></i>
              <?php htmlentities(TotalAdmins()); ?>
            </h4>
          </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Comments</h1>
            <h4 class="display-5"> <i class="fas fa-comments"></i>
              <?php echo htmlentities(TotalComments()); ?>
            </h4>
          </div>
        </div>
      </div>
      <div class="col-lg-10">
        <!-- Right side Area End-->
        <h1 class="text-center">Top Posts</h1>
        <table class="table table-light table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Title</th>
              <th scope="col">Date&Time</th>
              <th scope="col">Author</th>
              <th scope="col">Comments</th>
              <th scope="col">Details</th>
            </tr>
          </thead>
          <?php
          $SrNo = 0;
          global $ConnectingDB;
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
          $stmt = $ConnectingDB->query($sql);
          while ($DataRows = $stmt->fetch()) {
            $PostId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $Author = $DataRows["author"];
            $Title = $DataRows["title"];
            $SrNo++;
          ?>
            <tbody>
              <tr>
                <th scope="row"><?php echo htmlentities($SrNo); ?></th>
                <td><?php echo htmlentities($Title); ?></td>
                <td><?php echo htmlentities($DateTime); ?></td>
                <td><?php echo htmlentities($Author); ?></td>
                <td>
                  <?php
                  $Total = ApproveCommentPerPost($PostId);
                  if ($Total > 0) {
                  ?>
                    <span class="badge badge-success">
                      <?php
                      echo $Total; ?>
                    </span>
                  <?php } ?>

                  <?php
                  $Total = DisApproveCommentPerPost($PostId);
                  if ($Total > 0) {
                  ?>
                    <span class="badge badge-danger">
                      <?php
                      echo $Total; ?>
                    </span>
                  <?php } ?>
                </td>
                <td>
                  <a target="_blank" href="FullPost.php?id=<?php echo htmlentities($PostId); ?>">
                    <span class="btn btn-info">Preview</span></a>
                </td>
              </tr>
            </tbody>
          <?php  } ?>
        </table>
      </div>
    </div>
  </section>
  <!--END OF MAIN AREA-->
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