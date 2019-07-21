<?php 
$title = "Mon Compte";
$description = "Mon compte Casse-Brique. Changez votre mot de passe ou accédez à vos scores." 
?>

<?php ob_start(); ?>
<section class="mt-3 ">
	<h1 class="text-center text-uppercase py-4"><u>Mon Compte</u></h1>
	<div class="row justify-content-around">
		<div class="col-md-4 text-center">
			<div class="pt-1 pb-4 mb-3 custom-background cbg-white shadow">
				<h2 class="mt-5 text-uppercase">Utilisateur</h2>
				<p class="mb-5 h3 "><em><?= $_SESSION['username'] ?></em></p>
				<div class="row justify-content-center mb-3"><a href="index.php?action=changePassword" class="btn btn-primary">Changer le mot de passe</a></div>
			</div>
		</div>

		<div class="mx-3 col-md-6 custom-background cbg-white shadow">
			<h2 class="text-center my-5 text-uppercase">Mes scores</h2>
			<p class="text-center font-weight-bold">Trier par: <p/>
			<p class="text-center font-weight-bold"><a href="index.php?action=myAccount&page=<?=htmlspecialchars($_GET['page'])?>&orderBy=date"> Date</a> / <a href="index.php?action=myAccount&page=<?=htmlspecialchars($_GET['page'])?>&orderBy=score">Score</a></p>
			<?php if (isset($scores)): ?>
			<div class="pt-4">
				<table class="table custom-background text-white cbg-orange rounded">
				    <thead>
				        <tr>
				            <th class="text-center" scope="col">#</th>
				            <th class="text-center" scope="col">Score</th>
				            <th class="text-center" scope="col">Date</th>
				        </tr>
				    </thead>
				    <tbody>
				<?php
				$i = 0;
				while ($data = $scores->fetch()):
					if ($i == 0):
						$firstScore = $data['score'];
					endif;
				    $i++;
				    ?> 
				        <tr>
				            <th class="text-center"><?=(($page-1)*10)+$i?></th>
				            <td class="text-center"><?=$data['score']?></td>
				            <td class="text-center"><?=$data['score_date_fr']?></td>
				        </tr>
				    <?php
				endwhile;
				$scores->closeCursor();
				?>
				    </tbody>
				</table>
			</div>
			<p class="row justify-content-center">
				<?php 
				if (isset($_GET['orderBy']) && !empty($_GET['orderBy'])):
					$newOrderBy = '&orderBy='.htmlspecialchars($_GET['orderBy']);
				else:
					$newOrderBy = '';
				endif;
				if (isset($numberOfScores) && $numberOfScores>10):
					if (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) &&  $_GET['page']>1):
						$prevPage = htmlspecialchars($_GET['page'])-1;
						?>
						<a class="text-uppercase font-weight-bold" href="index.php?action=myAccount&page=<?=$prevPage?><?=$newOrderBy?>"><- Page précédente |</a>
						<?php
					endif;

					if (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) &&  $_GET['page'] < ($numberOfScores/10)):
						$nextPage = htmlspecialchars($_GET['page']) + 1; 
						?>
						<a class="text-uppercase font-weight-bold" href="index.php?action=myAccount&page=<?=$nextPage?><?=$newOrderBy?>">| Page suivante -></a>
						<?php
					endif;
				endif;
			endif;
			?>
			</p>
			<?php if (isset($firstScore)): ?>
			<div class="my-4 mx-1 row text-white custom-background cbg-orange justify-content-center">
				<i class="col-1 p-1 fas fa-info-circle fa-2x"></i><p id="scoreInfo" class="pt-2 col-11 text-center"><?=$firstScore?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<script src="public/js/ajax.js"></script>
<script src="public/js/main.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layouts/template.php'); ?>