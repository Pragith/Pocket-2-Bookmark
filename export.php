<meta charset="UTF-8">
[<?php
	require_once('config.php');

	/* Now we have to convert our request token into an access token */
	// we set up the callback_uri to include the request_token,
	// so let's get that

	$request_token = $_GET['t'];

	$url = 'https://getpocket.com/v3/oauth/authorize';
	$data = array(
		'consumer_key' => $consumer_key, 
		'code' => $request_token
	);
	$options = array(
		'http' => array(
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = @file_get_contents($url, false, $context);
	// our $result contains our access token
	
	$access_token = explode('&',$result);
	if($access_token[0]!=''){
		setcookie("access_token", $access_token[0], time()+3600);
	} else{
		//echo "Something went wrong. :( ";
		$access_token[0] = $_COOKIE["access_token"];
	}

	$access_token = explode("=", $access_token[0]);
	$access_token = $access_token[1];




	/* read the docs!
		by default, I'm just returning the 5 most recent
		pocket items.
		read more here: http://getpocket.com/developer/docs/v3/retrieve
	 */
	$url = 'https://getpocket.com/v3/get';
	$data = array(
		'consumer_key' => $consumer_key, 
		'access_token' => $access_token,
		'detailType' => 'simple',
		'state' => 'all',
		'count' => 3
	);
	$options = array(
		'http' => array(
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = @file_get_contents($url, false, $context);
		
	foreach (json_decode($result)->list as $list) {


?>{	"item_id": "<?= $list->item_id ?>","title":"<?= $list->resolved_title ?>","url":"<?= $list->resolved_url ?>" },<?php	}   ?>]