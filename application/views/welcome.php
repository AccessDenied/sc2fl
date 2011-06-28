<link rel="stylesheet" type="text/css" href="<?=base_url().'application/css/welcome.css';?>" />
<script type="text/javascript" src="<?=base_url().'application/scripts/welcome.js';?>"></script>
<?php foreach ($teamLeagues as $league): ?>
	<?php $fantasies = $league->get_fantasies();?>
	<div class="fantasy-league">
		<?=anchor('teamleagues/league/'.$league->get_id(), $league->get_name(), 'class="anchor_league"');?>
		<div class="fl-content">
			<div class="fantasy-auth">
				<?php if (isset($auth)): ?>
					<?=anchor('teamleagues/create/'.$league->get_id(), 'Create New Fantasy League', array('rel'=>'#overlay_fantasy-create'))?>
					<!-- overlayed element -->
					<div id="overlay_fantasy-create" class="overlay">
						<!-- the external content is loaded inside this tag -->
						<div class="contentWrap"></div>
					</div>
				<?php else: ?>
					Please log in to create or participate in a fantasy league.
				<?php endif; ?>
			</div>
			<div class="fantasy-size"><?=sizeOf($fantasies);?> <font size="0.8em">fantasy leagues created</font></div>
			<div class="statistics">
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
							<?=anchor('#', 'View', 'class="anchor_fantasy-delete"');?>
							<?php if (isset($auth)):?>
								<?php if(in_array($user_id, $participantIds)):?>
									<?=anchor('#', 'Leave', 'class="anchor_fantasy-leave"');?>
								<?php else:?>
									<?=anchor('#', 'Join', 'class="anchor_fantasy-join"');?>
								<?php endif;?>
								<?php if($fantasy->get_owner_id() == $user_id):?>
									<?=anchor('#', 'Delete', 'class="anchor_fantasy-delete"');?>
								<?php endif;?>						
							<?php endif;?>
						</td>
					</tr>
				<?php endforeach;?>
				</table>
				<?=anchor('teamleagues/league/'.$league->get_id(), 'View All Fantasy Leagues');?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<div id="intro">
