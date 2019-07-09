<?php

// Chargement des classes
require_once('model/UserManager.php');

// Se connecter
function myAccount()
{
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
		throw new Exception("Votre compte a bien été créé !");
	}
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

// Se déconnecter 
function disconnect()
{
	$_SESSION = array();
	session_destroy();
	header('Location: index.php');
}