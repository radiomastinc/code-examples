<?php
/*

Radio Mast Custom Listener Authentication Webhook handler with PHP
================================================

This example is a backend for "Custom Listener Authentication", that allows you to require authentication before listeners
can tune into your Radio Mast stream.

This variant of the example includes a list of accounts (username/password pairs) that are allowed to connect, as well
as an IP ban list for blocking listeners from certain IPs. Lastly, this example also implements a banlist for user agents,
allowing you to block certain players or bots.

To use this PHP script, you will need to create a Radio Mast stream and set the "Listener Authentication" to "Custom",
and then set the URL to point to this script. You need to host this script on your own webserver.

For more information on Custom Listener Authentication, see the documentation at:
https://www.radiomast.io/docs/streaming-network/custom-listener-authentication.html

*/

// Optional: Specify a preroll jingle that plays before listeners connect.
define('PREROLL_URL', 'http://myurl/preroll.mp3');

function post_var($key, $default=NULL) {
    return isset($_POST[$key]) && !empty($_POST[$key]) ? $_POST[$key] : $default;
}

if (post_var('action') != 'listener_add') {
    die("Invalid action parameter.");
}

$mount =    post_var('mount');  	//Mount the listener is connecting to.
$server =   post_var('server'); 	//IP of the streaming server.
$port =     post_var('port');  		//Port the listener is connecting to
$ip =       post_var('ip');			//IP of the listener.
$client =   post_var('client');		//A unique 64-bit integer that identifies this listener for the duration of the connection
$agent =   	post_var('agent');		//The HTTP user-agent header provided by the listener.
$referer = post_var('referer');  	//The HTTP referer header provided by the listener.
$listener_count = post_var('listener-count');	//The current listener count on the mount, excluding the pending new listener.
$user =     post_var('user');		//Username provided by the listener (via HTTP Basic Authentication).
$password = post_var('pass');   	//Password provided by the listener.
$listener_duration_24hr = post_var('listener-duration-1day'); //24 hour cumulative listening time for this listener (seconds)
$listener_duration_7day = post_var('listener-duration-7day'); //7 day cumulative listening time for this listener (seconds)
$token = '';

//Optional: Extract querystring parameters, if present
if (strpos($mount, '?') !== false) {
    parse_str(substr($mount, strpos($mount, '?')+1), $qs_params);
    //$qs_params now contains all the querystring parameters. For example, you can use this for extracting a
    //token in the URL to implement token authentication.
    $token = $qs_params['token'];
}

//List of credentials. This is a toy example. You should implement password hashing for production use.
$credentials = array(
    "user1" => "pass1",
    "user2" => "pass2",
);

//List of banned IPs
$ip_banlist = array(
    "64.123.123.252",
    "62.231.23.23",
);

//List of credentials for listeners. This is a toy example.
$useragent_banlist = array(
    "curl/7.55.1",
    "Some other user agent"
);

//Make web browsers prompt for username/password.
header('icecast-www-authenticate: Basic realm="My Radio Station", charset="UTF-8"');

//Check listener IP against the ban list
if (array_key_exists($ip, $ip_banlist)) {
    //IP is in the banlist, deny it
    header('icecast-auth-user: 0');
    return;
}

//Check the user agent against the ban list.
if (array_key_exists($agent, $useragent_banlist)) {
	//User agent is found in our blacklist - block the listener.
	header('icecast-auth-user: 0');
	return;
}

//Validate credentials
if (array_key_exists($user, $credentials)) {

    if ($credentials[$user] === $password) {
        //Credentials match, allow the broadcaster to connect.
        header('icecast-auth-user: 1');
        return;
    }
}

//Credentials didn't match or weren't found, don't allow the broadcaster to connect.
header('icecast-auth-user: 0');

?>
