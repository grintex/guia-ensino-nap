<?php

$url = 'https://docs.google.com/document/d/e/2PACX-1vSCLL-r6sWZ5S6frnvYzsqNcmkO-TXtsLBCjmsdbXV0AvdJpSVSbgSuaVqGx4MmUErBdNRpdvm36FJX/pub';
$data_folder = dirname(__FILE__) . '/../data';

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

$raw_content = curl_exec($curl);

if($raw_content === false) {
    echo('Unable to fetch data from main server.');
    exit(1);
}

echo $data_folder;

?>