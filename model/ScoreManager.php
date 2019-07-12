<?php

namespace OpenClassrooms\BrickBreaker\Model;

require_once("model/Manager.php");

class ScoreManager extends Manager
{
	// Ajouter un score à la bdd
	public function addScore($username, $score)
	{
		$db = $this->dbConnect();
		$scores = $db->prepare('INSERT INTO scores(score_user, score, score_date) VALUES(?, ?, NOW())');
		$insertedLines = $scores->execute(array($username, $score));

		return $insertedLines;
	}

	/*
		*Obtenir les scores
		*$rank: classement par meilleur ('best') ou par date ('date')
		*$number: nombre de score que l'on souhaite ('all' si on les veut tous)
		*$page: false, pas de pagination, sinon numéro de la page ($number fait office de nombre par page)
		*$user: false, on récupère tous les scores. Si un nom d'utilisateur est renseigné on récupère les scores de cet utilisateur
	*/
	public function getScoresBy($rank, $number, $page, $user)
	{
		if ($page == false) {
			$db = $this->dbConnect();
			$scores = $db->prepare('SELECT score_user, score, score_date FROM scores LIMIT 0, ?');
			$scores->bindParam(1, $number, \PDO::PARAM_INT);
			$scores->execute(array($username));
			$resultat = $scores->fetch();
		}
	}

	// Nombre de score(s) d'un utilisateur
	public function numberOfScores($username)
	{
		$db = $this->dbConnect();
		$scores = $db ->prepare('SELECT COUNT(*) AS scoresNb FROM scores WHERE score_user=?');
		$scores->execute(array($username));
		$numberOfScores = $scores->fetch();
		$numberOfScores = $numberOfScores['scoresNb'];

		return $numberOfScores;
	}

	// Récupérer les scores d'un utilisateur
	public function getUserScore($username, $page, $orderBy)
	{
		$page = ($page-1)*10;
		$db = $this->dbConnect();
		
		if ($orderBy == 'score') {
			$scores = $db->prepare('SELECT score, score_date FROM scores WHERE score_user = :user ORDER BY score DESC LIMIT :page, 10');
		} else {
			$scores = $db->prepare('SELECT score, score_date FROM scores WHERE score_user = :user ORDER BY score_date DESC LIMIT :page, 10');
		}
		
		$scores->bindParam(':user', $username, \PDO::PARAM_STR);
		$scores->bindParam(':page', $page, \PDO::PARAM_INT);
		$scores->execute();
		
		return $scores;	
	}

	// Obtenir les 10 meilleurs scores pour le leaderboard
	public function leaderboard()
	{
		$db = $this->dbConnect();
		$scores = $db->query('SELECT score_user, score, score_date FROM scores ORDER BY score DESC LIMIT 0, 10');
		
		return $scores;
	}
}