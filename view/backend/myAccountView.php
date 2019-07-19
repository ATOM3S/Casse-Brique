<?php 
$title = "Mon Compte";
$description = "Mon compte Casse-Brique. Changez votre mot de passe ou accédez à vos scores." 
?>

<?php ob_start(); ?>

<h1 class="text-center my-5"><u>Mon Compte</u></h1>
<h2 class="text-center my-5">Utilisateur: <em><?= $_SESSION['username'] ?></em></h2>
<div class="row justify-content-center"><a href="index.php?action=changePassword" class="btn btn-primary">Changer le mot de passe</a></div>

<h2 class="text-center my-5"><u>Mes scores</u></h2>
<p class="row justify-content-center">Trier par: <a href="index.php?action=myAccount&page=<?=htmlspecialchars($_GET['page'])?>&orderBy=date"> Date</a> | <a href="index.php?action=myAccount&page=<?=htmlspecialchars($_GET['page'])?>&orderBy=score">Score</a></p>

<?php 
if (isset($scores)) 
{
?>
<div class="row justify-content-center pt-4">

	<table class="table col-4">
	    <thead>
	        <tr>
	            <th scope="col">#</th>
	            <th scope="col">Score</th>
	            <th scope="col">Date</th>
	        </tr>
	    </thead>
	    <tbody>
	<?php
	$i = 0;
	while ($data = $scores->fetch())
	{
		if ($i == 0) {
			$firstScore = $data['score'];
		}
	    $i++;
	    ?> 
	        <tr>
	            <th scope="row"><?=(($page-1)*10)+$i?></th>
	            <td><?=$data['score']?></td>
	            <td><?=$data['score_date']?></td>
	        </tr>
	    <?php
	}
	$scores->closeCursor();
	?>
	    </tbody>
	</table>
</div>
<p class="row justify-content-center">
	<?php 
	if (isset($_GET['orderBy']) && !empty($_GET['orderBy'])) 
	{
		$newOrderBy = '&orderBy='.htmlspecialchars($_GET['orderBy']);
	} else {
		$newOrderBy = '';
	}
	if (isset($numberOfScores) && $numberOfScores>10) {
		if (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) &&  $_GET['page']>1) {
			$prevPage = htmlspecialchars($_GET['page'])-1;
			?>
			<a href="index.php?action=myAccount&page=<?=$prevPage?><?=$newOrderBy?>"><- Page précédente |</a>
			<?php
		}

		if (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) &&  $_GET['page'] < ($numberOfScores/10)) 
		{
			$nextPage = htmlspecialchars($_GET['page']) + 1; 
			?>
			<a href="index.php?action=myAccount&page=<?=$nextPage?><?=$newOrderBy?>">| Page suivante -></a>
			<?php
		}
	}
}
?>
</p>
<p id="scoreInfo" class="text-center"><?=$firstScore?></p>
<script src="public/js/ajax.js"></script>
<script src="public/js/main.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>