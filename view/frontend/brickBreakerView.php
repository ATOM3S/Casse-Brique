<?php $title = 'Casse-Brique'; ?>

<?php ob_start(); ?>
<section class="">
    <div id="myCanvas"></div>
    <script src="public/js/brickBreaker.js"></script>
</section>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?> 