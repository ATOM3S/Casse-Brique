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

	// Envoyer un mail de confirmation lors de la création du compte
	private function sendVerificationMail($username, $email, $verification)
	{
		$header="MIME-Version: 1.0\r\n";
		$header.='From:"projet5.jonasdelaunay.com"<contact@jonasdelaunay.com>'."\n";
		$header.='Content-Type:text/html; charset="utf-8"'."\n";
		$header.='Content-Transfer-Encoding: 8bit';

		$message= '
			<html>
				<body>
					<p>Bonjour '.$username.'</p>
					<p>Merci d\'avoir créer un compte pour jouer au casse-brique !</p>
					<p>Il ne vous reste plus qu\'une étape pour pouvoir vous connecter: cliquez sur le lien si dessous pour activer votre compte</p>
					<p><a href="http://projet5.jonasdelaunay.com/index.php?action=verifyAccount&username='.$username.'&verif='.$verification.'">Cliquez pour valider votre compte</a></p>
				</body>
			</html>
		';

		mail($email, "Vérification de compte casse-brique", $message, $header);
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
			$verification = password_hash(date("i:Y--Hm-ds"), PASSWORD_DEFAULT);
			$db = $this->dbConnect();
	        $users = $db->prepare('INSERT INTO users(username, email, password, verification) VALUES(?, ?, ?, ?)');
	        $affectedLines = $users->execute(array($username, $email, password_hash($password, PASSWORD_DEFAULT), $verification));
	        if ($affectedLines) {
	        	$this->sendVerificationMail($username, $email, $verification);
	        }

	        return $affectedLines;
		}
	}

	// Vérification du compte (lien de validation par email)
	public function verifyAccount($username, $verif)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT username, verification, authenticated FROM users WHERE username = ?');
		$req->execute(array($username));
		$resultat = $req->fetch();

		if (!$resultat) {
			throw new \Exception("Erreur, ce compte n'existe pas.");	
		}
		elseif ($resultat['authenticated']) {
			throw new \Exception("Ce compte a déja été vérifié !");
		}
		elseif ($verif == $resultat['verification']) {
			$req->closeCursor();
			$db = $this->dbConnect();
			$users = $db->prepare('UPDATE users SET authenticated = 1 WHERE username = ?');
			$updatedLines = $users->execute(array($username));
			$_SESSION['redirection'] = 'index.php?action=login';
			throw new \Exception("Votre compte a été vérifié avec succès. Vous pouvez vous connecter");
		}
		else {
			throw new \Exception("Il y a eu une erreur lors de l'authentification");
		}
	}

	// Permet la connexion si le nom d'utilisateur et le mot de passe correspondent
	// Créer une varaible session true si l'utilisateur est administrateur
	public function login($username, $password)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT username, password, authenticated FROM users WHERE username = ?');
		$req->execute(array($username));
		$resultat = $req->fetch();

		$isPasswordCorrect = password_verify($password, $resultat['password']);
		$isConnect = false;

		if (!$resultat || !$resultat['authenticated'])
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