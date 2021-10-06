</div>
<nav>
  <ul>
    <li><i class="fas fa-home"></i> <a href="<?= $config['app_url']?>index.php">Home</a></li>
    <li><i class="fas fa-envelope"> <a href="<?= $config['app_url'] ?>messages.php">Messages</a></i></li>
    <li><i class="fas fa-envelope"> <a href="<?= $config['app_url'] ?>contact.php">Contact</a></i></li>
   <?php if(!isset($_SESSION['logged_in'])): ?>

  
    <li> <a href="<?= $config['app_url'] ?>login.php">Login</a></li>
    <li> <a href="<?= $config['app_url'] ?>register.php">Register</a></li>

    <?php else: ?>
    <li><a href="#"><?= $_SESSION['user_name'] ?></a></li>
      <li> <a href="<?= $config['app_url'] ?>logout.php">Logout</a></li>
    <?php endif ?>
  </ul>
</nav>

<script src="js/app.js"></script>
</body>

</html>