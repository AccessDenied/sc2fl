<script type="text/javascript" src="<?=base_url().'application/scripts/teamleague/fantasy/manage.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/teamleague/fantasy/manage.css';?>" />
<?php 
$team_array = array();
foreach ($league->get_teams() as $team) {
	$team_array[$team->get_id()] = $team->get_name();
}
?>
<div id="errors"></div>
<?=form_open($this->uri->uri_string(), array('id'=>'form_fantasy-manage'));?>

<div id="player-drafting">
	<?=form_dropdown('select_team', $team_array);?>
	<div id="instructions">Select up to 8 Players</div>
	<div id="player-draft-selection">
	<?php foreach($league->get_teams() as $team):?>
		<div id="player-list_<?=$team->get_id();?>" class="player-list" style="display:none">
			<?php foreach($team->get_roster() as $player):?>
				<div id="player_<?=$player->get_id();?>" class="player ACTIVE"><?=$player->get_name();?><span class="owned-by"></span></div>
			<?php endforeach;?>
		</div>
	<?php endforeach;?>
	</div>
	<div id="player-draft">
		<div class="title">Your Drafted Players</div>
		<div class="player-drafts"></div>
	</div>
</div>
<div id="team-drafting">
	<div class="team-title">Select One Team</div>
	<?php foreach ($league->get_teams() as $team):?>
		<div class="radio_team-draft"><?=form_radio('radio_team', $team->get_id(), (isset($team_id) && ($team_id == $team->get_id())) ? TRUE : FALSE);?><?=$team->get_name();?></div>
	<?php endforeach;?>
</div>
<?=form_hidden('fantasy_id', $fantasy->get_id());?>
<?=form_hidden('user_id', $user_id);?>
<?=form_submit('submit', 'Confirm Changes'); ?>
<?=form_close(); ?>