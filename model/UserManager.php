<?php

namespace OpenClassrooms\BrickBreaker\Model;

require_once("model/Manager.php");

class UserManager extends Manager
{
	// Vérifier si un nom d'utilisateur existe déjà
	private function isUsernameExist($username)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT username FROM users WHERE username = ?');
		$req->execute(array($username));
		$resultat = $req->fetch();

		if (!$resultat) {
			return false;
		}
		else {
			return true;
		}
	}

	// Vérifier si email existe déjà
	private function isEmailExist($email)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT email FROM users WHERE email = ?');
		$req->execute(array($email));
		$resultat = $req->fetch();

		if (!$resultat) {
			return false;
		}
		else {
			return true;
		}
	}

	// Ajouter un nouveau compte dans la base de donnée
	public function addAccount($username, $email, $password)
	{
		if ($this->isUsernameExist($username)) {
			$_SESSION['redirection'] = 'index.php?action=createAccount';
			throw new Exception("Ce nom d'utilisateur est déjà utilisé.");
		} else if ($this->isEmailExist($email)) {
			$_SESSION['redirection'] = 'index.php?action=createAccount';
			throw new Exception("Cette adresse email est déjà associé à un compte.");
		} else {
			$db = $this->dbConnect();
	        $users = $db->prepare('INSERT INTO users(username, email, password) VALUES(?, ?, ?)');
	        $affectedLines = $users->execute(array($username, $email, password_hash($password, PASSWORD_DEFAULT)));

	        return $affectedLines;
		}
	}

	// Permet la connexion si le nom d'utilisateur et le mot de passe correspondent
	// Créer une varaible session true si l'utilisateur est administrateur
	public function login($username, $password)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT username, password FROM users WHERE username = ?');
		$req->execute(array($username));
		$resultat = $req->fetch();

		$isPasswordCorrect = password_verify($password, $resultat['password']);
		$isConnect = false;

		if (!$resultat)
		{
			$_SESSION['redirection'] = 'index.php?action=login';
            throw new \Exception('Mauvais identifiant ou mot de passe !');
		}
		else
		{
		    if ($isPasswordCorrect) {
		    	$_SESSION['username'] = $username;
		        $_SESSION['isConnect'] = true;
		        $isConnect = true;
		    }
		    else {
		        $_SESSION['redirection'] = 'index.php?action=login';
            	throw new \Exception('Mauvais identifiant ou mot de passe !');
		    }
		}
		return $isConnect;
	}

	public function updatePassword($oldPassword, $newPassword)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT password FROM users WHERE username = ?');
		$req->execute(array($_SESSION['username']));
		$resultat = $req->fetch();

		$isPasswordCorrect = password_verify($oldPassword, $resultat['password']);

		if(!$resultat) {
			$_SESSION['redirection'] = 'index.php?action=changePassword';
			throw new \Exception("Erreur avec le nom d'utilisateur, impossible de modifier le mot de passse.");	
		} elseif (!$isPasswordCorrect) {
			$_SESSION['redirection'] = 'index.php?action=changePassword';
			throw new \Exception("Erreur, l'ancien mot de passse ne correspond pas.");
		} else {
			$req->closeCursor();
			$db = $this->dbConnect();
			$users = $db->prepare('UPDATE users SET password = ? WHERE username = ?');
			$updatedLines = $users->execute(array(password_hash($newPassword, PASSWORD_DEFAULT), $_SESSION['username']));

			return $updatedLines;
		}
	}
}