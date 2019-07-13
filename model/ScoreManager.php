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