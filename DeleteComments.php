<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";
?>
<?php
if (isset($_GET["id"])) {
  $SearchQueryParameter = $_GET["id"];
  global $ConnectingDB;
  $Sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
  $Execute = $ConnectingDB->query($Sql);

  if ($Execute) {
    $_SESSION["SuccessMessage"] = "Comments Deleted Successfully !";
    Redirect_to("Comments.php");
  } else {
    $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
    Redirect_to("Comments.php");
  }
}

?>