<nav>
	<a class="logo" href="./"><img src="/img/logo.png" width=50px></a>
	<div class="whitespace"></div>
	<ul class="navbar" id="navbarID">
		<li><a <?php if ($thisPage == "Home")
					echo " class=\"active\""; ?> href="../index.php">Home</a></li>
		<li><a <?php if ($thisPage == "News")
					echo " class=\"active\""; ?>href="../news.php">News</a></li>
		<li><a <?php if ($thisPage == "Events")
					echo " class=\"active\""; ?>href="../events.php">Events</a></li>
		<li><a clas="teams" <?php if ($thisPage == "Teams")
								echo " class=\"active\" "; ?> onclick="navbar('teams-menu','teams-menu')" href='javascript:void(0);'>Teams <i class="fas fa-caret-down"></i></a>
			<div class="teams-menu" id="teams-menu">
				<div class="game"><img src="../img/RL-emoji.png" alt="RL" width="40px"><a href="../teams/rl-teams.php">Rocket League</a></div>
				<div class="game"><img src="../img/LOL-emoji.png" alt="LOL" width="34px"><a href="../teams/lol-teams.php">League of Legends</a></div>
			</div>
		</li>
		<li id="contact"><a <?php if ($thisPage == "Contact")
					echo " class=\"active\""; ?>href="../contact.php">Contact</a></li>
	</ul>
	<div class="whitespace"></div>

	<?php
	if (session('access_token')) {
		echo '<a onclick="navbar(\'menu-content\', \'menu-content\')" href="javascript:void(0);" class="avatarBtn"><img class="avatar" src=' . $avatarURL . '></a>
		<div class="menu-content" id="menu-content">
		<div class="profile"><img class="avatarDropdown" src=' . $avatarURL . '>' . $user->username . '</div>
		<hr>
		<div class="icon"><i class="fas fa-sign-out-alt"></i></div><a href="?action=logout">Logout</a>
		</div>
		';
	} else {
		echo '<a class="login" href="?action=login">login</a>';
	}

	?>
	<div class="navIcon">
		<a href="javascript:void(0);" onclick="navbar('navbarID', 'navbar')"><i class="fas fa-bars"></i></a>
	</div>
</nav>