<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', '693302768340959333');
define('OAUTH2_CLIENT_SECRET', 'fHz8V1gGLg7AqotaTV4UwRyFO05UOpfH');

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';

session_start();

// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if (get('code')) {

	// Exchange the auth code for a token
	
	$token = apiRequest($tokenURL, array(
		"grant_type" => "authorization_code",
		'client_id' => OAUTH2_CLIENT_ID,
		'client_secret' => OAUTH2_CLIENT_SECRET,
		'redirect_uri' => 'https://rocketcore.gg',
		'code' => get('code')
	));
	$logout_token = $token->access_token;
	$_SESSION['access_token'] = $token->access_token;


	header('Location: ' . $_SERVER['PHP_SELF']);
}

if (session('access_token')) {
	$user = apiRequest($apiURLBase, array());
	$avatarURL = "https://cdn.discordapp.com/avatars/" . $user->id . "/" . $user->avatar . ".png";
}
if (get('action') == 'login') {
	header('Location: https://discord.com/api/oauth2/authorize?client_id=693302768340959333&redirect_uri=https%3A%2F%2Frocketcore.gg&response_type=code&scope=identify%20email');
}

if (get('action') == 'logout') {
	// This must to logout you, but it didn't worked(
	$params = array(
		'access_token' => session('access_token')
	);

	// Redirect the user to Discord's revoke page
	header('content_type:x-www-form-urlencoded', 'Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
	$_SESSION = array();
	header('Location: https://rocketcore.gg');
}

function apiRequest($url, $post = FALSE, $headers = array())
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$response = curl_exec($ch);


	if ($post)
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

	$headers[] = 'Accept: application/json';

	if (session('access_token'))
		$headers[] = 'Authorization: Bearer ' . session('access_token');

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$response = curl_exec($ch);
	return json_decode($response);
}

function get($key, $default = NULL)
{
	return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default = NULL)
{
	return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

?>
<?php $thisPage = "Home"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta property="og:type" content="website">
	<meta property="og:title" content="Rocket Core" />
	<meta property="og:description" content="Rocket Core is a Rocket League Tournament and Events Organisation that fosters an enjoyable environment for all it's staff, members and everyone involved. Our aim is to run successful and enjoyable events for the community and have fun doing so!" />
	<meta property="og:url" content="https://rocketcore.gg" />
	<meta property="og:image" content="https://www.rocketcore.gg/img/logo.png" />
	<meta name="description" content="Rocket Core is a Rocket League Tournament and Events Organisation that fosters an enjoyable environment for all it's staff, members and everyone involved. Our aim is to run successful and enjoyable events for the community and have fun doing so!">
	<meta name="keywords" content="Rocket Core,Rocket,Core,Rocket League,League,tournament,tournaments,eu,esports,RC,RCEsports,rocket core esports,rcpluto,rcsaturn,rcjupiter,rcneptune,galactic,series">
	<meta name="author" content="Joren Nagels">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/black.png" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
	<title>Rocket Core</title>
	<script type="text/javascript">
		(function() {
			var css = document.createElement('link');
			css.href = 'https://use.fontawesome.com/releases/v5.15.1/css/all.css';
			css.rel = 'stylesheet';
			css.type = 'text/css';
			document.getElementsByTagName('head')[0].appendChild(css);
		})();
	</script>
	<link href="css/style.css" rel="stylesheet">
	<link href="css/home.css" rel="stylesheet">
	<script src="js/script.js"></script>
</head>

<body>


	<!-- Navigation -->
	<?php require_once "navbar.php" ?>


	<!-- Body -->
	<div class="BG" id="BG1">
		<div class="main" id="home">
			<h1>Rocket Core</h1>
			<p>Our mission is to create opportunities for players by hosting professional esports events!</p>
		</div>
		<a href="#BG2" class="scroll">
			Rocket League
			<i class="fas fa-angle-double-down"></i>
		</a>
	</div>

	<div class="BG" id="BG2">
		<div class="main" id="rl">
			<h1>Rocket League</h1>
			<p>We offer a variety of Rocket League events, from our own weekly tournaments to our fully fletched professional events! Click <a href="./events.php">here</a> to see our current events.</p>
			<br>
			<p>Outside our events we also offer players to represent us by having our own esports teams! Click <a href="./teams/rl-teams.php">here</a> to see the current roster.</p>

		</div>
		<a href="#BG3" class="scroll">
			League of Legends
			<i class="fas fa-angle-double-down"></i>
		</a>
	</div>

	<div class="BG" id="BG3">
		<div class="main" id="lol">
			<h1>League of Legends</h1>
			<p>We have a wide variety of League of legends teams ranging from small community teams to our top-tier esports teams with professional coaching and managing!</p>
			<br>
			<p>Do you think you have what it takes to join? Fill in an application and you'll soon be playing for Rocket Core Esports! Click <a href="./teams/lol-teams.php">here</a> to see the current roster.</p>

		</div>
	</div>


	<!--- footer -->
	<?php require_once "footer.html" ?>
</body>

</html>