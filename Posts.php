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
  <title>Posts - Advance CMS System</title>
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
          <li class="nav-item">
            <a class="nav-link" href="Dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item active">
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
          <h1><i class="fas fa-blog" style="color: #27aae1;"></i> Blog Posts</h1>
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
      <div class="col-lg-12">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <div class="table-responsive">
          <table class="table table-light table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Category</th>
                <th scope="col">Date&Time</th>
                <th scope="col">Author</th>
                <th scope="col">Banner</th>
                <th scope="col">Comments</th>
                <th scope="col">Action</th>
                <th scope="col">Live Preview</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $ConnectingDB;
              $sql = "SELECT * FROM posts";
              $stmt = $ConnectingDB->query($sql);
              $sr = 0;
              while ($DataRows = $stmt->fetch()) {
                $Id = $DataRows["id"];
                $DataTime = $DataRows["datetime"];
                $PostTitle = $DataRows["title"];
                $Category = $DataRows["category"];
                $Admin = $DataRows["author"];
                $Image = $DataRows["image"];
                $PostText = $DataRows["post"];
                $sr++;

              ?>
                <tr class="text-center">
                  <th scope="row"><?php echo $sr; ?></th>
                  <td>
                    <?php
                    if (strlen($PostTitle) > 20) {
                      $PostTitle = substr($PostTitle, 0, 18) . "...";
                    }
                    echo $PostTitle;
                    ?>
                  </td>
                  <td>
                    <?php
                    if (strlen($Category) > 8) {
                      $Category = substr($Category, 0, 8) . '...';
                    }
                    echo $Category;
                    ?>
                  </td>
                  <td>
                    <?php
                    if (strlen($DataTime) > 11) {
                      $DataTime = substr($DataTime, 0, 11) . '...';
                    }
                    echo $DataTime;
                    ?>
                  </td>
                  <td>
                    <?php
                    if (strlen($Admin) > 6) {
                      $Admin = substr($Admin, 0, 6) . "...";
                    }
                    echo $Admin;
                    ?>
                  </td>
                  <td><img class="img-fluid" src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px;"></td>
                  <td>
                    <?php
                    $Total = ApproveCommentPerPost($Id);
                    if ($Total > 0) {
                    ?>
                      <span class="badge badge-success">
                        <?php
                        echo $Total; ?>
                      </span>
                    <?php } ?>

                    <?php
                    $Total = DisApproveCommentPerPost($Id);
                    if ($Total > 0) {
                    ?>
                      <span class="badge badge-danger">
                        <?php
                        echo $Total; ?>
                      </span>
                    <?php } ?>
                  </td>
                  <td colspan="1">
                    <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning mb-2">Edit</span></a>
                    <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger mb-2">Delete</span></a>
                  </td>
                  <td>
                    <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary  btn-sm">Live Preview</span></a>
                  </td>
                </tr>
            </tbody>
          <?php } ?>
          </table>
        </div>
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