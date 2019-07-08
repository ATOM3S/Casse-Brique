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
        
    }
    else {
        brickBreaker();
    }
}

catch(Exception $e) {
    $error = $e->getMessage();
    showError($error);
}