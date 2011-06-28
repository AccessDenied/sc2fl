<script type="text/javascript" src="<?=base_url().'application/scripts/jquery.js';?>"></script>
<script type="text/javascript" src="<?=base_url().'application/scripts/jquery.tools.min.js';?>"></script>
<script type="text/javascript" src="<?=base_url().'application/scripts/header.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/header.css';?>" />
<div id="header">
	<h2 class="title">Starcraft 2 Fantasy League (Proof of Concept)</h2>
	<h3 class="subtitle">SkeemEra's Application for WellPlayed.org's Web Developer Position</h3>
	<div class="login">
		<?php if (isset($username) && isset($user_id)): ?>
			Hi, <strong><?php echo $username; ?></strong>! <?php echo anchor('/auth/logout/', 'Logout'); ?>
		<?php else: ?>
			<?=anchor('auth/login', 'login',  array('rel'=>'#overlay_login'));?> or <?=anchor('auth/register', 'register');?>
			<!-- overlayed element -->
			<div id="overlay_login" class="overlay">
				<!-- the external content is loaded inside this tag -->
				<div class="contentWrap"></div>
			</div>
		<?php endif; ?>
	</div>
</div>