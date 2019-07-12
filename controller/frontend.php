<?php

// Chargement des classes
require_once('model/ScoreManager.php');

// Lite tous les articles
function brickBreaker()
{
    require('view/frontend/brickBreakerView.php');
}

// Affiche une page avec un message d'erreur en cas d'erreur
function showError($error)
{
    require('view/frontend/errorView.php');
}

// Ajout du score à la bdd
function afterWin($score)
{
    if (is_numeric($score) && isset($_SESSION['username']) && !empty($_SESSION['username'])) 
    {
        $scoreManager = new \OpenClassrooms\BrickBreaker\Model\ScoreManager();
        $insertedLines = $scoreManager->addScore($_SESSION['username'], $score);
        header('Location: index.php?action=brickBreaker');
    }
    else
    {
        echo 'marche pas';
        echo $_SESSION['username'];
        echo $score;
        header('Location: index.php?action=brickBreaker');
    }
}

// Tableau des meilleurs scores
function leaderboard()
{
    $scoreManager = new \OpenClassrooms\BrickBreaker\Model\ScoreManager();
    $scores = $scoreManager->leaderboard();
    require('view/frontend/leaderboardView.php');    
}