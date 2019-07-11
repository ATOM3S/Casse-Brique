<?php $title = "Créer un compte"; ?>

<?php ob_start(); ?>

<h1 class="text-center my-5"><u>Créer un compte</u></h1>

<form class="p-4 rounded" action="index.php?action=addAccount" method="post">
	<div class="form-group">
	    <label for="username" class="font-weight-bold">NOM D'UTILISATEUR :</label>
	    <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" required />
	</div>
	<div class="form-group">
	    <label for="email" class="font-weight-bold">ADRESSE EMAIL :</label>
	    <input type="email" class="form-control" id="email" name="email" placeholder="Adresse email" required />
	</div>
	<div class="form-group">
	    <label for="password" class="font-weight-bold">MOT DE PASSE :</label>
	    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required/>
	</div>
	<div class="">
		<button type="submit" class="btn btn-success mt-1 float-right">Créer</button>
	</div>
</form>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>