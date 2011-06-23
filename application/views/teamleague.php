<?php foreach ($matches->result() as $match): ?>
	<p><?=$match->team_one;?></p>
	<p><?=$match->team_two;?></p>
<?php endforeach; ?>