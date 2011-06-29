<script type="text/javascript" src="<?=base_url().'application/scripts/teamleagues/fantasy.js';?>"></script>
<input id="input_fantasy-id" type="hidden" name="fantasyId" value="<?=$fantasy->get_id()?>"/>
<?php $team_statistics = $statistics->get_team_statistics();?>
<?php $player_statistics = $statistics->get_player_statistics();?>
<?php foreach ($statistics->get_teams() as $team):?>
	<div><?=$team->get_name();?> wins:<?=$team_statistics[$team->get_id()]->get_wins()?> losses:<?=$team_statistics[$team->get_id()]->get_losses()?></div>
<?php endforeach;?>
<p/>
<?php foreach ($statistics->get_players() as $player):?>
	<div><?=$player->get_name();?> <?=$player_statistics[$player->get_id()]->get_wins()?>/<?=$player_statistics[$player->get_id()]->get_losses()?> <?=$player_statistics[$player->get_id()]->get_total_points()?></div>
<?php endforeach;?>

<?=anchor('teamleagues/manage/'.$fantasy->get_id(),'manage your team','rel="#overlay_fantasy-manage"');?>
<!-- overlayed element -->
<div id="overlay_fantasy-manage" class="overlay">
	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>
</div>