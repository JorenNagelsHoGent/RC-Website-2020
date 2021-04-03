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
<?php $thisPage = "Teams"; ?>
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
    <title>Rocket Core Esports</title>
    <script type="text/javascript">
        (function() {
            var css = document.createElement('link');
            css.href = 'https://use.fontawesome.com/releases/v5.15.1/css/all.css';
            css.rel = 'stylesheet';
            css.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/teams.css" rel="stylesheet">
    <script src="../js/script.js"></script>
</head>

<body>


    <!-- Navigation -->

    <?php require_once "../navbar.php" ?>

    <article>
        Follow our Official Rocket Core Esports Twitter <a href="https://twitter.com/RocketCore_GG" target="_blank">@RocketCore_GG <i class="fab fa-twitter"></i></a>
        <br><br>
        Click <a href="https://docs.google.com/forms/d/e/1FAIpQLScqTdWdB6TBqq3rH5gPvFMw7jJRP_su4kHbFtDurbgI0WlsSw/viewform" target="_blank">here </a>if you want apply!
    </article>
    <!-- Body -->
    <div class="teams">
        <div class="collumn" id="esports">
            <h2>Esports
                <img src="../img/logo.png">
            </h2>
            <ul>
                <li class="open">open</li>
            </ul>
        </div>
        <div class="collumn" id="topTeam">
            <h2>Jupiter
                <img src="../img/jupiter_emoji.png">
            </h2>
            <ul>
                <li class="cap"><a href="https://twitter.com/its_Xynal" target="_blank">Xynal <i class="fab fa-twitter"></i></a></li>
                <li class="open">open</li>
                <li class="open">open</li>
            </ul>
        </div>
        <div class="collumn" id="topTeam">
            <h2>Venus
                <img src="../img/venus_emoji.png">
            </h2>
            <ul>
            <li class="cap"><a href="https://twitter.com/JonasBaecker" target="_blank">Snips <i class="fab fa-twitter"></i></a></li>
                <li class="open">open</li>
                <li class="open">open</li>
            </ul>
        </div>
        <div class="collumn">
            <h2>Saturn
                <img src="../img/saturn_emoji.png">
            </h2>
            <ul>
                <li class="cap"><a href="https://twitter.com/AnacaPlays" target="_blank">Anaca <i class="fab fa-twitter"></i></a></li>
                <li><a href="https://twitter.com/sv_pigey" target="_blank">sv_pigey <i class="fab fa-twitter"></i></a></li>
                <li><a href="https://twitter.com/" target="_blank">Zillion <i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>
        <div class="collumn">
            <h2>Neptune
                <img src="../img/neptune_emoji.png">
            </h2>
            <ul>
                <li class="cap"><a href="https://twitter.com/Reen_rl" target="_blank">Reen <i class="fab fa-twitter"></i></a></li>
                <li><a href="https://twitter.com/Ju4life" target="_blank">Ju4life <i class="fab fa-twitter"></i></a></li>
                <li><a href="https://twitter.com/VenniinaRL" target="_blank">Venni <i class="fab fa-twitter"></i></a></li>
                <li>Jimmy</li>
                <li><a href="https://twitter.com/Neyzexrl" target="_blank">Neyzex <i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>
        <div class="collumn">
            <h2>Pluto
                <img src="../img/pluto_emoji.png">
            </h2>
            <ul>
                <li class="cap"><a href="https://twitter.com/BlitzLeague_" target="_blank">BlitzLeague <i class="fab fa-twitter"></i></a></li>
                <li><a href="https://twitter.com/Jariz_RL" target="_blank">Jariz <i class="fab fa-twitter" target="_blank"></i></a></li>
                <li><a href="https://twitter.com/TheBestPikachu" target="_blank">Cookies <i class="fab fa-twitter"></i></a></li>
                <li><a href="https://twitter.com/axdux_rl" target="_blank">Axdux <i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>
        <div class="collumn">
            <h2>Mars
                <img src="../img/rook_emoji.png">
            </h2>
            <ul>
                <li class="cap"><a href="https://twitter.com/GalacticQ_" target="_blank">GalacticQ <i class="fab fa-twitter"></i></a></li>
                <li>Kunisay</li>
                <li>Callum</li>
            </ul>
        </div>
    </div>


    <!--- footer -->
    <?php require_once "../footer.html" ?>

</body>

</html>