<?php foreach ($teamLeagues->result() as $league): ?>
	<?=anchor('teamleague/league/'.$league->league_id, $league->name);?>
<?php endforeach; ?>