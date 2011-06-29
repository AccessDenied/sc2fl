<script type="text/javascript" src="<?=base_url().'application/scripts/teamleagues/manage.js';?>"></script>
<?php 
$team_array = array();
foreach ($league->get_teams() as $team) {
	$team_array[$team->get_id()] = $team->get_name();
}
?>
<div id="errors"></div>
<?=form_open($this->uri->uri_string(), array('id'=>'form_fantasy-manage'));?>

<?=form_dropdown('select_team', $team_array);?>
<?php foreach($league->get_teams() as $team):?>
	<div id="player-list_<?=$team->get_id();?>" class="player-list" style="display:none">
		<?php foreach($team->get_roster() as $player):?>
			<div id="player_<?=$player->get_id();?>" class="player ACTIVE"><?=$player->get_name();?></div>
		<?php endforeach;?>
	</div>
<?php endforeach;?>
<?=form_hidden('fantasy_id', $fantasy->get_id());?>
<?=form_submit('submit', 'Confirm Changes'); ?>
<?=form_close(); ?>
<div id="player-draft">
	<div class="title">Your Drafted Players</div>
	<div class="player-drafts"></div>
</div>
