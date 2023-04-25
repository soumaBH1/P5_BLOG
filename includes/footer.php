<div class="footer">

  © Copyright © 2023 - Site réalisé par Ibtissem Ben Hammouda
    <a class="text-dark" href="https://www.linkedin.com/in/ibtissem-ben-hammouda-b0027653/?originalSubdomain=fr">Linkedin   <?php echo date('Y'); ?></a>
    <!-- si pas de connection on n'affiche pas le bouton fouter -->
    <?php if (!isset($loggedUser)):?>
    <?php else: ?> <!-- si le user est connecté on vérifie si il a le role admin alos on affiche le bouton admin page -->
       <?php  if ( $_SESSION['user']['role'] == "Admin"): ?>
        <a class ="admin_btn" href="<?php echo BASE_URL . '/admin/dashboard.php' ?>" > Admin page</a>
      
        <?php endif ?>
        <?php endif ?>
  </div>
