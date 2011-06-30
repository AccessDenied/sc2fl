<script type="text/javascript" src="<?=base_url().'application/scripts/teamleague/fantasy.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/teamleague/fantasy.css';?>" />
<?=anchor('welcome', 'Home', 'id="anchor_breadcrumb"');?>
<?php $team_statistics = $statistics->get_team_statistics();?>
<?php $player_statistics = $statistics->get_player_statistics();?>

<table id="table_team-statistics">
	<tr>
		<th>Team Name</th><th>Wins</th><th>Losses</th>
	</tr>
<?php foreach ($statistics->get_teams() as $team):?>
	<tr>
		<td><?=$team->get_name();?></td><td><?=$team_statistics[$team->get_id()]->get_wins()?></td><td><?=$team_statistics[$team->get_id()]->get_losses()?></td>
	</tr>
<?php endforeach;?>
</table>
<table id="table_player-statistics">
	<tr>
		<th>Player Name</th><th>Wins</th><th>Losses</th><th>Total Points</th>
	</tr>
<?php foreach ($statistics->get_players() as $player):?>
	<tr>
		<td><?=$player->get_name();?></td><td><?=$player_statistics[$player->get_id()]->get_wins()?></td><td><?=$player_statistics[$player->get_id()]->get_losses()?></td><td><?=$player_statistics[$player->get_id()]->get_total_points()?></td>
	</tr>
<?php endforeach;?>
</table>


<?php if (isset($auth) && in_array($user_id, $fantasy->get_participant_ids())):?>
<?=anchor('teamleague/fantasy/manage/'.$fantasy->get_id(),'manage your team','rel="#overlay_fantasy-manage" id="anchor_fantasy-manage"');?>
<?php else:?>
<div id="instructions">log in and join fantasy league to manage your drafts in this league.</div>
<?php endif;?>
<!-- overlayed element -->
<div id="overlay_fantasy-manage" class="overlay">
	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>
</div>

<div id="drafted-players">
<div class="title">Drafted Players:</div>
<?php if(isset($drafted_players)):?>
	<?php $total_points = 0;?>
	<?php foreach($drafted_players as $player):?>
		<?php if (isset($player_statistics[$player->get_id()])):?>
			<?php $total_points += $player_statistics[$player->get_id()]->get_total_points();?>
		<?php endif;?>
		<div class="drafted-player">
			<div class="name"><?=$player->get_name();?></div>
			<div class="points"><?=(isset($player_statistics[$player->get_id()])) ? $player_statistics[$player->get_id()]->get_total_points() : 0 ?></div>
		</div>
	<?php endforeach;?>
<?php else:?>
	<div class="name">No Team Drafted.</div>
<?php endif;?>

</div>

<div id="drafted-team">
	<div class="title">Drafted Team:</div>
	<?php if(isset($drafted_team)):?>
		<div class="name"><?=$drafted_team->get_name();?></div>
		<div class="wins"><?=$team_statistics[$drafted_team->get_id()]->get_wins()?></div>
	<?php else:?>
		<div class="name">No Team Drafted.</div>
	<?php endif;?>		
</div>

<div id="total-points">
	<div class="title">Total Points:</div>
	<?php if(isset($total_points)):?>
		<div class="points"><?=$total_points += $team_statistics[$team->get_id()]->get_wins();?></div>
	<?php else:?>
		<div class="name">No Points Calculated</div>
	<?php endif;?>	
</div>
