<!DOCTYPE html>
<html>
     <!-- CSS pour espace public -->
<link rel="stylesheet" href= "static/css/public_styling.css">
	<meta charset="UTF-8">
    <?php require_once('includes/head_section.php') ?>

    <!-- navbar -->
		<?php 
         include('includes/navbar.php') ?>
		<!-- // navbar -->
        <div class="post" style="margin-left: 0px;">
       
    <body>
    
        <?= $content ?>
    </body>
    <!-- footer -->
		<?php include('includes/footer.php') ?>
</html>
