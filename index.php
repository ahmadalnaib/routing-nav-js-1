<?php
$title = "Home";
require_once('./template/header.php');


// database
$mysqli=new mysqli("localhost",'root','','2022');
if($mysqli->connect_error){
  die('no coneect' .$mysqli->connect_error);
}

$projects=$mysqli->query("SELECT * FROM projects order by created_at")->fetch_all(MYSQLI_ASSOC);
?>
<div class="content">
  <?php foreach($projects as $project): ?>
    <img src="<?php echo $config['app_url'].$project['image'] ?>" alt="">
    <h1><?php echo $project['name'] ?></h1>
    <p><?php echo $project['description'] ?></p>
 

    <?php endforeach ?>
</div>

<?php require_once('./template/footer.php') ?>