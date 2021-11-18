<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";

?>

<?php Confirm_Login(); ?>
<?php
$SearchQueryParameter = $_GET['id'];
// Fetching Existing Content according to our post

global $ConnectingDB;
$sql  = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $TitleToBeDeleted    = $DataRows['title'];
  $CategoryToBeDeleted = $DataRows['category'];
  $ImageToBeDeleted    = $DataRows['image'];
  $PostToBeDeleted     = $DataRows['post'];
  // code...

}

if (isset($_POST["Submit"])) {
  //Query to Delete into posts in DB when everything is fine
  $ConnectingDB;
  $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
  $Execute = $ConnectingDB->query($sql);
  if ($Execute) {
    $Target_Path_To_DELETE_Image = "Uploads/$ImageToBeDeleted";
    unlink($Target_Path_To_DELETE_Image);
    $_SESSION["SuccessMessage"] = "Post deleted Successfully";
    Redirect_to("Posts.php");
  } else {
    $_SESSION["ErrorMessage"] = "Something went wrong.Try Again !";
    Redirect_to("Posts.php");
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DeletePost - Advance CMS System</title>
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
          <li class="nav-item ">
            <a class="nav-link" href="Categories.php">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="Admins.php">Manage Admins</a>
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
          <h1><i class="fas fa-edit" style="background: #27aae1;"></i> DELETE POSTS</h1>
        </div>
      </div>
    </div>
  </header>
  <!--END OF HEADER-->
  <!--MAIN AREA-->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class=" offset-lg-1 col-lg-10" style="min-height: 480px">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form method="post" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" enctype="multipart/form-data">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="PostTitle"> <span class="FieldInfo">Post Title:</span> </label>
                <input disabled tabindex="-1" class="form-control" type="text" name="PostTitle" id="PostTitle" placeholder="Type title here" value="<?php echo $TitleToBeDeleted; ?>">
              </div>
              <div class="form-group">
                <span class="FieldInfo">Existing Category:</span>
                <?php echo $CategoryToBeDeleted; ?>
                <br />
              </div>
              <div class="form-group">
                <span class="FieldInfo">Existing Image:</span>
                <img class="img-fluid mb-1" src="Uploads/<?php echo $ImageToBeDeleted; ?>" width="170px;" height="70px;">
              </div>
              <div class="form-group">
                <label for="Post"> <span class="FieldInfo">Post:</span> </label>
                <textarea disabled tabindex="-1" class="form-control" name="PostDescription" id="Post" cols="80" rows="8" placeholder="Type Your Post Here">
                <?php echo $PostToBeDeleted; ?>
                </textarea>
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-warning  btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button type="submit" class="btn btn-danger btn-block" name="Submit"> <i class="fas fa-trash"></i> Delete</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!--END MAIN AREA-->
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