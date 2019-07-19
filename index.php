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
        elseif ($_GET['action'] == 'sendScore' && isset($_GET['score']) && !empty($_GET['score'])) {
            sendScore(htmlspecialchars($_GET['score']));
        }
        elseif ($_GET['action'] == 'leaderboard') { 
            leaderboard();
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
        elseif ($_GET['action'] == 'verifyAccount') {
            if (isset($_GET['username']) &&  !empty($_GET['username']) && isset($_GET['verif']) &&  !empty($_GET['verif'])) 
            {
                verifyAccount(htmlspecialchars($_GET['username']), htmlspecialchars($_GET['verif']));   
            }
            else
            {
                throw new Exception("Il semble y avoir une erreur avec le lien de validation.");
            }   
        }
        elseif ($_GET['action'] == 'forgottenPassword') {
            forgottenPassword();
        }
        elseif ($_GET['action'] == 'sendRecuperationMail') {
            if (isset($_POST['email']) &&  !empty($_POST['email'])) 
            {
                sendRecuperationMail(htmlspecialchars($_POST['email']));   
            }
            else
            {
                throw new Exception("Erreur, l'addresse email n'est pas valide.");
            }   
        }
        elseif ($_GET['action'] == 'newPassword') {
            if (isset($_GET['id']) &&  !empty($_GET['id']) && isset($_GET['verif']) &&  !empty($_GET['verif'])) 
            {
                newPassword();   
            }
            else
            {
                throw new Exception("Erreur, il semble y avoir un problème avec le lien de récupération.");
            } 
        }
        elseif ($_GET['action'] == 'resetPassword') {
            if (isset($_GET['id']) &&  !empty($_GET['id']) && isset($_GET['verif']) &&  !empty($_GET['verif']) && isset($_POST['new-password']) &&  !empty($_POST['new-password'])) 
            {
                resetPassword(htmlspecialchars($_GET['id']), htmlspecialchars($_GET['verif']), htmlspecialchars($_POST['new-password']));   
            }
            else
            {
                throw new Exception("Erreur, il semble y avoir un problème avec le lien de récupération ou avec le nouveau mot de passe.");
            }   
        }
        elseif (isset($_SESSION['isConnect']) && $_SESSION['isConnect']) 
        {
            if ($_GET['action'] == 'myAccount') {
                if (!isset($_GET['page'])) {
                    header('location: index.php?action=myAccount&page=1');
                } else {
                    myAccount();
                }  
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
        homepage();
    }
}

catch(Exception $e) {
    $error = $e->getMessage();
    showError($error);
}