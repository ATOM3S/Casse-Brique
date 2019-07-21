<?php $title = "Nouveau mot de passe"; ?>

<?php ob_start(); ?>

<h1 class="text-center my-5"><u>Changer de mot de passe</u></h1>
<form class="p-4 rounded" action="index.php?action=resetPassword&id=<?=$_GET['id']?>&verif=<?=$_GET['verif']?>" method="post">
	<div class="form-group">
	    <label for="new-password" class="font-weight-bold">NOUVEAU MOT DE PASSE :</label>
	    <input type="password" class="form-control" id="new-password" name="new-password" placeholder="Nouveau mot de passe" required/>
	</div>
	<div class="">
		<button type="submit" class="btn btn-success mt-1 float-right">Changer le mot de passe</button>
	</div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>