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

  $email = mysqli_real_escape_string($mysqli, $_POST['email']);




  if (empty($email)) {
    array_push($errors, "Email is required");
  }




  if (!count($errors)) {

    $userExists = $mysqli->query("select id,email from users where email='$email' limit 1");

    if ($userExists->num_rows) {



      $userId = $userExists->fetch_assoc()['id'];

      $tokenExists = $mysqli->query("delete from password_resets where user_id='$userId'");
      $token = bin2hex(random_bytes(16));
      $expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));
      $mysqli->query("insert into password_resets (user_id,token,expires_at)
      values('$userId','$token','$expires_at');
      ");
    }
    $_SESSION['success_message'] = "please check your email for reset link";
    header('location:password_reset.php');
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