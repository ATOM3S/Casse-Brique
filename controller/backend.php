<?php

// Chargement des classes
// require_once('model/UserManager.php');

// Afficher le back office
function backOffice()
{
	$postManager = new \Forteroche\Blog\Model\PostManager();
    $posts = $postManager->getAllPosts();

	require('view/backend/backOfficeView.php');
}

