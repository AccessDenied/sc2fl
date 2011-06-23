<script type="text/javascript" src="<?=base_url().'application/scripts/jquery.js';?>"></script>
<script src="http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?=base_url().'application/scripts/header.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/header.css';?>" />
<div id="header">
	<h2 class="title">Starcraft 2 Fantasy League (Proof of Concept)</h2>
	<h3 class="title">SkeemEra's Application for WellPlayed.org's Web Developer Position</h3>
	<div class="login">
		<?php if (isset($username) && isset($user_id)): ?>
			Hi, <strong><?php echo $username; ?></strong>! You are logged in now. <?php echo anchor('/auth/logout/', 'Logout'); ?>
		<?php else: ?>
			<?=anchor('auth/login', 'login', 'rel="#overlay"');?><?=anchor('auth/register', 'register');?>
			<!-- overlayed element -->
			<div class="simple_overlay" id="overlay">
				<!-- the external content is loaded inside this tag -->
				<div class="contentWrap"></div>
			</div>
		<?php endif; ?>
	</div>
</div>