<?php 
$title = 'Leaderboard'; 
$description = "Leaderboard: Tableau d'affichage des meilleurs scores. Essayez d'afficher votre pseudo sur ce tableau !";
?>

<?php ob_start(); ?>
<section class="">
    <h1 class="text-center mt-5 text-uppercase"><u>Leaderboard</u></h1>

    <div class="row justify-content-center pt-4 ">
    <table class="table col-6 text-center text-white custom-background cbg-grey shadow">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Gamer</th>
                <th scope="col">Score</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $i = 0;
    while ($data = $scores->fetch())
    {
        $i++;
        ?> 
            <tr class="">
                <th><?=$i?></th>
                <td><?=$data['score_user']?></td>
                <td><?=$data['score']?></td>
                <td><?=$data['score_date_fr']?></td>
            </tr>
        <?php
    }
    $scores->closeCursor();
    ?>
        </tbody>
    </table>
    </div>
</section>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>