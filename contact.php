<?php
$title = "contact";
require_once('./template/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $allowedFiles = [
                  'jpg' => 'image/jpeg',
                  'png' => 'image/png',
                  'gif' => 'image/gif'
            ];

            $fileType = mime_content_type($_FILES['file']['tmp_name']);

            if (!in_array($fileType, $allowedFiles)) {
                  echo 'file type not support';

            }
      }
}






?>
<div class="content">
      <div class="container-form">
            <h1>Contact us</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                  <div>
                        <input type="text" placeholder="Name">
                  </div>
                  <div>
                        <input type="email" placeholder="Email">
                  </div>
                  <div>
                        <input type="file" name="file">
                  </div>
                  <div>
                        <textarea name="message" id="" cols="30" rows="10" placeholder="Message"></textarea>
                  </div>
                  <button class="btn-primary">Send</button>
            </form>
      </div>
</div>

<?php require_once('./template/footer.php') ?>