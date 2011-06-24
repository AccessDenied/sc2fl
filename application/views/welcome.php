<?php foreach ($teamLeagues as $league): ?>
	<?=anchor('teamleagues/league/'.$league->get_id(), $league->get_name());?>
<?php endforeach; ?>