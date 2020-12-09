<nav>
	<a class="logo" href="./"><img src="/img/logo.png" width=55px></a>
	<div class="whitespace"></div>
	<ul>
		<li><a <?php if ($thisPage == "Home")
					echo " class=\"active\""; ?> href="./">Home</a></li>
		<li><a <?php if ($thisPage == "News")
					echo " class=\"active\""; ?>href="news.php">News</a></li>
		<li><a <?php if ($thisPage == "Events")
					echo " class=\"active\""; ?>href="events.php">Events</a></li>
		<li><a <?php if ($thisPage == "Teams")
					echo " class=\"active\""; ?>href="teams.php">Teams</a></li>
		<li><a <?php if ($thisPage == "Contact")
					echo " class=\"active\""; ?>href="contact.php">Contact</a></li>
	</ul>
	<div class="whitespace"></div>
	<?php
	if (session('access_token')) {
		echo '<a onclick=reveal() class="avatarBtn" href="#"><img class="avatar" src=' . $avatarURL . '></a>
		<div class="menu-content">
		<div class="profile"><img class="avatarDropdown" src=' . $avatarURL . '>'. $user->username .'</div>
		<hr>
		<div class="icon"><i class="fas fa-sign-out-alt"></i></div><a href="?action=logout">Logout</a>
		</div>
		';
	} else {
		echo '<a class="login" href="?action=login">login</a>';
	}

	?>

</nav>