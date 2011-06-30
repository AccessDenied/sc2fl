<script type="text/javascript" src="<?=base_url().'application/scripts/teamleague/league.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/teamleague/league.css';?>" />
<div id="breadcrumb"><?=anchor('/', 'Home');?> > <?=$teamLeague->get_name();?></div>
<div id="league">
<?php foreach ($matches as $match):?>
	<div class="match">
		<div class="header">
			<div class="date"><?=date( 'M d, Y', strtotime($match->get_date_start()));?></div>
			<?php if (count($match->get_rounds()) > 0 && !is_null($match->get_winner())): ?>
				<?=anchor('teamleague/league/match/'.$match->get_id(), 'view match', 'class="anchor_view-match"');?>
			<?php elseif (count($match->get_rounds()) > 0 && is_null($match->get_winner())): ?>
				<?=anchor('teamleague/league/match/'.$match->get_id(), 'view match (in progress)', 'class="anchor_view-match"');?>
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
<?php $fantasies = $teamLeague->get_fantasies();?>
<table class="fantasies">
	<tr>
		<th class="name">name</th>
		<th class="participation">participation</th>
	</tr>
	<?php foreach (array_slice($fantasies, 0, (sizeOf($fantasies > 5) ? 5 : sizeOf($fantasies))) as $fantasy):?>
		<?php $participantIds = $fantasy->get_participant_ids();?>
		<tr class="fantasy">
			<td class="name"><?=$fantasy->get_name();?></td>
			<td class="participation"><?=sizeOf($participantIds);?> of <?=$fantasy->get_user_limit()?></td>
			<td class="options">
				<?=anchor('teamleagues/fantasy/'.$fantasy->get_id(), 'View', 'class="anchor_fantasy-view"');?>
				<?php if (isset($auth)):?>
					<?php if(in_array($user_id, $participantIds)):?>
						<?=anchor('teamleagues/leave/'.$fantasy->get_id(), 'Leave', 'class="anchor_fantasy-leave"');?>
					<?php else:?>
						<?=anchor('teamleagues/join/'.$fantasy->get_id(), 'Join', 'class="anchor_fantasy-join"');?>
					<?php endif;?>
					<?php if($fantasy->get_owner_id() == $user_id):?>
						<?=anchor('teamleagues/delete/'.$fantasy->get_id(), 'Delete', 'class="anchor_fantasy-delete"');?>
					<?php endif;?>						
				<?php endif;?>
			</td>
		</tr>
	<?php endforeach;?>
</table>
</div>