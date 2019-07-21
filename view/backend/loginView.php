<?php $title = "Se connecter"; ?>

<?php ob_start(); ?>

<h1 class="text-center my-5 text-uppercase"><u>Connexion</u></h1>
<section class="row align-items-center">
	<div class="col-md-3">
		<a class=" btn-block btn-lg btn-primary mt-1 text-center" href="index.php?action=createAccount">Créer un compte</a>
		<a class=" btn-block btn-lg btn-info mt-1 text-center" href="index.php?action=forgottenPassword">Mot de passe oublié</a>
	</div>
	<form class="col-md-9 p-4" action="index.php?action=verifyLogin" method="post">
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
</section>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>