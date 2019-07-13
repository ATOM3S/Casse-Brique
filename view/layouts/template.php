<!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title>

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">

        <link rel="apple-touch-icon" sizes="57x57" href="public/images/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="public/images/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="public/images/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="public/images/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="public/images/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="public/images/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="public/images/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="public/images/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="public/images/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="public/images/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="public/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="public/images/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="public/images/favicon-16x16.png">
        <link rel="manifest" href="public/images/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="public/images/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="public/css/style.css" rel="stylesheet" /> 
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
        
    <body>
        <div class="container">
            <header class="pt-2">
                <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                  <a class="navbar-brand" href="index.php">
                    <img src="public/images/logo.png" width="60" height="60" alt="">
                  </a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                    <div class="navbar-nav ml-auto">
                      <a class="nav-item nav-link" href="index.php?action=brickBreaker">Casse-Brique</a>
                      <a class="nav-item nav-link" href="index.php?action=leaderboard">Leaderboard</a>
                      <?php 
                      if (isset($_SESSION['isConnect']) && ($_SESSION['isConnect'] == true)) 
                      {
                        ?>
                        <a class="nav-item nav-link" href="index.php?action=myAccount">mon Compte</a>
                        <a class="nav-item nav-link text-danger" href="index.php?action=disconnect">Déconnexion</a>
                        <?php
                      } 
                      else 
                      {
                        ?>
                        <a class="nav-item nav-link text-success" href="index.php?action=login">Connexion</a>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </nav>
            </header>

            <?php 
            if (isset($content))
            {
              echo $content; 
            }
            ?>

        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>



