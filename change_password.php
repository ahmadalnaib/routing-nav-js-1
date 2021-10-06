<?php
$title = "new password";
require_once('./template/header.php');
require_once('./config/db.php');

if (isset($_SESSION['logged_in'])) {
  header('location:index.php');
}


if (!isset($_GET['token']) || !$_GET['token']) {
  die('Token is missing');
}

$now = date('Y-m-d H:i:s');

$stmt = $mysqli->prepare("select * from password_resets where token=? and expires_at > '$now'");
$stmt->bind_param('s', $token);
$token = $_GET['token'];
$stmt->execute();
$result = $stmt->get_result();

if (!$result->num_rows) {
  die('token is not valid');
}

$errors = [];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $password = mysqli_real_escape_string($mysqli, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($mysqli, $_POST['confirm_password']);


  if (empty($password)) {
    array_push($errors, "Password is required");
  }
  if (empty($confirm_password)) {
    array_push($errors, "Password confirm is required");
  }

  if ($password !== $confirm_password) {
    array_push($errors, "Password  not match");
  }




  if (!count($errors)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $userId = $result->fetch_assoc()['user_id'];
    $mysqli->query("update users set password= '$hashed_password' where id='$userId'");
    $mysqli->query("delete from password_restes where user_id='$userId'");
    $_SESSION['success_message'] = 'your password has been changed';
    header('location:login.php');
    die();
  }
}
?>







<div class="content">
  <div class="container-form">
    <?php include './template/errors.php' ?>
    <h1>Fill in your new password </h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

      <div>
        <input type="password" name="password" placeholder="New Password">
      </div>
      <div>
        <input type="password" name="confirm_password" placeholder="Confirm Password">
      </div>

      <button class="btn-primary">Change Password</button>
    </form>
  </div>
</div>






<?php require_once('./template/footer.php') ?>