<?php
$title = "password reset";
require_once('./template/header.php');
require_once('./config/db.php');

if (isset($_SESSION['logged_in'])) {
  header('location:index.php');
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
      $changePasswordUrl = $config['app_url'] . 'change_password.php?token=' . $token;
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";

      $headers .= "From: " . $config['admin_email'] . "\r\n";
      'Reply-To:' . $config['admin_email'] . "\r\n";
      'X-Mailer: PHP/' . phpversion();

      $htmlMessage = '<html><body>';
      $htmlMessage .= '<p style="color:#ff0000;">' . $changePasswordUrl . '</p>';
      $htmlMessage .= '</body></html>';

      mail($email, 'password reset link', $htmlMessage, $headers);
    }
    $_SESSION['success_message'] = "please check your email for reset link";
    header('location:password_reset.php');
  }
}
?>







<div class="content">
  <div class="container-form">
    <?php include './template/errors.php' ?>
    <h1>Fill in your email to reset your password </h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

      <div>
        <input type="email" name="email" placeholder="Email">

      </div>

      <button class="btn-primary">Request password link</button>
    </form>
  </div>
</div>






<?php require_once('./template/footer.php') ?>