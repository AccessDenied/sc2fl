<?php foreach ($matches as $match):?>
	<div class="match">
		<?php foreach ($match->get_teams() as $team):?>
			<div class="team">
				<?=$team->get_name();?>
			</div>
			<?php foreach ($team->get_roster() as $player):?>
				<div class="roster">
					<?=$player->get_name();?>
				</div>
			<?php endforeach;?>
		<?php endforeach;?>
		<?=anchor('teamleagues/match/'.$match->get_id(), 'view match');?>
	</div>
<?php endforeach; ?>