<div class="footer">

  © Copyright © 2023 - Site réalisé par Ibtissem Ben Hammouda
    <a class="text-dark" href="https://www.linkedin.com/in/ibtissem-ben-hammouda-b0027653/?originalSubdomain=fr">Linkedin   <?php echo date('Y'); ?></a>
   
    <!-- si le user est connecté on vérifie s'il a le role admin alos on affiche le bouton admin Page -->
    <?php if (isset($loggedUser)) {?>
          <?php  if ( $_SESSION['user']['role'] == "admin") : ?>
              <a class ="admin_btn" href="<?php echo BASE_URL . '/admin/dashboard.php' ?>" > Admin page</a>
              <!-- si pas de connection on n'affiche pas le bouton fouter -->
         <?php elseif (!isset($loggedUser)):?>

          <?php endif ?>
          
      <?php } ?> 
   </div>
