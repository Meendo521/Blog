<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";
?>
<?php
if (isset($_GET["id"])) {
  $SearchQueryParameter = $_GET["id"];
  global $ConnectingDB;
  $Admin = $_SESSION["AdminName"];
  $Sql = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
  $Execute = $ConnectingDB->query($Sql);

  if ($Execute) {
    $_SESSION["SuccessMessage"] = "Comments Approved Successfully !";
    Redirect_to("Comments.php");
  } else {
    $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
    Redirect_to("Comments.php");
  }
}

?>