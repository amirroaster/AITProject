<?php

$ch = curl_init();

$documentID = 'aitprMobileFoodSchedule31101d2d6';

curl_setopt($ch, CURLOPT_URL, 'http://localhost:5984/aitproject/'.$documentID);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Content-type: application/json',
	'Accept: */*'
));
curl_setopt($ch, CURLOPT_USERPWD, 'admin:admin123');

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>