<?php
$title = "Home";
require_once('./template/header.php');
require_once('./config/db.php');



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