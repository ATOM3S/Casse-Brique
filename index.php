<?php
session_start(); 

require('controller/frontend.php');
require('controller/backend.php');

try {
    if (isset($_GET['action'])) {

        /*front*/
        if ($_GET['action'] == 'brickBreaker') { 
            brickBreaker();
        }

        /*back*/
        elseif ($_GET['action'] == 'login') {
            login();
        }
        elseif ($_GET['action'] == 'disconnect') {
            disconnect();
        }
        elseif ($_GET['action'] == 'createAccount') {
            createAccount();
        }
        elseif ($_GET['action'] == 'verifyLogin') {
            if (isset($_POST['login-name']) && isset($_POST['login-password']) && !empty($_POST['login-name']) && !empty($_POST['login-password'])) 
            {
                verifyLogin(htmlspecialchars($_POST['login-name']), htmlspecialchars($_POST['login-password']));   
            }
            else
            {
                $_SESSION['redirection'] = 'index.php?action=login';
                throw new Exception("Le champ nom d'utilisateur et le mot de passe doivent être complété.");
            }   
        }
        elseif ($_GET['action'] == 'addAccount') {
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) 
            {
                addAccount(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));   
            }
            else
            {
                $_SESSION['redirection'] = 'index.php?action=createAccount';
                throw new Exception("Tous les champs doivent être complété.");
            }   
        }
        elseif (isset($_SESSION['isConnect']) && $_SESSION['isConnect']) 
        {
            if ($_GET['action'] == 'myAccount') {
                myAccount();
            }
            elseif ($_GET['action'] == 'changePassword') {
                changePassword();
            }
            elseif ($_GET['action'] == 'modifyPassword') {
                if (isset($_POST['old-password']) && isset($_POST['new-password']) && !empty($_POST['old-password']) && !empty($_POST['new-password'])) {
                    updatePassword(htmlspecialchars($_POST['old-password']), htmlspecialchars($_POST['new-password']));
                } else {
                    $_SESSION['redirection'] = 'index.php?action=changePassword';
                    throw new Exception("Les champs ancien et nouveau mot de passe doivent être rempli.");   
                } 
            }
            else {
                brickBreaker();
            }
        }
        else {
            login();
        }  
    }
    else {
        brickBreaker();
    }
}

catch(Exception $e) {
    $error = $e->getMessage();
    showError($error);
}