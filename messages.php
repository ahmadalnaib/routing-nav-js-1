<?php
$title="messages";
require_once('./template/header.php');
require_once('./config/db.php');

$messages=$mysqli->query("SELECT * FROM messages order by id")->fetch_all(MYSQLI_ASSOC);

?>

<table  id="customers">
  <tr>
    <th>id</th>
    <th>Name</th>
    <th>email</th>
    <th>file</th>
    <th>message</th>
  </tr>
  <?php foreach($messages as $message): ?>
  <tr>
    <td><?php echo $message['id'] ?></td>
    <td><?php echo $message['name'] ?></td>
    <td><?php echo $message['email'] ?></td>
    <td><?php echo $message['file'] ?></td>
    <td><?php echo $message['message'] ?></td>
    
  </tr>
 <?php endforeach; ?>
</table> 


<?php require_once('./template/footer.php') ?>

