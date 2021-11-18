<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";

?>

<?php
if (isset($_SESSION["UserId"])) {
  Redirect_to("Dashboard.php");
}

if (isset($_POST["Submit"])) {
  $UserName  = $_POST["Username"];
  $Password  = $_POST["Password"];
  if (empty($UserName) || empty($Password)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    Redirect_to("Login.php");
  } else {
    $Found_Account = Login_Attempt($UserName, $Password);
    if ($Found_Account) {
      $_SESSION["UserId"] = $Found_Account["id"];
      $_SESSION["UserName"] = $Found_Account["username"];
      $_SESSION["AdminName"] = $Found_Account["aname"];

      $_SESSION["SuccessMessage"] = "Welcome " . $_SESSION["AdminName"];
      if (isset($_SESSION["TrackingURL"])) {
        Redirect_to($_SESSION["TrackingURL"]);
      } else {
        Redirect_to("Dashboard.php");
      }
    } else {
      $_SESSION["ErrorMessage"] = "Wrong Password or Password";
      Redirect_to("Login.php");
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Advance CMS System</title>
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
      </div>
    </div>
  </nav>
  <div style="height: 10px; background: #27aae1;"></div>
  <!--END OF NAVBAR-->
  <!--HEADER-->
  <header class="bg-dark text-white py-3">
    <!--         <div class="container">
      <div class="row">
        <div class="col-md-12"></div>
      </div>
    </div> -->
  </header>
  <!--END OF HEADER-->
  <!-- MAIN AREA -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-sm-3 col-sm-6" style="min-height:450px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <div class="card bg-secondary text-light mt-5">
          <div class="card-header text-center">
            <h4>Wellcome Back !</h4>
          </div>
          <div class="card-body bg-dark">
            <form class="" action="Login.php" method="post">
              <div class="form-group">
                <label for="username"><span class="FieldInfo">Username:</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-info"> <i class="fas fa-user"></i> </span>
                  </div>
                  <input type="text" class="form-control" name="Username" id="username" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="password"><span class="FieldInfo">Password:</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-info"> <i class="fas fa-lock"></i> </span>
                  </div>
                  <input type="password" class="form-control" name="Password" id="password" value="">
                </div>
              </div>
              <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END MAIN AREA -->
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