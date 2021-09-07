<?php
$title = "contact";
require_once('./template/header.php');

function filterString($field)
{
      $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
      if (empty($field)) {
            return false;
      } else {
            return $field;
      }
}

function filterEmail($field)
{
      $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);

      if (filter_var($field, FILTER_VALIDATE_EMAIL)) {

            return $field;
      } else {
            return false;
      }
}


/* errors message */
$nameErr = $EmailErr = $fileErr = $messageErr = '';
$name = $email = $message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $name = filterString($_POST['name']);
      if (!$name) {
            $nameErr = "name is required";
      }

      $email = filterEmail($_POST['email']);
      if (!$email) {
            $EmailErr = "email is invalid";
      }

      $message = filterString($_POST['message']);
      if (!$message) {
            $messageErr = "message is required";
      }








      if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $allowedFiles = [
                  'jpg' => 'image/jpeg',
                 // 'png' => 'image/png',
                  'gif' => 'image/gif'
            ];

            $MaxFileSize = 10 * 1025;

            $fileType = mime_content_type($_FILES['file']['tmp_name']);
            $fileSize = $_FILES['file']['size'];

            if (!in_array($fileType, $allowedFiles)) {
                  $fileErr= 'file type not support 🧐';
            }
            if ($fileSize > $MaxFileSize) {
                  $fileErr= "file size is big 🤯 Max size is" . $MaxFileSize;
            }
      }
}






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