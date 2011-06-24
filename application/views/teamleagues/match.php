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
	<div class="rounds">
		<?php foreach ($match->get_rounds() as $round):?>
			<?php foreach ($round->get_players() as $player):?>
				<?=$player->get_name();?>
			<?php endforeach;?>
		<?php endforeach;?>
	</div>
</div>