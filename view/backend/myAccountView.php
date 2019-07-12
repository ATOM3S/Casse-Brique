<?php $title = "Mon Compte"; ?>

<?php ob_start(); ?>

<h1 class="text-center my-5"><u>Mon Compte</u></h1>
<h2 class="text-center my-5"><?= $_SESSION['username'] ?></h2>
<a href="index.php?action=changePassword">Changer le mot de passe</a>

<h2 class="text-center my-5"><u>Mes scores</u></h2>
<p>Trier par: <a href="index.php?action=myAccount&page=<?=htmlspecialchars($_GET['page'])?>&orderBy=date">Date</a> | <a href="index.php?action=myAccount&page=<?=htmlspecialchars($_GET['page'])?>&orderBy=score">Score</a></p>

<?php 
if (isset($scores)) 
{
?>
	<table class="table">
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
	    $i++;
	    ?> 
	        <tr>
	            <th scope="row"><?=$i?></th>
	            <td><?=$data['score']?></td>
	            <td><?=$data['score_date']?></td>
	        </tr>
	    <?php
	}
	$scores->closeCursor();
	?>
	    </tbody>
	</table>
	
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
			<a href="index.php?action=myAccount&page=<?=$prevPage?><?=$newOrderBy?>">Page précédente </a>
			<?php
		}

		if (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) &&  $_GET['page'] < ($numberOfScores/10)) 
		{
			$nextPage = htmlspecialchars($_GET['page']) + 1; 
			?>
			<a href="index.php?action=myAccount&page=<?=$nextPage?><?=$newOrderBy?>"> Page suivante</a>
			<?php
		}
	}

}
?>
	

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>