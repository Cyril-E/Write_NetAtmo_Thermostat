<?php

// Cyril E      http://www.ituilerie.com
// Ecriture de données au thermostat NetAtmo

// Appel par l'url
// http://xxxxxxxxx/thermostat_write.php?mode=off    pour l'arret
// http://xxxxxxxxx/thermostat_write.php?mode=program           pour passer en mode programme
// http://xxxxxxxxx/thermostat_write.php?mode=away           pour passer en mode absent
// http://xxxxxxxxx/thermostat_write.php?mode=hg           pour passer en mode hors gel
// http://xxxxxxxxx/thermostat_write.php?mode=max&length=120           pour passer en mode max pendant un certain temps (en minutes)  ici 120 minutes
// http://xxxxxxxxx/thermostat_write.php?mode=manual&length=120&consigne=24           pour passer en mode manuel pendant un certain temps (en minutes)  ici 120 minutes a 24°c


$mode=$_GET['mode'];
$length=$_GET['length'];
$consigne=$_GET['consigne'];

$password='xxxx';
$username='xxxx';

$app_id = 'xxxxx';
$app_secret = 'xxxxx';

$token_url = "https://api.netatmo.net/oauth2/token";
$postdata = http_build_query(
        array(
            'grant_type' => "password",
            'client_id' => $app_id,
            'client_secret' => $app_secret,
            'username' => $username,
            'password' => $password,
            'scope' => 'read_station read_thermostat write_thermostat'
    )
);

$opts = array('http' =>
	array(
		'method'  => 'POST',
		'header'  => 'Content-type: application/x-www-form-urlencoded',
		'content' => $postdata
	)
);

$context  = stream_context_create($opts);
$response = file_get_contents($token_url, false, $context);

$params = null;
$params = json_decode($response, true);
$api_url = "https://api.netatmo.net/api/getuser?access_token=" . $params['access_token']."&app_type=app_thermostat";
$requete = @file_get_contents($api_url);

$url_devices = "https://api.netatmo.net/api/devicelist?access_token=" .  $params['access_token']."&app_type=app_thermostat";
$resulat_device = @file_get_contents($url_devices);

$json_devices = json_decode($resulat_device,true);

$device1 = $json_devices["body"]["devices"][0]["_id"];
$module1 = $json_devices["body"]["modules"][0]["_id"];
$device2 = $json_devices["body"]["devices"][1]["_id"];
$module2 = $json_devices["body"]["modules"][1]["_id"];
$device3 = $json_devices["body"]["devices"][2]["_id"];
$module3 = $json_devices["body"]["modules"][2]["_id"];

    
if ($mode=="off") {
	
    $url="/api/setthermpoint?access_token=" . $params['access_token']."&device_id=".$device1."&module_id=".$module1."&setpoint_mode=".$mode;
    
} elseif ($mode=="hg") {
	
		$url="/api/setthermpoint?access_token=" . $params['access_token']."&device_id=".$device1."&module_id=".$module1."&setpoint_mode=".$mode;
	
} elseif ($mode=="away") {    
 
    $url="/api/setthermpoint?access_token=" . $params['access_token']."&device_id=".$device1."&module_id=".$module1."&setpoint_mode=".$mode;
    
} elseif ($mode=="max") {
	
			$endtime = time() + ($length * 60);
      $url="/api/setthermpoint?access_token=" . $params['access_token']."&device_id=".$device1."&module_id=".$module1."&setpoint_mode=".$mode."&setpoint_endtime=".$endtime;      
    
} else {
	
			$endtime = time() + ($length * 60);
    	$url="/api/setthermpoint?access_token=" . $params['access_token']."&device_id=".$device1."&module_id=".$module1."&setpoint_mode=".$mode."&setpoint_endtime=".$endtime."&setpoint_temp=".$consigne;      
    
}



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://api.netatmo.net".$url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);


?>