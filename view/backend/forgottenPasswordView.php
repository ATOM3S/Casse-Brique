<?php $title = "Mot de passe oublié"; ?>

<?php ob_start(); ?>

<h1 class="text-center my-5"><u>Mot de passe oublié</u></h1>

<form class="p-4 rounded" action="index.php?action=sendRecuperationMail" method="post">
	<div class="form-group">
	    <label for="email" class="font-weight-bold">Adresse email :</label>
	    <input type="email" class="form-control" id="email" name="email" placeholder="votre adresse email" required />
	</div>
	<div class="">
		<button type="submit" class="btn btn-success mt-1 float-right">Envoyer</button>
	</div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>