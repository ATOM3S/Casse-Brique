<?php 
$title = 'Casse-Brique'; 
$description = 'Bienvenue sur le Casse-Brique ! Créez vous un compte et essayez de battre les meilleurs scores !';
?>

<?php ob_start(); ?>
<section class="row justify-content-center pt-5">
    <div id="myCanvas"></div>
    <script src="public/js/brickBreaker.js"></script>
</section>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?> 