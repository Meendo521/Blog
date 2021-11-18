<?php
require_once "Includes/DB.php";
require_once "Includes/function.php";
require_once "Includes/session.php";
?>
<?php
if (isset($_GET["id"])) {
  $SearchQueryParameter = $_GET["id"];
  global $ConnectingDB;
  $Sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
  $Execute = $ConnectingDB->query($Sql);

  if ($Execute) {
    $_SESSION["SuccessMessage"] = "Category Deleted Successfully !";
    Redirect_to("Categories.php");
  } else {
    $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
    Redirect_to("Categories.php");
  }
}

?>