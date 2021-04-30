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

function apiRequest($url, $post, $headers = array())
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
<?php $thisPage = "Events"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta property="og:type" content="website">
    <meta property="og:title" content="Rocket Core" />
    <meta property="og:description" content="Rocket Core is a Rocket League Tournament and Events Organisation that fosters an enjoyable environment for all it's staff, members and everyone involved. Our aim is to run successful and enjoyable events for the community and have fun doing so!" />
    <meta property="og:url" content="https://rocketcore.gg" />
    <meta property="og:image" content="https://www.rocketcore.gg/img/logo.png" />
    <meta name="description" content="Rocket Core official website">
    <meta name="keywords" content="Rocket Core,Rocket,Core,Rocket League,League,tournament,tournaments,eu,esports,RC,RCEsports,rocket core esports,rcpluto,rcsaturn,rcjupiter,rcneptune,galactic,series">
    <meta name="author" content="Joren Nagels">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/black.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <title>Rocket Core Events</title>
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
    <link href="css/events.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>

<body>


    <!-- Navigation -->

    <?php require_once "navbar.php" ?>

    <!-- Body -->
    <div class="content">

        <!-- Template START-->
        <!-- 
			<div class="newsCard">
                <img src="img/posters/">
                <div class="info">
                    <header></header>
                    <div class="description">
                   

                    </div>
                    <div class="date">Monday 16 November 2020</div>
                    <a class="button" href="">Sign up</a>
                </div>
            </div>

		 -->
        <!-- Template END -->


        <div class="newsCard" id="noEvent">
            <div class="info">
                <header>We are currently not hosting any events!</header>
                <div class="description">
                <br>
                Follow us on Social Media to stay up to date about any upcoming events

                </div>
                <a class="button" href="">Discord</a>
            </div>
        </div>



        <!-- <div class="newsCard">
            <img src="img/posters/es2_open.png">
            <div class="info">
                <header>Elemental Series 2 - Open Qualifier</header>
                <div class="description">
                   Open double elemination bracket where the top 32 teams qualify for the Closed Qualifier!

                </div>
                <div class="date">Saturday 27 February 2021</div>
                <a class="button" href="https://www.challengermode.com/s/RocketCore/tournaments/cfd828c3-36c7-42c7-b6dc-08d8cdacc17b">Sign up</a>
            </div>
        </div>
        <div class="newsCard">
            <img src="img/posters/es2_closed.png">
            <div class="info">
                <header>Elemental Series 2 - Closed Qualifier</header>
                <div class="description">
                   Closed double elemination bracket where the top 8 teams qualify for the main event!

                </div>
                <div class="date">Sunday 28 February 2021</div>
                <a class="button" href="https://twitch.tv/rocket_core">Watch live!</a>
            </div>
        </div>
        <div class="newsCard">
            <img src="img/posters/es2_finals.png">
            <div class="info">
                <header>Elemental Series 2</header>
                <div class="description">
                   This is the second season of the Elemental Series! 8 invited and 8 qualified all playing for a chance to win that big prizepool of 5000$!

                </div>
                <div class="date">Thursday 4 March 2021 - Sunday 7 March 2021</div>
                <a class="button" href="https://twitch.tv/rocket_core">Watch live!</a>
            </div>
        </div> -->

        <!-- <div class="newsCard">
            <img src="../img/posters/RCWeekly_antlion.png">
            <div class="info">
                <header>Rocket Core Weekly</header>
                <div class="description">
                    A Weekly 3V3 Rocket League tournament with a €75 prize pool!

                </div>
                <div class="date">Every Monday at 6pm GMT</div>
                <a class="button" href="http://weekly.rocketcore.gg">Sign up</a>
            </div>
        </div>
        <div class="newsCard">
            <img src="img/posters/poisonpit.png">
            <div class="info">
                <header>The Poison Pit</header>
                <div class="description">
                    An 8 week long season of 1V1 tournaments every week with a total of €200 prize pool!

                </div>
                <div class="date">Every Thursdat at 6pm GMT</div>
                <a class="button" href="http://cm.rocketcore.gg">Sign up</a>
            </div>
        </div> -->



    </div>


    <!--- footer -->
    <?php require_once "footer.html" ?>

</body>

</html>