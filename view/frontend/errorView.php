<?php $title = "Erreur"; ?>

<?php ob_start(); ?>

<div class="bg-blue-2 p-2 mt-5 rounded align-items-center">
	<p class=""><?= $error ?></p>
	<?php  
	// $_SESSION['redirection'] permet de choisir ou rediriger l'utilisateur arpès une erreur
	if (isset($_SESSION['redirection']) && $_SESSION['redirection'] != '') {
		?><a href="<?= $_SESSION['redirection'] ?>" class="btn btn-outline-light btn-sm my-1" role="button">Retourner sur la page</a><?php 
		// $_SESSION['redirection'] est ensuite vidé 
		$_SESSION['redirection'] = '';
	}
	else
	{
		?><a href="index.php" class="btn btn-outline-light btn-sm my-1" role="button">Retourner à l'accueil</a><?php
	}
	?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>