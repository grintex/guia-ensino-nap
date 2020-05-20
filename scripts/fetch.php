<?php

$url = 'https://docs.google.com/document/d/e/2PACX-1vSCLL-r6sWZ5S6frnvYzsqNcmkO-TXtsLBCjmsdbXV0AvdJpSVSbgSuaVqGx4MmUErBdNRpdvm36FJX/pub';
$data_folder = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
$str_content_start = '</style>';


$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

$raw_content = curl_exec($curl);

if($raw_content === false) {
    echo('Unable to fetch data from main server.');
    exit(1);
}

// Extract content
$content_start = strrpos($raw_content, $str_content_start) + strlen($str_content_start);
$content_end = stripos($raw_content, '<div id="footer">');
$content = substr($raw_content, $content_start, $content_end - $content_start);

// Better distribute content
$content = str_replace('<h1', "\n\n<h1", $content);
$content = str_replace('/h1>', "/h1>\n", $content);

// Parse everything
$lines = explode("\n", $content);
$parsed = [];
$section = '';

foreach($lines as $line) {
    if(stripos($line, '<h1') !== false) {
        $section = strip_tags($line);

        if(!isset($parsed[$section])) {
            $parsed[$section] = [];
        }

        continue;
    }

    if(empty($line)) {
        continue;
    }

    $parsed[$section][] = $line;
}

file_put_contents($data_folder . 'conteudo.txt', $content);
file_put_contents($data_folder . 'parsed.txt', print_r($parsed, true));

echo 'Finished!';

?>