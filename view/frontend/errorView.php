<?php $title = "Erreur"; ?>

<?php ob_start(); ?>

<div class="p-2 mt-5 rounded align-items-center shadow">
	<p class=""><?= $error ?></p>
	<?php if (isset($_SESSION['redirection']) && $_SESSION['redirection'] != ''): ?>
	<a href="<?= $_SESSION['redirection'] ?>" class="btn btn-light btn-sm my-1" role="button">Retourner sur la page</a> 
	<?php $_SESSION['redirection'] = ''; ?>
	
	<?php else: ?>
	<a href="index.php" class="btn btn-light btn-sm my-1" role="button">Retourner à l'accueil</a>
	<?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>