<?php
$title = "Register";
require_once('./template/header.php');
require_once('./config/db.php');

if(isset($_SESSION['logged_in'])){
      header('location:index.php');
}

$errors = [];
$name = "";
$email = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = mysqli_real_escape_string($mysqli, $_POST['name']);
      $email = mysqli_real_escape_string($mysqli, $_POST['email']);
      $password = mysqli_real_escape_string($mysqli, $_POST['password']);
      $confirm_password = mysqli_real_escape_string($mysqli, $_POST['confirm_password']);


      if (empty($email)) {
            array_push($errors, "Email is required");
      }
      if (empty($name)) {
            array_push($errors, "Name is required");
      }
      if (empty($password)) {
            array_push($errors, "Password is required");
      }
      if (empty($confirm_password)) {
            array_push($errors, "Password  not match");
      }

      if (!count($errors)) {

            $userExists = $mysqli->query("select id,email from users where email='$email' limit 1");

            if ($userExists->num_rows) {
                  array_push($errors, "Email already register");
            }
      }

      if (!count($errors)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users(email,name,password)
                    values ('$email','$name','$password')";
            $mysqli->query($query);

            $_SESSION['logged_in']=true;
            $_SESSION['user_id']=$mysqli->insert_id;
            $_SESSION['user_name']=$name;
            $_SESSION['success_message']=" welcome with us $name";
            header('location:index.php');
      }
}
?>







<div class="content">
      <div class="container-form">
            <?php include './template/errors.php' ?>
            <h1>Register </h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                  <div>
                        <input type="text" name="name" placeholder="Name" value="<?= $name; ?>">

                  </div>
                  <div>
                        <input type="email" name="email" placeholder="Email" value="<?= $email ?>">

                  </div>
                  <div>
                        <input type="password" name="password" placeholder="Password">

                  </div>

                  <div>
                        <input type="password" name="confirm_password" placeholder="Confirm password">

                  </div>




                  <button class="btn-primary">Register</button>
            </form>
      </div>
</div>






<?php require_once('./template/footer.php') ?>