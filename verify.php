<?php
$access_token = 'cWOQxTGqlQcXRM6o/BakZa9VNahQ/Q5FV2UiqxH93G3Z/Qq1xTGEe4GnUEgcak5W3ks9QmV8SeMUDGbmy1d6yOUBTD71kHqM6sN7M7cHXAfKZ+PuvxINMKICGClKvXMAXvnTvNFHhVacks+qnUVbKwdB04t89/1O/w1cDnyilFU=
';


$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
