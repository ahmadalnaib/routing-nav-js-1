<?php
$title = "contact";
require_once('./template/header.php');
require_once('./includes/uploader.php');




$services=$mysqli->query("SELECT id,name FROM services")->fetch_all(MYSQLI_ASSOC);

?>
<div class="content">
      <div class="container-form">
            <h1>Contact us</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                  <div>
                        <input type="text" name="name" placeholder="Name" value="<?php echo $name ?>">
                        <span class="text-danger"><?php echo $nameErr ?></span>
                  </div>
                  <div>
                        <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
                        <span class="text-danger"><?php echo $EmailErr ?></span>
                  </div>
                  <div>
                        <input type="file" name="file">
                        <span class="text-danger"><?php echo $fileErr ?></span>
                  </div>
                  <div>
                      <select name="services" id="services">
                            <?php foreach($services as $service): ?>
                            <option value="<?php echo $service['id'] ?>">
                             <?php echo $service['name'] ?>
                            </option>
                            <?php endforeach ?>
                      </select>
                  </div>
                  <div>
                        <textarea name="message" id="message" cols="30" rows="10" placeholder="Message">
                              <?php echo $message; ?>
                        </textarea>
                        <span class="text-danger"><?php echo $messageErr ?></span>
                  </div>
                  <button class="btn-primary">Send</button>
            </form>
      </div>
</div>

<?php require_once('./template/footer.php') ?>