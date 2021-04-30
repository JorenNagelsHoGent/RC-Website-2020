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
$id = "";
$isEdit = false;

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
    $id = $user->id;
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
if (get('action') == 'edit') {
    $isEdit = true;
}
if (get('action') == 'cancel') {
    $isEdit = false;
    header('Location: https://rocketcore.gg/teams/rl-teams.php');
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
<?php $thisPage = "Teams";

$json = json_decode(file_get_contents("rl-teams.json"), TRUE);

$isAdmin = ($id == 163983231228706817 || $id == 286568795815018508 || $id == 225271321922109440);

?>
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
    <link rel="shortcut icon" type="image/x-icon" href="../img/black.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <title>RC Rocket League</title>
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

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $isAdmin) {

            for ($j = 0; $j < count($json["teams"]); $j++) {
                $teamJson = $json["teams"][$j];
                $teamName = $teamJson["teamName"];

                for ($i = 0; $i < count($teamJson["players"]); $i++) {
                    $player = $teamJson["players"][$i];
                    $tagname = $teamName . '_' . $i;

                    $playerNamePost = $_POST[$tagname];
                    $playerSocialPost = $_POST[$tagname . '_social'];

                    $json["teams"][$j]["players"][$i]["name"] = $playerNamePost == null ? "" : $playerNamePost;
                    $json["teams"][$j]["players"][$i]["social"] = $playerSocialPost == null ? "" : $playerSocialPost;
                }
            }

            if ($json != null) {
                $jsonText = json_encode($json);
                file_put_contents("rl-teams.json", $jsonText);
            }
        }





        $tag = "li ";

        if ($isEdit) {
            $tag = "textarea ";

            echo '
            <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
            ';
        }

        for ($j = 0; $j < count($json["teams"]); $j++) {
            $teamJson = $json["teams"][$j];

            $teamName = $teamJson["teamName"];

            if ($j == 0) {
                echo '<div class="collumn" id="esports">';
            } else if ($j == 1 || $j == 2) {
                echo '<div class="collumn" id="TopTeam">';
            } else {
                echo '<div class="collumn">';
            }

            echo '
            <h2>
               ' . $teamJson["teamName"] . '
                <img src="../img/' . $teamJson["teamLogo"] . '">
            </h2>
            <ul>';

            for ($i = 0; $i < count($teamJson["players"]); $i++) {
                $player = $teamJson["players"][$i];
                $tagname = 'name="' . $teamName . '_' . $i . '';

                if ($player["name"] == "open") {
                    echo '
                    <' . $tag . ' class="open"' . $tagname . '" >open</' . $tag . '>
                     ';
                } else if ($player["name"] == "") {
                    if (!$isEdit) {
                        continue;
                    } else {
                        echo '
                        <textarea ' . $tagname . '" ></textarea>
                         ';
                    }
                } else if ($player["social"] == "") {
                    if ($i == 0) {
                        echo '
                    <' . $tag . ' ' . $tagname . '" class="cap">' . $player["name"] . '</' . $tag . '>
                     ';
                    } else {
                        echo '
                    <' . $tag . ' ' . $tagname . '">' . $player["name"] . '</' . $tag . '>
                    ';
                    }
                } else {
                    if ($isEdit) {
                        echo '
                        <textarea ' . $tagname . '">'  . $player["name"] . '</textarea>
                        ';
                    } else {
                        $socialDomain = str_ireplace('www.', '', parse_url($player['social'], PHP_URL_HOST));
                        $social = explode('.', $socialDomain)[0];
                        if ($i == 0) {
                            echo '
                        <li class="cap"><a href="' . $player["social"] . '" target="_blank">' . $player["name"] . ' <i class="fab fa-' . $social . '"></i></a></li>
                     ';
                        } else {
                            echo '
                        <li><a href="' . $player["social"] . '" target="_blank">' . $player["name"] . ' <i class="fab fa-' . $social . '"></i></a></li>
                    ';
                        }
                    }
                }
                if ($isEdit) {
                    echo '
                    <textarea class="socialTextArea" ' . $tagname . '_social">'  . $player["social"] . '</textarea><br>
                    ';
                }
            }

            echo '
            </ul>
            </div>
            ';
        }
        ?>
    </div>
    <div class="buttons">
        <?php
        if ($isAdmin) {
            if (!$isEdit) {
                echo '<a class="editButton" href="?action=edit">edit</a>';
            } else {

                echo '<a class="editButton" href="?action=cancel">Cancel</a>';
                echo  '<input class="saveButton" type="submit" name="button" value="Save"/></form>';
            }
        }
        ?>
    </div>

    <!--- footer -->
    <?php require_once "../footer.html" ?>




</body>

</html>