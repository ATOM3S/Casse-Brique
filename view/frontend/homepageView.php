<?php 
$title = 'Casse-Brique, Accueil';
$description = 'Bienvenue sur la page d\'accueil de Casse-Brique, un petit projet indépendant rendant hommage au BrickBreaker original.'; 
?>

<?php ob_start(); ?>
<section class="row text-justify mt-4">
    <div class="col-lg-12">
        <h1 class="my-4 text-center">Bienvenue sur Casse-Brique !</h1>
        <p class="text-justify"><img src="public/images/logo.png" class="float-left" alt="logo billet simple alaska"  /><em>Casse-Brique</em> est un petit projet mené par un étudiant, censé rendre hommage au jeu original du Brick-Breaker, ou Casse-briques dans la langue de Molière.</p>
        <h3 class="mt-4">Comment Jouer ?</h3>
        <p class="text-justify mb-5">Rien de plus simple ! Cliquez simplement sur Casse-Brique dans le menu, ou cliquez <a href="idex.php?action=brickBreaker">ici</a>. Ne laissez pas la balle toucher le sol, sinon vous perdez une vie. Plus de vie et c'est perdu ! Le but est, comme le nom du jeu l'indique, casser toutes les briques.</p>
        <h3 class="">Les commandes</h3>
        <p class="text-justify mb-5">Si vous êtes sur ordinateur, utilisez les touches fléchés gauche et droite pour déplacer la barre. Si vous êtes sur tablette ou smartphone, touchez le bord gauche de l'écran pour déplacer la barre à gauche, et le droit pour la déplacer à droite. Simple non ?</p>
        <h3 class="">Petite astuce</h3>
        <p class="text-justify mb-5">La vitesse de rébond de la balle dépend de la façon dont la barre (paddle en anglais) touche la balle. Si la barre est immobile, la balle rebondi normalement. A contre sens, la balle ralenti, et si le paddle va dans le même sens que la balle, celle-ci accélère. Bon, dis comme ça, cela peut sembler un peu technique, voire obscure, mais vous comprendrez en jouant.</p>
        <h3 class="">Score & combo</h3>
        <p class="text-justify mb-5">Le score dépend du nombre de briques que vous cassez, du nombre de briques que vous cassez d'affilé sans que la balle ne tombe ou qu'elle ne touche la barre (ce qu'on appelle le combo), du nombre de vie qu'il vous reste à la fin, et de la difficulté (et oui, plus c'est dur, plus cela vous rapporte de points). Vous voulez que vos scores soient sauvegarde ? Il suffit de vous créer un compte. Si vous êtes connecté, votre score sera sauvegardé. Essayez de faire partie des dix meilleurs joueurs et votre pseudo apparaitra dans le <a href="index.php?action=leaderboard">leaderboard</a> !</p>
        <h3 class="">Se créer un compte ? </h3>
        <p class="text-justify mb-5">La aussi, rien de plus simple. Allez sur la page <a href="index.php?action=login">connexion</a> puis cliquez sur créer un compte. Ou gagnez du temps et allez directement sur la page de <a href="index.php?action=createAccount">création de compte</a>. Déjà inscrit mais vous avez oubliez votre mot de passe ? Pas de panique. Cliquez simplement sur <a href="index.php?action=forgottenPassword">Mot de passe oublié</a> sur la page connexion</p>
        <h3 class="">Un soucis, une question ?</h3>
        <p class="text-justify mb-5">N'hésitez pas à me contacter: contact@jonasdelaunay.com</p>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?> 