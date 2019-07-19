<?php

// Chargement des classes
require_once('model/ScoreManager.php');

// Affiche la page d'accueil
function homepage()
{
    require('view/frontend/homepageView.php');
}

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
function sendScore($score)
{
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) 
    {
        $scoreManager = new \OpenClassrooms\BrickBreaker\Model\ScoreManager();
        $insertedLines = $scoreManager->addScore($_SESSION['username'], $score);
        header('Location: index.php?action=brickBreaker');
    }
    else
    {
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