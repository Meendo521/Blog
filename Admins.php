<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";
?>

<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
  $Username = $_POST["Username"];
  $Name = $_POST["Name"];
  $Password = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];
  $Admin = $_SESSION["UserName"];
  date_default_timezone_set("Africa/Nairobi");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
  if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    Redirect_to("Admins.php");
  } elseif (strlen($Password) < 4) {
    $_SESSION["ErrorMessage"] = "Password should be greater than 4 characters";
    Redirect_to("Admins.php");
  } elseif (strlen($Password !== $ConfirmPassword)) {
    $_SESSION["ErrorMessage"] = "Password and ConfirmPassword should match";
    Redirect_to("Admins.php");
  } elseif (CheckUserNameExistOrNot($Username)) {
    $_SESSION["ErrorMessage"] = "Username Exist Please Try Another!!";
    Redirect_to("Admins.php");
  } else {
    //Query to insert into new admins in DB when everything is fine
    $ConnectingDB;
    $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
    $sql .= "VALUES(:dateTime,:userName,:password,:aName,:adminName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':userName', $Username);
    $stmt->bindValue(':password', $Password);
    $stmt->bindValue(':aName', $Name);
    $stmt->bindValue(':adminName', $Admin);
    $Execute = $stmt->execute();

    if ($Execute) {
      $_SESSION["SuccessMessage"] = "New Admin by the name: {$Username} is Added Successfully";
      Redirect_to("Admins.php");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong.Try Again !";
      Redirect_to("Admins.php");
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admins - Advance CMS System</title>
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
          <li class="nav-item">
            <a class="nav-link" href="Posts.php">Posts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Categories.php">Categories</a>
          </li>
          <li class="nav-item active">
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
          <h1><i class="fas fa-user" style="background: #27aae1;"></i> MANAGE ADMINS</h1>
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
        <form method="post" action="Admins.php" novalidate class="was-validated">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header">
              <h1>Add New Admins</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="username"> <span class="FieldInfo">Username:</span> </label>
                <input class="form-control" type="text" name="Username" id="username" required>
              </div>
              <div class="form-group">
                <label for="name"> <span class="FieldInfo">Name:</span> </label>
                <input class="form-control" type="text" name="Name" id="name" required>
                <span class="text-muted">*Optional</span>
              </div>
              <div class="form-group">
                <label for="Password"> <span class="FieldInfo">Password:</span> </label>
                <input class="form-control" type="password" name="Password" id="Password" required>
              </div>
              <div class="form-group">
                <label for="ConfirmPassword"> <span class="FieldInfo">Confirm Password:</span> </label>
                <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" required>
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button type="submit" class="btn btn-success btn-block" name="Submit"><i class="fas fa-check"></i>Publish</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <h2 class="text-center">Existing Admins</h2>
        <div class="table-responsive">
          <table class="table table-light table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">No.</th>
                <th scope="col">Date&Time</th>
                <th scope="col">Username</th>
                <th scope="col">Admin Name</th>
                <th scope="col">Added by</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <?php
            global $ConnectingDB;
            $sql = "SELECT * FROM admins ORDER BY id desc";
            $Execute = $ConnectingDB->query($sql);
            $SrNo = 0;
            while ($DataRows = $Execute->fetch()) {
              $AdminId = $DataRows["id"];
              $DateTime = $DataRows["datetime"];
              $AdminUserName = $DataRows["username"];
              $AdminName = $DataRows["aname"];
              $AddedBy = $DataRows["addedby"];
              $SrNo++;

            ?>
              <tbody>
                <tr>
                  <th scope="row"><?php echo htmlentities($SrNo); ?></th>
                  <td><?php echo htmlentities($DateTime); ?></td>
                  <td><?php echo htmlentities($AdminUserName); ?></td>
                  <td><?php echo htmlentities($AdminName); ?></td>
                  <td><?php echo htmlentities($AddedBy); ?></td>
                  <td> <a class="btn btn-danger" href="DeleteAdmin.php?id=<?php echo $AdminId; ?>">Delete</a> </td>
                </tr>
              </tbody> <?php  } ?>
          </table>
        </div>
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