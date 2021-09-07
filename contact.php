<?php
$title = "contact";
require_once('./template/header.php');
?>
<div class="content">
      <div class="container-form">
            <h1>Contact us</h1>
            <form action="" method="post">
                  <div>
                        <input type="text" placeholder="Name">
                  </div>
                  <div>
                        <input type="email" placeholder="Email">
                  </div>
                  <div>
                        <input type="file"  name="file">
                  </div>
                  <div>
                      <textarea name="message" id="" cols="30" rows="10" placeholder="Message"></textarea>
                  </div>
            </form>
      </div>
</div>

<?php require_once('./template/footer.php') ?>