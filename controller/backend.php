<?php

// Chargement des classes
require_once('model/UserManager.php');

// Afficher mon compte (et ses scores)
function myAccount()
{
	$scoreManager = new \OpenClassrooms\BrickBreaker\Model\ScoreManager();

	$numberOfScores = $scoreManager->numberOfScores($_SESSION['username']);

	if (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) &&  $_GET['page']>0) {
		$page = htmlspecialchars($_GET['page']);
	}
	else
	{
		$page = 1;
	}	

	if (isset($_GET['orderBy']) && !empty($_GET['orderBy'])) {
		$orderBy = htmlspecialchars($_GET['orderBy']);
	}
	else
	{
		$orderBy = 'score';
	}

	$scores = $scoreManager->getUserScore($_SESSION['username'], $page, $orderBy);

    require('view/backend/myAccountView.php');
}

// Se connecter
function login()
{
    require('view/backend/loginView.php');
}

// Vérifie si le nom d'utilisateur et le mot de passe correspondent
function verifyLogin($username, $password)
{
	$userManager = new \OpenClassrooms\BrickBreaker\Model\UserManager();

	$isConnect = $userManager->login($username, $password);

	if ($isConnect) {
		header('Location: index.php?action=myAccount');
	}
}

// Créer un compte
function createAccount()
{
    require('view/backend/createAccountView.php');
}

// Ajouter le compte à la bdd
function addAccount($username, $email, $password)
{
    $userManager = new \OpenClassrooms\BrickBreaker\Model\UserManager();

	$affectedLines = $userManager->addAccount($username, $email, $password);

	if (!$affectedLines) {
		$_SESSION['redirection'] = 'index.php?action=createAccount';
		throw new Exception("Une erreur s'est produite lors de la création du compte.");
	}
	else {
		$_SESSION['redirection'] = 'index.php?action=login';
		throw new Exception("Votre compte a bien été créé ! Un mail vous a été envoyé pour vérifier votre compte (pensez à vérifier le courrier indésirable/spam).");
	}
}

// Vérifier le compte
function verifyAccount ($username, $verif) 
{
	$userManager = new \OpenClassrooms\BrickBreaker\Model\UserManager();

	$verifiedLines = $userManager->verifyAccount($username, $verif);
}

// Permet à un utilisateur de modifier son mot de passe
function changePassword()
{
	require('view/backend/changePasswordView.php');
}

// Met à jour le mot de passe dans la bdd
function updatePassword($oldPassword, $newPassword)
{
	$userManager = new \OpenClassrooms\BrickBreaker\Model\UserManager();

	$updatedLines = $userManager->updatePassword($oldPassword, $newPassword);

	if (!$updatedLines) {
		$_SESSION['redirection'] = 'index.php?action=changePassword';
		throw new Exception("Erreur, impossible de modifier le mot de passe");
	} else {
		$_SESSION['redirection'] = 'index.php?action=myAccount';
		throw new Exception("Le mot de passe a été mis à jour !");
	}
}

// Mot de passe oublié
function forgottenPassword()
{
	require('view/backend/forgottenPasswordView.php');
}

// Envoyer un mail de récupération
function sendRecuperationMail($email)
{
	$userManager = new \OpenClassrooms\BrickBreaker\Model\UserManager();

	$updatedLines = $userManager->sendRecuperationMail($email);

	throw new Exception("Un mail de récupération vous a été envoyé. Veuillez consulter votre boite mail (n'oubliez pas de consulter aussi vos SPAM/indésirables).");
	
}

// Choix du nouveau mot de passe
function newPassword ()
{
	require('view/backend/resetPasswordView.php');
}

// Vérifier sur le code de vérification est bon avant de changer de mdp
function resetPassword($userId, $verifCode, $newPassword)
{
	$userManager = new \OpenClassrooms\BrickBreaker\Model\UserManager();

	$updatedLines = $userManager->resetPassword($userId, $verifCode, $newPassword);

	if (!$updatedLines) {
		$_SESSION['redirection'] = 'index.php?action=changePassword';
		throw new Exception("Erreur, impossible de modifier le mot de passe");
	} else {
		$_SESSION['redirection'] = 'index.php?action=myAccount';
		throw new Exception("Le mot de passe a été mis à jour !");
	}
}

// Se déconnecter 
function disconnect()
{
	$_SESSION = array();
	session_destroy();
	header('Location: index.php');
}