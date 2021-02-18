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
		'redirect_uri' => 'https://rocketcorerl.com',
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
	header('Location: https://discord.com/api/oauth2/authorize?client_id=693302768340959333&redirect_uri=https%3A%2F%2Frocketcorerl.com&response_type=code&scope=identify%20email');
}

if (get('action') == 'logout') {
	// This must to logout you, but it didn't worked(
	$params = array(
		'access_token' => session('access_token')
	);

	// Redirect the user to Discord's revoke page
	header('content_type:x-www-form-urlencoded', 'Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
	$_SESSION = array();
	header('Location: https://rocketcorerl.com');
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
<!DOCTYPE html>
<html lang="en">
<?php $thisPage = "News"; ?>

<head>
	<meta property="og:type" content="website">
	<meta property="og:title" content="Rocket Core" />
	<meta property="og:description" content="Rocket Core is a Rocket League Tournament and Events Organisation that fosters an enjoyable environment for all it's staff, members and everyone involved. Our aim is to run successful and enjoyable events for the community and have fun doing so!" />
	<meta property="og:url" content="https://rocketcorerl.com" />
	<meta property="og:image" content="https://www.rocketcorerl.com/img/logo_o.png" />
	<meta name="description" content="Rocket Core official website">
	<meta name="keywords" content="Rocket Core,Rocket,Core,Rocket League,League,tournament,tournaments,eu,esports,RC,RCEsports,rocket core esports,rcpluto,rcsaturn,rcjupiter,rcneptune,galactic,series">
	<meta name="author" content="Joren Nagels">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="img/black.png" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
	<title>The Elemental Series 2</title>
	<script type="text/javascript">
		(function() {
			var css = document.createElement('link');
			css.href = 'https://use.fontawesome.com/releases/v5.15.1/css/all.css';
			css.rel = 'stylesheet';
			css.type = 'text/css';
			document.getElementsByTagName('head')[0].appendChild(css);
		})();
	</script>
	<link href="/css/style.css" rel="stylesheet">
	<link href="/css/newsArticle.css" rel="stylesheet">
	<script src="/js/script.js"></script>
</head>

<body>


	<!-- Navigation -->
	<?php require_once "../navbar.php" ?>

	<!-- Body -->

	<article id="rc_lol">
		<header>

			<img src="../img/posters//Posters-orginal/es2.png">
			The Elemental Series 2
		</header>

		<div class="articleBody">
			<p>4 elements with complete disorder brought into control by one common focus; The Elemental Series. Each element has their own background and story, all with their own characteristics, finally culminating into the championship title for their chosen element. These top 16 teams are split into 4 pool to compete for their chosen element!</p>
			<p><h3>Air</h3>
			Having fallen from the sky over 10 years ago, the representatives of the air element pride themselves on their mastery of their aerial mechanics and adaptability in the face of turbulence. They hope to use the power of the championship title to rebuild their rocket’s core and get home.
			</p>
			<p><h3>Water</h3>
			The Water element, the resource of all life. Rising from the deep depths comes a wisdom unknown to all others. Whether it is a tsunami of shots or an elegant stream of passing plays, they are not to be underestimated with their advanced wave dashes and strong teamwork. The representatives of these ancient waters will defend their seas and swallow all who dare face them.			</p>
			<p><h3>Earth</h3>
			The representatives of the earth element have been around since the very beginning. Mastering the ground and passing mechanics, they honour some of key elements in the game, facing any adversaries with ease.			</p>
			<p><h3>Fire</h3>
			Boom! The Fire Element exploded into action many moons ago when they invented the demolition skill within Rocket League. For many years these players have been mastering the art; demonstrating their pure power when necessary and vanquishing their opposition with such speed that all that remains is a heavy smokescreen.			</p>
			<p>Sign up now for the <a href="../events.php">open qualifier</a> to get a chance to compete for one of these elements!</p>
			<p>A total prize pool of $5000 sponsored by <a href="https://antlionaudio.com">Antlion Audio</a> and <a href="https://www.challengermode.com/s/pxb">Phoenix Blue</a>
			</p>
			<p>
			<h3>Prizepool Breakdown</h3>
			<ul>
			<li>1st. place - 3000$</li>
			<li>2nd. place - 1000$</li>
			<li>3nd. and 4th place - 500$</li>
			</ul>
			</p>
			<p>
			<h3>Dates</h3>
			<ul>
			<li>Open Qualifier - 27/02/2021 - 6pm GMT</li>
			<li>Closed Qualifier - 27/02/2021 - 6pm GMT</li>
			<li>Pool 1 - 04/03/2021 - 6pm GMT</li>
			<li>Pool 2 - 05/03/2021 - 6pm GMT</li>
			<li>Pool 3 - 06/03/2021 - 2pm GMT</li>
			<li>Pool 4 - 06/03/2021 - 6pm GMT</li>
			<li>Playoffs- 07/03/2021 - 6pm GMT</li>
			</ul>
			</p>
			<br><br><br><br>
			
		</div>
	</article>


	<!--- footer -->
	<?php require_once "../footer.html" ?>

</body>

</html>