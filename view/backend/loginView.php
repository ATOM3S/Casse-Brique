<?php $title = "Se connecter"; ?>

<?php ob_start(); ?>

<h1 class="text-center my-5"><u>Connexion</u></h1>

<form class="p-4 rounded" action="index.php?action=verifyLogin" method="post">
	<div class="form-group">
	    <label for="login-name" class="font-weight-bold">NOM D'UTILISATEUR :</label>
	    <input type="text" class="form-control" id="login-name" name="login-name" placeholder="Nom d'utilisateur" required />
	</div>
	<div class="form-group">
	    <label for="login-password" class="font-weight-bold">MOT DE PASSE :</label>
	    <input type="password" class="form-control" id="login-password" name="login-password" placeholder="Mot de passe" required/>
	</div>
	<div class="">
		<button type="submit" class="btn btn-success mt-1 float-right">Connexion</button>
	</div>
</form>
<div class="row">
	<a class="btn btn-primary mt-1 float-right" href="index.php?action=createAccount">Créer un compte</a>
	<a class="btn btn-info mt-1 float-right" href="index.php?action=forgottenPassword">Mot de passe oublié</a>
</div>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>