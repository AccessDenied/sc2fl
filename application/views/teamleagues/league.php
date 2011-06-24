<script type="text/javascript" src="<?=base_url().'application/scripts/teamleagues/league.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/teamleagues/league.css';?>" />
<div id="breadcrumb"><?=anchor('/', 'Home');?> > <?=$teamLeague->get_name();?></div>
<div id="league">
<?php foreach ($matches as $match):?>
	<div class="match">
		<div class="header">
			<div class="date"><?=date( 'M d, Y', strtotime($match->get_date_start()));?></div>
			<?php if (count($match->get_rounds()) > 0 && !is_null($match->get_winner())): ?>
				<?=anchor('teamleagues/match/'.$match->get_id(), 'view match', 'class="anchor_view-match"');?>
			<?php elseif (count($match->get_rounds()) > 0 && is_null($match->get_winner())): ?>
				<?=anchor('teamleagues/match/'.$match->get_id(), 'view match (in progress)', 'class="anchor_view-match"');?>
			<?php else:?>
				<span class="anchor_view-match">(match has not started yet)</span>
			<?php endif; ?>
		</div>
		<?php foreach ($match->get_teams() as $team):?>
			<div class="team<?php if ($team->get_id() == $match->get_winner()) echo ' WINNER'; ?>">
				<?php if (count($match->get_rounds()) > 0 && !is_null($match->get_winner())): ?>
					<?php if ($team->get_id() == $match->get_winner()):?>
						<div class="result WIN">+1 point for win</div>
					<?php else:?>
						<div class="result LOSS">-1 point for loss</div>
					<?php endif;?>
				<?php endif; ?>
				<div class="name"><?=$team->get_name();?></div>
				<a class="anchor_roster" href="">view roster</a>
				<div class="roster">
					<?php foreach ($team->get_roster() as $player):?>
						<div class="player"><?=$player->get_name();?></div>
					<?php endforeach;?>
				</div>
			</div>
		<?php endforeach;?>
	</div>
<?php endforeach; ?>
</div>