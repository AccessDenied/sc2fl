<script type="text/javascript" src="<?=base_url().'application/scripts/teamleague/league/match.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/teamleague/league/match.css';?>" />
<div id="breadcrumb"><?=anchor('/', 'Home');?> > <?=anchor('teamleague/league/'.$teamLeague->get_id(), $teamLeague->get_name());?> > <?=$match->get_name();?></div>
<div class="match">
	<div id="teams">
		<?php foreach ($match->get_teams() as $team):?>
		<div class="team">
			<div class="name"><?=$team->get_name();?></div>
			<div class="roster">
			<?php foreach ($team->get_roster() as $player):?>
				<div class="player<?php if (in_array($player, $competitors)) echo ' COMPETED';?>"><?=$player->get_name();?></div>
			<?php endforeach;?>
			</div>
		</div>
		<?php endforeach;?>
	</div>
	<div id="rounds">
		<?php foreach ($match->get_rounds() as $round):?>
		<div class="round">
			<?php foreach ($round->get_competitors() as $competitor):?>
				<div class="competitor">
					<div class="name"><?=$competitor->get_name();?></div>
					<?php if (!is_null($round->get_winner())):?>
						<?php if ($round->get_winner() == $competitor->get_id()):?>
							<div class="result WIN">win</div>
						<?php else:?>
							<div class="result LOSS">loss</div>
						<?php endif;?>
					<?php else:?>
						<div class="result">in progress</div>
					<?php endif;?>
				</div>
			<?php endforeach;?>
		</div>
		<?php endforeach;?>
	</div>
</div>