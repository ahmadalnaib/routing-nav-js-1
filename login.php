<?php
$title = "Login";
require_once('./template/header.php');
require_once('./config/db.php');

if(isset($_SESSION['logged_in'])){
      header('location:index.php');
}

$errors = [];
$email = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
      $email = mysqli_real_escape_string($mysqli, $_POST['email']);
      $password = mysqli_real_escape_string($mysqli, $_POST['password']);
     


      if (empty($email)) {
            array_push($errors, "Email is required");
      }
    
      if (empty($password)) {
            array_push($errors, "Password is required");
      }
    

      if (!count($errors)) {

            $userExists = $mysqli->query("select id,email,name,password from users where email='$email' limit 1");

            if (!$userExists->num_rows) {
                  array_push($errors, "user not exists");
            } else{
               $foundUser=$userExists->fetch_assoc();

               if(password_verify($password,$foundUser['password'])){
                      $_SESSION['logged_in']=true;
                      $_SESSION['user_id']=$foundUser['id'];
                      $_SESSION['user_name']=$foundUser['name'];
                      $_SESSION['success_message']=" welcome back $foundUser[name]";
                      header('location:index.php');

               } else{
                 array_push($errors,"email or password not right");
               }
               
            }
      }

      // if (!count($errors)) {
      //       $password = password_hash($password, PASSWORD_DEFAULT);
      //       $query = "INSERT INTO users(email,name,password)
      //               values ('$email','$name','$password')";
      //       $mysqli->query($query);

      //       $_SESSION['logged_in']=true;
      //       $_SESSION['user_id']=$mysqli->insert_id;
      //       $_SESSION['user_name']=$name;
      //       $_SESSION['success_message']=" welcome back $name";
      //       header('location:index.php');
      // }
}
?>







<div class="content">
      <div class="container-form">
            <?php include './template/errors.php' ?>
            <h1>Login </h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                  <div>
                        <input type="email" name="email" placeholder="Email" value="<?= $email ?>">

                  </div>
                  <div>
                        <input type="password" name="password" placeholder="Password">

                  </div>

                



                  <button class="btn-primary">Login</button>
            </form>
      </div>
</div>






<?php require_once('./template/footer.php') ?>