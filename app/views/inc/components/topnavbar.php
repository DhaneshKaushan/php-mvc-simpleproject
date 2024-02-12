<div class="topnav">
  <a class="active" href="#home">Home</a>
  <?php if(!isset($_SESSION['user_id'])):?>
  <a href="<?php echo URLROOT?>/Users/login">Login</a>
  <a href="<?php echo URLROOT?>/Users/register">Register</a>
  <?php else: ?>
  <a href="<?php echo URLROOT?>/Users/logout">Log out</a>
  <?php endif; ?>
  <!-- <a href="#about">Logout</a> -->
</div>
