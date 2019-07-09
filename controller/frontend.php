<?php

// Chargement des classes
// require_once('model/PostManager.php');

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