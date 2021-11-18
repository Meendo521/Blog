<?php
require_once "Includes/DB.php";
?>

<?php
function Redirect_to($New_Location)
{
  header("Location:" . $New_Location);
  exit;
}
function CheckUserNameExistOrNot($Username)
{
  global $ConnectingDB;
  $sql = "SELECT  username  FROM admins WHERE username=:userName";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName', $Username);
  $stmt->execute();
  $Result = $stmt->rowCount();
  if ($Result == 1) {
    return true;
  } else {
    return false;
  }
}
function Login_Attempt($UserName, $Password)
{
  global $ConnectingDB;
  $sql = "SELECT * FROM admins WHERE username=:userName AND password=:password  LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName', $UserName);
  $stmt->bindValue(':password', $Password);
  $stmt->execute();
  $Result = $stmt->rowCount();
  if ($Result == 1) {
    return $Found_Account = $stmt->fetch();
  } else {
    return null;
  }
}

function Confirm_Login()
{
  if (isset($_SESSION["UserId"])) {
    return true;
  } else {
    $_SESSION["ErrorMessage"] = "Login Required !";
    Redirect_to("Login.php");
  }
}

function TotalPost()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM posts";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalPost = array_shift($TotalRows);
  echo $TotalPost;
}

function TotalCategories()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM category";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalCategories = array_shift($TotalRows);
  echo $TotalCategories;
}

function TotalAdmins()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM admins";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalAdmins = array_shift($TotalRows);
  echo $TotalAdmins;
}

function TotalComments()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM comments";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalComments = array_shift($TotalRows);
  echo $TotalComments;
}

function ApproveCommentPerPost($PostId)
{
  global $ConnectingDB;
  $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
  $stmtApprove = $ConnectingDB->query($sqlApprove);
  $RowsTotal = $stmtApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}

function DisApproveCommentPerPost($PostId)
{
  global $ConnectingDB;
  $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
  $stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
  $RowsTotal = $stmtDisApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}
?>