<h2>Introduction</h2>
<blockquote>
I was confident when I pre-ordered my copy of Starcraft 2: Wings of Liberty.  Confident that the game would live up to my expectations that came with growing up playing Brood War.  On release night, I stood in line with two good friends whom I had convinced to invest in the game as well.  It had been awhile since I had even purchased a video game but to me it was pretty much mandatory to buy SC2 out of principle for my childhood.  What I didn't know at the time was how passionate I would grow for the game and how much it would resonate with my life.  When I first started playing, I was bad... terribad.  My only hope was to desperately see how other people were playing the game, to try and compare them to what I was doing wrong.  I initially tried watching in-game replays but having to restart SC2 every time got aggravating.  I looked to the internet for a solution and was quickly exposed to HDStarcraft, Husky and their HDH Invitational which was actually my first exposure to game casting.  I started learning about players, other casters, build orders and tournaments through these casts.  When there were no new casts to watch I began to search for more, finding other landmarks like Day[9], the GSL, and teamliquid.  I purchased passes to all GSL/GSTL seasons, MLG, and NASL.  My first perception of teamliquid was that it looked crammed and confusing and I stayed away.  With more searching I was baffled how difficult it was to find information on things like build orders, valid strategies, tournaments, live game feeds, videos, etc on the game at a single source or website.  I decided to make my own site, StarcraftCollective.  It was built in January and used by myself and a few friends up until about a month ago (which is where this domain comes from).  I programmed the site to automatically grab recent podcasts, live casts, latest VODs posted by my favorite personalities, the ability to create tournaments (using Challonge.com's Developer API), a forum, and even race specific build orders.  The site never got to the point where I would have been comfortable advertising on reddit and soon enough sites like WellPlayed.org and WarpPrism.com came along and I felt comfortable retiring StarcraftCollective.  It was a hard decision, but I was also just glad to see that other well-accepted sites had filled that gap that was missing for so long.  Fast forward to a few days ago, when WellPlayed.org released a statement saying that they were looking for new talent, including web developers.  Yelling expletives to disbelief, I created an account and made my first post to the announcement under the name 'SkeemEra'.  To me, it was a culmination of my passion for Starcraft 2, I want to help the scene so badly and I'd love nothing more than to use my experience with web development to do it.  I have been looking for an outlet to fill my passion for the Starcraft 2 and e-sports since shortly after I saw my first HDstarcraft cast over a year ago and to me volunteering at WellPlayed.org is such a perfect opportunity.  I hope to prove to you here that I am someone whom you can proudly add to your development team.
</blockquote>
<blockquote>
After reading the specific requirements listed for your Web Developer positions, I realized that you were looking for someone with PHP and (preferably) CodeIgniter experience.  Although I have built multiple applications and websites using PHP, I had no experience with CodeIgniter.  I spent a few hours brainstorming and came up with an idea for this proof of concept application.  I think it is important for me to iterate that I started this site from scratch two days ago.  I didn't have a PHP environment setup on my machine at home, I didn't know what CodeIgniter was, I didn't have an idea or concept of what I wanted to create, and I hadn't written this long introduction.  As a little disclaimer, this is a functioning example but only as a Proof of Concept.  Currently, this application shows basic functionality with how a tournament might be laid out for the Fantasy League.  Users can't actually draft players, but the tournament and back end itself is written.  With more time, this could be developed into a fully functional Fantasy League (if it's even something you guys are even interested in).  I don't want to come off like I am trying to push features for the site, I just chose this to showcase that I am a qualified developer to code with PHP in conjunction with CodeIgniter.  Without further ado, I present a PHP CodeIgniter built website: Starcraft 2 Fantasy League (Proof of Concept).
</blockquote>
<h3>The Idea (in bullet points)</h3>
<blockquote>
Create a  fantasy league for Starcraft 2 similar to fantasy leagues for NFL and other major sports.<br/>
Bring a fun new way to participate/spectate in online tournaments to users of WellPlayed.org.<br/>
Start collecting data and statistics on wins/losses of both pro-gamers and teams outside of battle.net ladder statistics.<br/>
Allow users to quickly access details, information, and highlights on SC2 teams as well as pro-gamers.<br/>
Offer users a way to get more involved into e-sports.<br/>
Users can create their own league and invite their friends to compete against each other privately, not just one league for the whole site of WP.org<br/>
</blockquote>
<h3>Brainstorm Functionality</h3>
<p>
<h4>Fantasy League for Team Tournaments</h4>
<blockquote>
Users will draft 1 team that they think will perform well in the tournament.<br/>
Users will draft 1 team that they think will perform poorly in the tournament.<br/>
Multiple users can have the same team.<br/>
Users will draft 8 players that they think will perform well in the tournament.<br/>
Users will draft 8 players that they think will perform poorly in the tournament.<br/>
</blockquote>
<blockquote>
Multiple users cannot have the same players in their respective pools.  For example, two users wouldn't be able to draft IdrA to perform well.  However, a user can draft IdrA to perform well, and another can draft him to perform poorly.<br/>
Players have valuation based on previous performance to give inexperienced users the ability to make wise draft choices. <br/>
A draft is selected for a specific time.  If a player does not log in for their league's draft, their draft picks will be determined programmatically.<br/>
The winner of the fantasy league will have obtained the highest point score.<br/>
Users will get points when their team wins and when their players perform well (get wins, streaks, snipes, etc).<br/>
Users will lose points when a team or player they've drafted to do poorly does well.<br/>
</blockquote>
<h4>Fantasy League for Regular Individual/Bracket Tournaments</h4>
<blockquote>
Amount of players draftable by users and points based from player progression are based on the size of the tournament.<br/>
Player formula is: (TournamentSize > 32) ? 8 : Math.floor(TournamentSize / 4);<br/>
So a tournament of 32 total players would mean 8 drafted players per user. (30 = 7, 28 = 7, 26 = 6, 24 = 6 and so on). <br/>
A tournament must have more than 4 competitors to be enlisted in the system.<br/>
In this type of fantasy league, no one player can be reserved to a user (multiple users can have the same player).<br/>
There will be no trading after the start of the tournament.<br/>
Player progress is distinguished by the amount of rounds.  Total points given per progression in the tournament tournament will be dependent on the amount of rounds.  Each consecutive successful progression will add a point onto the progression.<br/>
For example:  In the 4-Round Dreamhack playoffs I drafted LiquidHuK to perform well:<br/>
In the first round I was awarded 1 point, second round 2, third 3, and fourth I was awarded 4.<br/>
On the flip side, if any players that I drafted to perform poorly progress, I get those points detracted from my total score.<br/>
For example: In the 4-round Dreamhack playoffs, I drafted Bomber to do poorly:<br/>
First round I was detracted 1 point, second round 2, and the third round he was eliminated so no points detracted or added.<br/>
Players drafted for good performance - reward points, do not detract if they get taken out.<br/>
Players drafted for poor performance - detract points, do not reward when taken out.<br/>
</blockquote>
<h3>Match Predictions (both fantasy leagues)</h3>
<blockquote>
Users will be given the option to bet points with match predictions.  This feature is optional because we can’t expect every league member to be around for an entire length of a tournament to be able to put in their predictions.  The advantage to doing this, is that an accurate prediction is worth 1 point, where an inaccurate prediction will detract 1 point.  A potentially risky maneuver that could make or break a tournament.  This feature can be disabled by a league administrator.
</blockquote>
</div>