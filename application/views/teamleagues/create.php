<script type="text/javascript" src="<?=base_url().'application/scripts/teamleagues/create.js';?>"></script>
<?php 
$name = array(
	'name'	=> 'name',
	'maxlength'	=> 80,
	'size'	=> 30
);
$description = array(
	'name'	=> 'desc',
	'rows'	=> 4,
	'cols'	=> 22
);
$userLimit = array(
	'name'	=> 'userLimit',
	'maxlength'	=> 3,
	'size'	=> 5
);
?>
<div id="errors"></div>
<?=form_open($this->uri->uri_string(), array('id'=>'form_fantasy-create'));?>
<table>
	<tr>
		<td><?=form_label('Name', $name['name']); ?></td>
		<td><?=form_input($name); ?></td>
	</tr>
	<tr>
		<td><?=form_label('Description', $description['name']); ?></td>
		<td><?=form_textarea($description); ?></td>
	</tr>
	<tr>
		<td><?=form_label('User Limit', $userLimit['name']); ?></td>
		<td><?=form_input($userLimit); ?></td>
	</tr>
</table>
<?=form_hidden('leagueId', $team_league_id);?>
<?=form_submit('submit', 'Create Fantasy League'); ?>
<?=form_close(); ?>