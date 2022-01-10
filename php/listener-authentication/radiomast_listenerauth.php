<?php
/*

Radio Mast Custom Listener Authentication Webhook handler with PHP
================================================

This example is a backend for "Custom Listener Authentication", that allows you to require authentication before listeners
can tune into your Radio Mast stream.

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
$listener_count = post_var('ip');	//The current listener count on the mount, excluding the pending new listener.
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

//Validate token
if ($token == 'foo') {
    //Token is valid, allow the listener to connect.
    header('icecast-auth-user: 1');
    header('preroll: ' . PREROLL_URL);
    return;
}
//Token was invalid, deny the listener.
header('icecast-auth-user: 0');

?>