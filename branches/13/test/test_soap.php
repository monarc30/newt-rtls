<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://192.168.1.10:8550/epe/eve/eventstream");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
curl_setopt($ch, CURLOPT_USERPWD, "rtls_user:welcome");
curl_setopt($ch, CURLOPT_BUFFERSIZE, 20);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$fh = fopen("log.txt", "a");
curl_setopt($ch, CURLOPT_FILE, $fh);
curl_exec($ch);

/*
while($buffer = curl_exec($ch)) {
    fwrite($fh,$buffer);
}
*/
fclose($fh);

curl_close($ch);
?>