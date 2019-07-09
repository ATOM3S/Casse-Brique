<?php $title = "Mon Compte"; ?>

<?php ob_start(); ?>

<h1 class="text-center my-5"><u>Mon Compte</u></h1>
<h2 class="text-center my-5"><?= $_SESSION['username'] ?></h2>
<a href="index.php?action=changePassword">Changer le mot de passe</a>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>