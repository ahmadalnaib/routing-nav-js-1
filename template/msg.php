<?php if(isset($_SESSION['success_message'])):?>

<div>
<?php
 echo $_SESSION['success_message'] ;
 unset($_SESSION['success_message']);
 ?>
</div>

<?php endif ?>
